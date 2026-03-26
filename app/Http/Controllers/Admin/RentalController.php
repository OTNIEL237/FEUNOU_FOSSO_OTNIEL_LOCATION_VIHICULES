<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    public function index()
    {
        $rentals = Rental::with(['user','vehicle'])->latest()->paginate(10);
        return view('admin.rentals.index', compact('rentals'));
    }

    public function show(Rental $rental)
    {
        $rental->load(['user','vehicle','contract','payments']);
        return view('admin.rentals.show', compact('rental'));
    }

    public function updateStatus(Request $request, Rental $rental)
    {
        $request->validate(['status' => 'required|in:pending,confirmed,ongoing,completed,cancelled']);
        $rental->update(['status' => $request->status]);

        // Met à jour le statut du véhicule
        if ($request->status === 'ongoing') {
            $rental->vehicle->update(['status' => 'rented']);
        } elseif (in_array($request->status, ['completed','cancelled'])) {
            $rental->vehicle->update(['status' => 'available']);
        }

        return back()->with('success', 'Statut mis à jour !');
    }

    public function create() { return view('admin.rentals.index'); }
    public function store(Request $request) {}
    public function edit(Rental $rental) {}
    public function update(Request $request, Rental $rental) {}
    public function destroy(Rental $rental)
    {
        $rental->delete();
        return redirect()->route('admin.rentals.index')->with('success','Location supprimée.');
    }
}