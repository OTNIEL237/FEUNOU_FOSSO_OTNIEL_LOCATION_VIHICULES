<?php
namespace App\Http\Controllers;

use App\Models\Vehicle;

class HomeController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::whereIn('status', ['available','rented'])
            ->latest()->take(8)->get();

        $stats = [
            'total_vehicles' => Vehicle::count(),
            'available'      => Vehicle::where('status','available')->count(),
            'cities'         => 3,
        ];

        return view('home', compact('vehicles', 'stats'));
    }
}