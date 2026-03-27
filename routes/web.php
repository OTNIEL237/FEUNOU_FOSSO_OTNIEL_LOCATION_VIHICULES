<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Client\VehicleController as ClientVehicleController;
use App\Http\Controllers\Client\RentalController as ClientRentalController;
use App\Http\Controllers\Client\ContractController as ClientContractController;
use App\Http\Controllers\Admin\VehicleController as AdminVehicleController;
use App\Http\Controllers\Admin\RentalController as AdminRentalController;
use App\Http\Controllers\Admin\ClientController as AdminClientController;
use App\Http\Controllers\Admin\ContractController as AdminContractController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Client\PaymentController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

Route::get('/', function() {
    if (auth()->check()) {
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('client.dashboard');
    }
    return redirect()->route('login');
});

Route::get('/dashboard', function() {
    if (auth()->check()) {
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('client.dashboard');
    }
    return redirect()->route('login');
})->middleware('auth');

// ─── ADMIN ────────────────────────────────────────────────
Route::middleware(['auth','role:admin'])
    ->prefix('admin')->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');
        Route::resource('vehicles', AdminVehicleController::class);
        Route::resource('rentals', AdminRentalController::class);
        Route::resource('clients', AdminClientController::class);
        Route::resource('contracts', AdminContractController::class);
        Route::resource('payments', AdminPaymentController::class);
        Route::patch('/rentals/{rental}/status', [AdminRentalController::class, 'updateStatus'])->name('rentals.status');
    });

// ─── CLIENT ───────────────────────────────────────────────
Route::middleware(['auth','role:client'])
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
        
        // Routes supplémentaires pour confirmer/vérifier (à implémenter dans le contrôleur)
        Route::get('/payment/{rental}/confirm', [PaymentController::class, 'confirm'])->name('payment.confirm');
        Route::get('/payment/{rental}/verify', [PaymentController::class, 'verify'])->name('payment.verify');
    });

// Callback NotchPay – doit être accessible sans middleware client (hors groupe)
Route::get('/client/payment/callback', [PaymentController::class, 'callback'])
    ->name('client.payment.callback');

// ⚠️ ROUTE TEMPORAIRE — SUPPRIMER APRÈS CRÉATION DE L'ADMIN
Route::get('/setup-admin-autoloc-2024', function() {
    // Vérifie qu'aucun admin n'existe déjà
    if (\App\Models\User::where('role', 'admin')->exists()) {
        return response()->json([
            'status'  => 'already_exists',
            'message' => 'Un administrateur existe déjà.',
        ]);
    }

    $admin = \App\Models\User::create([
        'name'       => 'Admin AutoLoc',
        'email'      => 'admin@autoloc.com',
        'password'   => \Illuminate\Support\Facades\Hash::make('Admin@2024!'),
        'role'       => 'admin',
        'is_active'  => true,
    ]);

    return response()->json([
        'status'   => 'success',
        'message'  => 'Administrateur créé avec succès !',
        'email'    => $admin->email,
        'password' => 'Admin@2024!',
        'warning'  => '⚠️ SUPPRIMEZ CETTE ROUTE IMMÉDIATEMENT APRÈS CONNEXION !',
    ]);
});

require __DIR__.'/auth.php';