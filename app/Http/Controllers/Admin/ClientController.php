<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = User::where('role','client')->latest()->paginate(10);
        return view('admin.clients.index', compact('clients'));
    }

    public function show(User $client)
    {
        $client->load('rentals.vehicle');
        return view('admin.clients.show', compact('client'));
    }

    public function destroy(User $client)
    {
        $client->delete();
        return redirect()->route('admin.clients.index')->with('success','Client supprimé.');
    }

    public function create() {}
    public function store(Request $request) {}
    public function edit(User $client) {}
    public function update(Request $request, User $client) {}
}