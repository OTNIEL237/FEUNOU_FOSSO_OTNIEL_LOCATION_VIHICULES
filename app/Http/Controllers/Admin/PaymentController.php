<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Rental;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['user','rental.vehicle'])->latest()->paginate(10);
        return view('admin.payments.index', compact('payments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rental_id' => 'required|exists:rentals,id',
            'amount'    => 'required|numeric|min:1',
            'method'    => 'required|in:cash,card,mobile_money,transfer',
        ]);

        $rental = Rental::findOrFail($request->rental_id);

        Payment::create([
            'rental_id'  => $rental->id,
            'user_id'    => $rental->user_id,
            'amount'     => $request->amount,
            'method'     => $request->method,
            'status'     => 'paid',
            'paid_at'    => now(),
            'transaction_ref' => 'PAY-'.date('Y').'-'.str_pad(rand(1,9999),4,'0',STR_PAD_LEFT),
        ]);

        return back()->with('success','Paiement enregistré !');
    }

    public function create() {}
    public function show(Payment $payment) {}
    public function edit(Payment $payment) {}
    public function update(Request $request, Payment $payment) {}
    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('admin.payments.index')->with('success','Paiement supprimé.');
    }
}