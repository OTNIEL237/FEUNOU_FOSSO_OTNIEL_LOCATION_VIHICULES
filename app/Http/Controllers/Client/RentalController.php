<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\Rental;
use App\Models\Contract;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
        // Vérifier que le véhicule n'est pas en maintenance
        abort_if($vehicle->status === 'maintenance', 403, 'Véhicule en maintenance');

        $minDate = date('Y-m-d');
        $isReservation = false;

        // Si le véhicule est loué, on calcule la prochaine disponibilité
        if ($vehicle->status === 'rented') {
            $activeRental = $vehicle->rentals()
                ->whereIn('status', ['confirmed','ongoing'])
                ->orderByDesc('end_date')
                ->first();

            if ($activeRental) {
                // La réservation commence le lendemain de la fin de location
                $minDate = $activeRental->end_date
                    ->addDay()
                    ->format('Y-m-d');
                $isReservation = true;
            }
        }

        return view('client.rentals.create', compact('vehicle','minDate','isReservation'));
    }

    public function store(Request $request)
    {
        $vehicle = Vehicle::findOrFail($request->vehicle_id);

        // Recalculer la date minimum (sécurité)
        $minDate = date('Y-m-d');
        $isReservation = false;

        if ($vehicle->status === 'rented') {
            $activeRental = $vehicle->rentals()
                ->whereIn('status', ['confirmed','ongoing'])
                ->orderByDesc('end_date')
                ->first();
            if ($activeRental) {
                $minDate = $activeRental->end_date->addDay()->format('Y-m-d');
                $isReservation = true;
            }
        }

        // Validation avec la date minimum dynamique
        $request->validate([
            'vehicle_id'  => 'required|exists:vehicles,id',
            'start_date'  => 'required|date|after_or_equal:'.$minDate,
            'end_date'    => 'required|date|after:start_date',
            'notes'       => 'nullable|string|max:500',
        ]);

        $start      = Carbon::parse($request->start_date);
        $end        = Carbon::parse($request->end_date);
        $totalDays  = $start->diffInDays($end);
        $totalPrice = $totalDays * $vehicle->price_per_day;

        // Créer la location/réservation
        $rental = Rental::create([
            'user_id'        => auth()->id(),
            'vehicle_id'     => $request->vehicle_id,
            'start_date'     => $request->start_date,
            'end_date'       => $request->end_date,
            'total_days'     => $totalDays,
            'total_price'    => $totalPrice,
            'status'         => 'pending',
            'notes'          => $request->notes,
            'is_reservation' => $isReservation,
        ]);

        // Créer le contrat associé
        Contract::create([
            'rental_id'       => $rental->id,
            'contract_number' => 'CONT-'.date('Y').'-'.str_pad($rental->id, 4, '0', STR_PAD_LEFT),
            'deposit_amount'  => $totalPrice * 0.3,
            'status'          => 'draft',
            'terms'           => 'Contrat de location standard AutoLoc.',
        ]);

        // Mettre à jour le statut du véhicule SEULEMENT si c'est une location immédiate
        if (!$isReservation) {
            $vehicle->update(['status' => 'rented']);
        }

        $msg = $isReservation
            ? '✅ Réservation effectuée pour le '.$start->format('d/m/Y').' !'
            : '✅ Location confirmée avec succès !';

        return redirect()->route('client.rentals')->with('success', $msg);
    }
}