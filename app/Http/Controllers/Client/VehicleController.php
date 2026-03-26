<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::where('status', 'available')
            ->when(request('type'), fn($q) => $q->where('type', request('type')))
            ->when(request('search'), fn($q) => $q->where('brand', 'like', '%'.request('search').'%')
                ->orWhere('model', 'like', '%'.request('search').'%'))
            ->paginate(9);

        return view('client.vehicles.index', compact('vehicles'));
    }

    public function show(Vehicle $vehicle)
    {
        return view('client.vehicles.show', compact('vehicle'));
    }
}