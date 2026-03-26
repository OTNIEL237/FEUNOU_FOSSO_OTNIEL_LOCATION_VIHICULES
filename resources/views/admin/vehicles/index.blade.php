@extends('layouts.app')
@section('title','Véhicules')
@section('content')
<style>
.card{background:#161820;border:1px solid #2a2d3a;border-radius:14px;overflow:hidden;}
.card-header{padding:18px 24px;border-bottom:1px solid #2a2d3a;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;}
.card-header h2{font-family:'Syne',sans-serif;font-size:16px;font-weight:600;color:#fff;}
table{width:100%;border-collapse:collapse;}
th{padding:10px 20px;text-align:left;font-size:10px;color:#555870;text-transform:uppercase;letter-spacing:.9px;background:#0f1117;}
td{padding:13px 20px;font-size:13px;color:#9496a8;border-top:1px solid #1a1c2a;}
td strong{color:#e8e9f0;}
tr:hover td{background:#0f1117;}
.sp{padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;}
.btn-add{background:#f59e0b;color:#0f1117;padding:9px 18px;border-radius:8px;font-size:13px;font-weight:700;text-decoration:none;font-family:'Syne',sans-serif;}
.btn-edit{font-size:12px;color:#60a5fa;text-decoration:none;margin-right:10px;}
.btn-del{font-size:12px;color:#f87171;background:none;border:none;cursor:pointer;font-family:'DM Sans',sans-serif;}
.alert{padding:12px 20px;border-radius:10px;margin-bottom:20px;font-size:13px;}
.alert-success{background:#0d2e1a;border:1px solid #166534;color:#4ade80;}
</style>

<div class="page-header" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
    <div><h1>Véhicules</h1><p>Gestion du parc automobile</p></div>
    <a href="{{ route('admin.vehicles.create') }}" class="btn-add">+ Ajouter un véhicule</a>
</div>

@if(session('success'))
    <div class="alert alert-success">✓ {{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-header">
        <h2>{{ $vehicles->total() }} véhicule(s)</h2>
    </div>
    <table>
        <thead>
            <tr>
                <th>Véhicule</th><th>Type</th><th>Plaque</th><th>Prix/jour</th><th>Km</th><th>Statut</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($vehicles as $v)
            <tr>
                <td><strong>{{ $v->brand }} {{ $v->model }}</strong><br><span style="font-size:11px;color:#555870;">{{ $v->year }}</span></td>
                <td>{{ $v->type === 'car' ? 'Voiture' : 'Moto' }}</td>
                <td>{{ $v->plate }}</td>
                <td><strong>{{ number_format($v->price_per_day,0,',',' ') }} F</strong></td>
                <td>{{ number_format($v->mileage,0,',',' ') }}</td>
                <td>
                    <span class="sp" style="
                        @if($v->status=='available') background:#0d2e1a;color:#4ade80;
                        @elseif($v->status=='rented') background:#2e1f05;color:#fbbf24;
                        @else background:#2e0d0d;color:#f87171; @endif
                    ">{{ ucfirst($v->status) }}</span>
                </td>
                <td>
                    <a href="{{ route('admin.vehicles.edit',$v) }}" class="btn-edit">Modifier</a>
                    <form method="POST" action="{{ route('admin.vehicles.destroy',$v) }}" style="display:inline;" onsubmit="return confirm('Supprimer ce véhicule ?')">
                        @csrf @method('DELETE')
                        <button class="btn-del">Supprimer</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;padding:48px;color:#555870;">Aucun véhicule</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="padding:16px 20px;">{{ $vehicles->links() }}</div>
</div>
@endsection