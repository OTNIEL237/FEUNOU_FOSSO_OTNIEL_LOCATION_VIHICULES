<?php
namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Rental;
use App\Models\Payment;
use App\Models\Contract;
use App\Models\User;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        $stats = [
            'total_vehicles'  => Vehicle::count(),
            'available'       => Vehicle::where('status','available')->count(),
            'rented'          => Vehicle::where('status','rented')->count(),
            'total_clients'   => User::where('role','client')->count(),
            'pending_rentals' => Rental::where('status','pending')->count(),
            'total_revenue'   => Payment::where('status','paid')->sum('amount'),
            'total_contracts' => Contract::count(),
            'signed_contracts'=> Contract::where('status','signed')->count(),
        ];

        $recent_rentals = Rental::with(['user','vehicle'])
            ->latest()->take(6)->get();

        // 👇 C'était manquant dans ton controller
        $recent_clients = User::where('role','client')
            ->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'stats',
            'recent_rentals',
            'recent_clients'
        ));
    }

    public function clientDashboard()
    {
        $user = auth()->user();

        $my_rentals = Rental::with('vehicle')
            ->where('user_id', $user->id)
            ->latest()->take(5)->get();

        $stats = [
            'total'     => Rental::where('user_id', $user->id)->count(),
            'ongoing'   => Rental::where('user_id', $user->id)->where('status','ongoing')->count(),
            'completed' => Rental::where('user_id', $user->id)->where('status','completed')->count(),
            'spent'     => Payment::where('user_id', $user->id)->where('status','paid')->sum('amount'),
        ];

        return view('client.dashboard', compact('my_rentals','stats'));
    }
}