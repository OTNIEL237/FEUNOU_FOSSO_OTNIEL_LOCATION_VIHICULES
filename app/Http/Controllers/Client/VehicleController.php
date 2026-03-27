<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;

class VehicleController extends Controller
{
    public function index()
    {
        // Affiche TOUS les véhicules sauf ceux en maintenance
        $vehicles = Vehicle::whereIn('status', ['available','rented'])
            ->when(request('type'), fn($q) => $q->where('type', request('type')))
            ->when(request('search'), fn($q) =>
                $q->where('brand','like','%'.request('search').'%')
                  ->orWhere('model','like','%'.request('search').'%')
            )
            ->when(request('filter') === 'available', fn($q) =>
                $q->where('status','available')
            )
            ->when(request('filter') === 'rented', fn($q) =>
                $q->where('status','rented')
            )
            ->paginate(9);

        return view('client.vehicles.index', compact('vehicles'));
    }

    public function show(Vehicle $vehicle)
    {
        // Interdire l'accès si le véhicule est en maintenance
        abort_if($vehicle->status === 'maintenance', 404);

        // Si le véhicule est loué, on charge la location active
        $activeRental = null;
        if ($vehicle->status === 'rented') {
            $activeRental = $vehicle->rentals()
                ->whereIn('status', ['confirmed','ongoing'])
                ->orderByDesc('end_date')
                ->first();
        }

        return view('client.vehicles.show', compact('vehicle', 'activeRental'));
    }
}