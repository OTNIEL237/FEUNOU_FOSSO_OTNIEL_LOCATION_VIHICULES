<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Contract;

class ContractController extends Controller
{
    public function index()
    {
        $contracts = Contract::whereHas('rental', fn($q) => $q->where('user_id', auth()->id()))
            ->with('rental.vehicle')
            ->latest()->paginate(10);
        return view('client.contracts.index', compact('contracts'));
    }

    public function show(Contract $contract)
    {
        abort_if($contract->rental->user_id !== auth()->id(), 403);
        $contract->load('rental.vehicle', 'rental.user');
        return view('client.contracts.show', compact('contract'));
    }
}