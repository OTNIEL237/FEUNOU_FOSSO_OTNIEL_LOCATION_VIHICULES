<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\Rental;
use App\Models\Contract;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    public function index()
    {
        $rentals = Rental::with('vehicle')
            ->where('user_id', auth()->id())
            ->latest()->paginate(10);
        return view('client.rentals.index', compact('rentals'));
    }

    public function create(Vehicle $vehicle)
    {
        abort_if($vehicle->status !== 'available', 403, 'Véhicule non disponible');
        return view('client.rentals.create', compact('vehicle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vehicle_id'  => 'required|exists:vehicles,id',
            'start_date'  => 'required|date|after_or_equal:today',
            'end_date'    => 'required|date|after:start_date',
            'notes'       => 'nullable|string|max:500',
        ]);

        $vehicle    = Vehicle::findOrFail($request->vehicle_id);
        $start      = \Carbon\Carbon::parse($request->start_date);
        $end        = \Carbon\Carbon::parse($request->end_date);
        $totalDays  = $start->diffInDays($end);
        $totalPrice = $totalDays * $vehicle->price_per_day;

        $rental = Rental::create([
            'user_id'     => auth()->id(),
            'vehicle_id'  => $request->vehicle_id,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'total_days'  => $totalDays,
            'total_price' => $totalPrice,
            'status'      => 'pending',
            'notes'       => $request->notes,
        ]);

        // Crée le contrat automatiquement
        Contract::create([
            'rental_id'       => $rental->id,
            'contract_number' => 'CONT-'.date('Y').'-'.str_pad($rental->id, 4, '0', STR_PAD_LEFT),
            'deposit_amount'  => $totalPrice * 0.3,
            'status'          => 'draft',
            'terms'           => 'Contrat de location standard AutoLoc.',
        ]);

        $vehicle->update(['status' => 'rented']);

        return redirect()->route('client.rentals')
            ->with('success', 'Réservation effectuée avec succès !');
    }
}