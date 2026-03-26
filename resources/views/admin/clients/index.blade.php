@extends('layouts.app')
@section('title','Clients')
@section('content')
<style>
.card{background:#161820;border:1px solid #2a2d3a;border-radius:14px;overflow:hidden;}
table{width:100%;border-collapse:collapse;}
th{padding:10px 20px;text-align:left;font-size:10px;color:#555870;text-transform:uppercase;letter-spacing:.9px;background:#0f1117;}
td{padding:13px 20px;font-size:13px;color:#9496a8;border-top:1px solid #1a1c2a;}
td strong{color:#e8e9f0;}
tr:hover td{background:#0f1117;}
.btn-del{font-size:12px;color:#f87171;background:none;border:none;cursor:pointer;font-family:'DM Sans',sans-serif;}
.alert{padding:12px 20px;border-radius:10px;margin-bottom:20px;font-size:13px;}
.alert-success{background:#0d2e1a;border:1px solid #166534;color:#4ade80;}
</style>

<div class="page-header"><h1>Clients</h1><p>{{ $clients->total() }} client(s) inscrit(s)</p></div>

@if(session('success'))
    <div class="alert alert-success">✓ {{ session('success') }}</div>
@endif

<div class="card">
    <table>
        <thead>
            <tr><th>Client</th><th>Email</th><th>Téléphone</th><th>CNI</th><th>Inscrit le</th><th>Locations</th><th>Action</th></tr>
        </thead>
        <tbody>
            @forelse($clients as $c)
            <tr>
                <td>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <div style="width:32px;height:32px;border-radius:50%;background:#1e2130;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#f59e0b;font-family:'Syne',sans-serif;flex-shrink:0;">{{ strtoupper(substr($c->name,0,2)) }}</div>
                        <strong>{{ $c->name }}</strong>
                    </div>
                </td>
                <td>{{ $c->email }}</td>
                <td>{{ $c->phone ?? '—' }}</td>
                <td>{{ $c->cin ?? '—' }}</td>
                <td>{{ $c->created_at->format('d/m/Y') }}</td>
                <td><span style="background:#071e38;color:#60a5fa;padding:2px 8px;border-radius:20px;font-size:11px;">{{ $c->rentals_count ?? $c->rentals()->count() }}</span></td>
                <td>
                    <form method="POST" action="{{ route('admin.clients.destroy',$c) }}" style="display:inline;" onsubmit="return confirm('Supprimer ce client ?')">
                        @csrf @method('DELETE')
                        <button class="btn-del">Supprimer</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;padding:48px;color:#555870;">Aucun client</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="padding:16px 20px;">{{ $clients->links() }}</div>
</div>
@endsection