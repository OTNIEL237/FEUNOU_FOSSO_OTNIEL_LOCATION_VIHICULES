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

        // Formate le numéro
        $phone = $request->phone ?? '';
        if ($phone && !str_starts_with($phone, '+')) {
            $phone = '+237'.ltrim($phone, '0');
        }

        $reference = 'PAY-'.strtoupper(uniqid());

        $payment = Payment::create([
            'rental_id'       => $rental->id,
            'user_id'         => auth()->id(),
            'amount'          => $rental->total_price,
            'method'          => $request->method,
            'status'          => 'pending',
            'transaction_ref' => $reference,
        ]);

        try {
            // 👇 NotchPay attend la clé PUBLIQUE dans Authorization
            // et le format exact est juste la clé sans "Bearer"
            $publicKey = config('services.notchpay.public_key');

            $response = Http::withoutVerifying()
                ->timeout(30)
                ->withHeaders([
                    'Authorization' => $publicKey,
                    'Accept'        => 'application/json',
                    'Content-Type'  => 'application/json',
                ])
                ->post($this->baseUrl.'/payments/initialize', [
                    'amount'      => (int) $rental->total_price,
                    'currency'    => 'XAF',
                    'email'       => auth()->user()->email,
                    'phone'       => $phone,
                    'reference'   => $reference,
                    'description' => 'Location '.$rental->vehicle->brand.' '.$rental->vehicle->model.' ('.$rental->total_days.'j)',
                    'callback'    => config('services.notchpay.callback'),
                ]);

            $data = $response->json();

            \Log::info('NotchPay Init Response', [
                'status' => $response->status(),
                'data'   => $data,
            ]);

            if ($response->successful() && isset($data['transaction'])) {
                return redirect()->route('client.payment.confirm', [
                    'rental'    => $rental->id,
                    'reference' => $reference,
                ]);
            }

            // Erreur API — supprime le paiement pending
            $payment->delete();
            return back()->with('error',
                'Erreur NotchPay : '.($data['message'] ?? json_encode($data))
            );

        } catch (\Exception $e) {
            $payment->delete();
            return back()->with('error', 'Connexion impossible : '.$e->getMessage());
        }
    }

    public function confirm(Request $request, Rental $rental)
    {
        abort_if($rental->user_id !== auth()->id(), 403);
        $reference = $request->get('reference');
        $payment   = Payment::where('transaction_ref', $reference)->firstOrFail();
        return view('client.payments.confirm', compact('rental','payment','reference'));
    }

    public function verify(Request $request, Rental $rental)
    {
        abort_if($rental->user_id !== auth()->id(), 403);
        $reference = $request->get('reference');

        // Mode simulation
        if (config('services.notchpay.simulation')) {
            $payment = Payment::where('transaction_ref', $reference)->firstOrFail();
            $payment->update(['status' => 'paid', 'paid_at' => now()]);
            optional($payment->rental->contract)->update([
                'status' => 'signed', 'signed_at' => now(),
            ]);
            return redirect()->route('client.rentals')
                ->with('success', '✓ Paiement de '.number_format($payment->amount,0,',',' ').' FCFA confirmé !');
        }

        try {
            $secretKey = config('services.notchpay.secret_key');

            $response = Http::withoutVerifying()
                ->timeout(30)
                ->withHeaders([
                    'Authorization' => $secretKey,
                    'Accept'        => 'application/json',
                ])
                ->get($this->baseUrl.'/payments/'.$reference);

            $data   = $response->json();
            $status = $data['transaction']['status'] ?? $data['status'] ?? 'failed';

            \Log::info('NotchPay Verify', ['status' => $status, 'data' => $data]);

            $payment = Payment::where('transaction_ref', $reference)->firstOrFail();

            if ($status === 'complete') {
                $payment->update(['status' => 'paid', 'paid_at' => now()]);
                optional($payment->rental->contract)->update([
                    'status' => 'signed', 'signed_at' => now(),
                ]);
                return redirect()->route('client.rentals')
                    ->with('success', '✓ Paiement de '.number_format($payment->amount,0,',',' ').' FCFA confirmé !');
            }

            if (in_array($status, ['failed','canceled','timeout'])) {
                $payment->update(['status' => 'failed']);
                return redirect()->route('client.payment.checkout', $rental)
                    ->with('error', 'Paiement '.$status.'. Veuillez réessayer.');
            }

            return redirect()->route('client.payment.confirm', [
                'rental'    => $rental->id,
                'reference' => $reference,
            ])->with('info', 'En attente de confirmation...');

        } catch (\Exception $e) {
            return redirect()->route('client.payment.confirm', [
                'rental'    => $rental->id,
                'reference' => $reference,
            ])->with('error', 'Vérification lente. Réessayez dans 30 secondes.');
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
                ->timeout(30)
                ->withHeaders([
                    'Authorization' => config('services.notchpay.secret_key'),
                    'Accept'        => 'application/json',
                ])
                ->get($this->baseUrl.'/payments/'.$reference);

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
        } catch (\Exception $e) {
            \Log::error('NotchPay callback error: '.$e->getMessage());
        }

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