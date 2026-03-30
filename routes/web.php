<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;

// CLIENT
use App\Http\Controllers\Client\VehicleController as ClientVehicleController;
use App\Http\Controllers\Client\RentalController as ClientRentalController;
use App\Http\Controllers\Client\ContractController as ClientContractController;
use App\Http\Controllers\Client\PaymentController;

// ADMIN
use App\Http\Controllers\Admin\VehicleController as AdminVehicleController;
use App\Http\Controllers\Admin\RentalController as AdminRentalController;
use App\Http\Controllers\Admin\ClientController as AdminClientController;
use App\Http\Controllers\Admin\ContractController as AdminContractController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;

/*
|--------------------------------------------------------------------------
| PAGE D'ACCUEIL (VISIBLE PAR TOUS)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');


/*
|--------------------------------------------------------------------------
| DASHBOARD (REDIRECTION SELON RÔLE)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    if (auth()->check()) {
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('client.dashboard');
    }
    return redirect()->route('login');
})->middleware('auth');


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');

        Route::resource('vehicles', AdminVehicleController::class);
        Route::resource('rentals', AdminRentalController::class);
        Route::resource('clients', AdminClientController::class);
        Route::resource('contracts', AdminContractController::class);
        Route::resource('payments', AdminPaymentController::class);

        Route::patch('/rentals/{rental}/status', [AdminRentalController::class, 'updateStatus'])
            ->name('rentals.status');
    });


/*
|--------------------------------------------------------------------------
| CLIENT
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:client'])
    ->prefix('client')->name('client.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'clientDashboard'])->name('dashboard');

        Route::get('/vehicles', [ClientVehicleController::class, 'index'])->name('vehicles');
        Route::get('/vehicles/{vehicle}', [ClientVehicleController::class, 'show'])->name('vehicles.show');

        Route::get('/rentals', [ClientRentalController::class, 'index'])->name('rentals');
        Route::get('/rentals/create/{vehicle}', [ClientRentalController::class, 'create'])->name('rentals.create');
        Route::post('/rentals', [ClientRentalController::class, 'store'])->name('rentals.store');

        Route::get('/contracts', [ClientContractController::class, 'index'])->name('contracts');
        Route::get('/contracts/{contract}', [ClientContractController::class, 'show'])->name('contracts.show');

        // Paiement
        Route::get('/payment/{rental}', [PaymentController::class, 'checkout'])->name('payment.checkout');
        Route::post('/payment/{rental}/initiate', [PaymentController::class, 'initiate'])->name('payment.initiate');
        Route::post('/payment/{rental}/manual', [PaymentController::class, 'manual'])->name('payment.manual');

        Route::get('/payment/{rental}/confirm', [PaymentController::class, 'confirm'])->name('payment.confirm');
        Route::get('/payment/{rental}/verify', [PaymentController::class, 'verify'])->name('payment.verify');
    });


/*
|--------------------------------------------------------------------------
| CALLBACK PAIEMENT (PUBLIC)
|--------------------------------------------------------------------------
*/
Route::get('/client/payment/callback', [PaymentController::class, 'callback'])
    ->name('client.payment.callback');


/*
|--------------------------------------------------------------------------
| ROUTE TEMPORAIRE ADMIN (À SUPPRIMER)
|--------------------------------------------------------------------------
*/
Route::get('/setup-admin-autoloc-2024', function () {

    if (\App\Models\User::where('role', 'admin')->exists()) {
        return response()->json([
            'status' => 'already_exists',
            'message' => 'Un administrateur existe déjà.',
        ]);
    }

    $admin = \App\Models\User::create([
        'name'      => 'Admin AutoLoc',
        'email'     => 'admin@autoloc.com',
        'password'  => \Illuminate\Support\Facades\Hash::make('Admin@2024!'),
        'role'      => 'admin',
        'is_active' => true,
    ]);

    return response()->json([
        'status'   => 'success',
        'message'  => 'Administrateur créé avec succès !',
        'email'    => $admin->email,
        'password' => 'Admin@2024!',
        'warning'  => '⚠️ SUPPRIMEZ CETTE ROUTE APRÈS UTILISATION !',
    ]);
});


/*
|--------------------------------------------------------------------------
| DEBUG (OPTIONNEL)
|--------------------------------------------------------------------------
*/
Route::get('/setup-debug-check', function () {
    $vehicle = \App\Models\Vehicle::first();

    return response()->json([
        'vite_exists'   => file_exists(public_path('build/manifest.json')),
        'app_url'       => config('app.url'),
        'vehicle_image' => $vehicle?->image ?? 'aucun véhicule',
        'image_url'     => $vehicle?->image_url ?? 'null',
        'storage_link'  => is_link(public_path('storage')),
    ]);
});


require __DIR__.'/auth.php';