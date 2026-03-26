<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function index()
    {
        $contracts = Contract::with(['rental.user','rental.vehicle'])->latest()->paginate(10);
        return view('admin.contracts.index', compact('contracts'));
    }

    public function show(Contract $contract)
    {
        $contract->load('rental.vehicle','rental.user','rental.payments');
        return view('admin.contracts.show', compact('contract'));
    }

    public function update(Request $request, Contract $contract)
    {
        $request->validate(['status' => 'required|in:draft,signed,closed']);
        $contract->update([
            'status'    => $request->status,
            'signed_at' => $request->status === 'signed' ? now() : $contract->signed_at,
        ]);
        return back()->with('success','Contrat mis à jour !');
    }

    public function create() {}
    public function store(Request $request) {}
    public function edit(Contract $contract) {}
    public function destroy(Contract $contract)
    {
        $contract->delete();
        return redirect()->route('admin.contracts.index')->with('success','Contrat supprimé.');
    }
}