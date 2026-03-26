<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    private string $baseUrl = 'https://api.notchpay.co';

    public function checkout(Rental $rental)
    {
        abort_if($rental->user_id !== auth()->id(), 403);
        $alreadyPaid = $rental->payments()->where('status','paid')->exists();
        return view('client.payments.checkout', compact('rental', 'alreadyPaid'));
    }

    public function initiate(Request $request, Rental $rental)
    {
        abort_if($rental->user_id !== auth()->id(), 403);

        $request->validate([
            'method' => 'required|in:mobile_money,card',
            'phone'  => 'required_if:method,mobile_money|nullable|string',
        ]);

        // Formate le numéro avec +237 si pas déjà fait
        $phone = $request->phone ?? '';
        if ($phone && !str_starts_with($phone, '+')) {
            $phone = '+237'.ltrim($phone, '0');
        }

        $reference = 'PAY-'.strtoupper(uniqid());

        // Sauvegarde en pending
        $payment = Payment::create([
            'rental_id'       => $rental->id,
            'user_id'         => auth()->id(),
            'amount'          => $rental->total_price,
            'method'          => $request->method,
            'status'          => 'pending',
            'transaction_ref' => $reference,
        ]);

        // Appel NotchPay
        try {
            $response = Http::withoutVerifying()
                ->timeout(30) // 👈 30 secondes au lieu de 10
                ->withHeaders([
                    'Authorization' => env('NOTCHPAY_PUBLIC_KEY'),
                    'Accept'        => 'application/json',
                    'Content-Type'  => 'application/json',
                ])->post($this->baseUrl.'/payments/initialize', [
                    'amount'      => (int) $rental->total_price,
                    'currency'    => 'XAF',
                    'email'       => auth()->user()->email,
                    'phone'       => $phone,
                    'reference'   => $reference,
                    'description' => 'Location '.$rental->vehicle->brand.' '.$rental->vehicle->model,
                    'callback'    => env('NOTCHPAY_CALLBACK_URL'),
                ]);

            $data = $response->json();

            if ($response->successful() && isset($data['transaction'])) {
                // Redirige vers page de confirmation INTERNE
                return redirect()->route('client.payment.confirm', [
                    'rental'    => $rental->id,
                    'reference' => $reference,
                    'trx_ref'   => $data['transaction']['reference'] ?? $reference,
                ]);
            }

            $payment->delete();
            return back()->with('error', 'Erreur NotchPay : '.($data['message'] ?? json_encode($data)));

        } catch (\Exception $e) {
            $payment->delete();
            return back()->with('error', 'Connexion impossible : '.$e->getMessage());
        }
    }

    public function confirm(Request $request, Rental $rental)
    {
        abort_if($rental->user_id !== auth()->id(), 403);
        $reference = $request->get('reference');
        $trxRef    = $request->get('trx_ref', $reference);
        $payment   = Payment::where('transaction_ref', $reference)->firstOrFail();
        return view('client.payments.confirm', compact('rental','payment','reference','trxRef'));
    }

    public function verify(Request $request, Rental $rental)
    {
        abort_if($rental->user_id !== auth()->id(), 403);

        $reference = $request->get('reference');

        try {
            $response = Http::withoutVerifying()
                ->timeout(30) // 👈 30 secondes au lieu de 10
                ->withHeaders([
                    'Authorization' => env('NOTCHPAY_SECRET_KEY'),
                    'Accept'        => 'application/json',
                ])->get($this->baseUrl.'/payments/'.$reference);

            $data   = $response->json();
            $status = $data['transaction']['status']
                ?? $data['status']
                ?? 'failed';

            $payment = Payment::where('transaction_ref', $reference)->firstOrFail();

            if ($status === 'complete') {
                $payment->update(['status' => 'paid', 'paid_at' => now()]);
                optional($payment->rental->contract)->update([
                    'status'    => 'signed',
                    'signed_at' => now(),
                ]);
                return redirect()->route('client.rentals')
                    ->with('success', '✓ Paiement de '.number_format($payment->amount,0,',',' ').' FCFA confirmé !');
            }

            if (in_array($status, ['failed','canceled','timeout'])) {
                $payment->update(['status' => 'failed']);
                return redirect()->route('client.payment.checkout', $rental)
                    ->with('error', 'Paiement '.$status.'. Veuillez réessayer.');
            }

            // Encore pending — demande de reconfirmer
            return redirect()->route('client.payment.confirm', [
                'rental'    => $rental->id,
                'reference' => $reference,
            ])->with('info', 'Paiement en attente de confirmation...');

        } catch (\Exception $e) {
            return back()->with('error', 'Erreur vérification : '.$e->getMessage());
        }
    }

    public function callback(Request $request)
    {
        $reference = $request->get('reference') ?? $request->get('trxref');
        if (!$reference) {
            return redirect()->route('client.rentals')->with('error', 'Référence manquante.');
        }

        try {
            $response = Http::withoutVerifying()
                ->timeout(30) // 👈 30 secondes au lieu de 10
                ->withHeaders([
                    'Authorization' => env('NOTCHPAY_SECRET_KEY'),
                    'Accept'        => 'application/json',
                ])->get($this->baseUrl.'/payments/'.$reference);

            $data   = $response->json();
            $status = $data['transaction']['status'] ?? 'failed';
            $payment = Payment::where('transaction_ref', $reference)->first();

            if ($payment && $status === 'complete') {
                $payment->update(['status' => 'paid', 'paid_at' => now()]);
                optional($payment->rental->contract)->update([
                    'status' => 'signed', 'signed_at' => now(),
                ]);
                return redirect()->route('client.rentals')
                    ->with('success', '✓ Paiement confirmé ! Réf : '.$reference);
            }
        } catch (\Exception $e) {}

        return redirect()->route('client.rentals')
            ->with('error', 'Paiement non confirmé.');
    }

    public function manual(Request $request, Rental $rental)
    {
        abort_if($rental->user_id !== auth()->id(), 403);
        $request->validate(['method' => 'required|in:cash,transfer']);

        Payment::create([
            'rental_id'       => $rental->id,
            'user_id'         => auth()->id(),
            'amount'          => $rental->total_price,
            'method'          => $request->method,
            'status'          => 'pending',
            'transaction_ref' => 'MANUAL-'.strtoupper(uniqid()),
        ]);

        return redirect()->route('client.rentals')
            ->with('success', 'Demande envoyée ! Présentez-vous en agence.');
    }
}