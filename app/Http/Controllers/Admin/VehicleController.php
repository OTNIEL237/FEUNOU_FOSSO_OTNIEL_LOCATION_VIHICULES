<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::latest()->paginate(10);
        return view('admin.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        return view('admin.vehicles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'brand'         => 'required|string|max:100',
            'model'         => 'required|string|max:100',
            'type'          => 'required|in:car,motorcycle',
            'year'          => 'required|digits:4|integer|min:1990|max:'.date('Y'),
            'plate'         => 'required|string|unique:vehicles,plate',
            'price_per_day' => 'required|numeric|min:1',
            'mileage'       => 'required|integer|min:0',
            'status'        => 'required|in:available,rented,maintenance',
            'description'   => 'nullable|string',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3048',
            'image_url'     => 'nullable|url',
        ]);

        $data = $request->only([
            'brand','model','type','year','plate',
            'price_per_day','mileage','status','description'
        ]);

        // Priorité : fichier uploadé > URL externe
        if ($request->hasFile('image')) {
            try {
                // Tente Cloudinary si configuré
                if (env('CLOUDINARY_URL')) {
                    $uploaded = cloudinary()->upload(
                        $request->file('image')->getRealPath(),
                        ['folder' => 'autoloc/vehicles']
                    );
                    $data['image'] = $uploaded->getSecurePath();
                } else {
                    // Fallback storage local
                    $data['image'] = $request->file('image')
                        ->store('vehicles', 'public');
                }
            } catch (\Exception $e) {
                // Si upload échoue, continue sans image
                \Log::error('Image upload failed: '.$e->getMessage());
            }
        } elseif ($request->filled('image_url')) {
            // URL externe directe
            $data['image'] = $request->image_url;
        }

        Vehicle::create($data);

        return redirect()->route('admin.vehicles.index')
            ->with('success', 'Véhicule ajouté avec succès !');
    }

    public function show(Vehicle $vehicle)
    {
        $vehicle->load('rentals.user');
        return view('admin.vehicles.show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        return view('admin.vehicles.edit', compact('vehicle'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'brand'         => 'required|string|max:100',
            'model'         => 'required|string|max:100',
            'type'          => 'required|in:car,motorcycle',
            'year'          => 'required|digits:4|integer|min:1990|max:'.date('Y'),
            'plate'         => 'required|string|unique:vehicles,plate,'.$vehicle->id,
            'price_per_day' => 'required|numeric|min:1',
            'mileage'       => 'required|integer|min:0',
            'status'        => 'required|in:available,rented,maintenance',
            'description'   => 'nullable|string',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3048',
            'image_url'     => 'nullable|url',
        ]);

        $data = $request->only([
            'brand','model','type','year','plate',
            'price_per_day','mileage','status','description'
        ]);

        if ($request->hasFile('image')) {
            try {
                if (env('CLOUDINARY_URL')) {
                    $uploaded = cloudinary()->upload(
                        $request->file('image')->getRealPath(),
                        ['folder' => 'autoloc/vehicles']
                    );
                    $data['image'] = $uploaded->getSecurePath();
                } else {
                    $data['image'] = $request->file('image')
                        ->store('vehicles', 'public');
                }
            } catch (\Exception $e) {
                \Log::error('Image upload failed: '.$e->getMessage());
            }
        } elseif ($request->filled('image_url')) {
            $data['image'] = $request->image_url;
        }

        $vehicle->update($data);

        return redirect()->route('admin.vehicles.index')
            ->with('success', 'Véhicule modifié avec succès !');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return redirect()->route('admin.vehicles.index')
            ->with('success', 'Véhicule supprimé.');
    }
}