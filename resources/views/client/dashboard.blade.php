@extends('layouts.app')
@section('title','Mon Espace')
@section('content')
<style>
.sg{display:grid;grid-template-columns:repeat(2,1fr);gap:16px;margin-bottom:32px;}
.sc{background:#161820;border:1px solid #2a2d3a;border-radius:12px;padding:20px;}
.sl{font-size:11px;color:#555870;text-transform:uppercase;letter-spacing:.8px;font-weight:600;}
.sv{font-family:'Syne',sans-serif;font-size:28px;font-weight:700;color:#fff;margin:6px 0 4px;}
.sb{font-size:11px;padding:2px 8px;border-radius:20px;}
.bg{background:#0d2e1a;color:#4ade80;}
.by{background:#2e1f05;color:#fbbf24;}
.bb{background:#071e38;color:#60a5fa;}
.btn-reserve{background:#f59e0b;color:#0f1117;padding:10px 20px;border-radius:8px;font-weight:700;font-family:'Syne',sans-serif;font-size:13px;text-decoration:none;display:inline-block;}
.table-card{background:#161820;border:1px solid #2a2d3a;border-radius:12px;overflow:hidden;}
.table-header{padding:18px 24px;border-bottom:1px solid #2a2d3a;}
.table-header h2{font-family:'Syne',sans-serif;font-size:15px;font-weight:600;color:#fff;}
table{width:100%;border-collapse:collapse;}
th{padding:10px 24px;text-align:left;font-size:10px;color:#555870;text-transform:uppercase;letter-spacing:.8px;background:#0f1117;}
td{padding:13px 24px;font-size:13px;color:#9496a8;border-top:1px solid #1e2130;}
td strong{color:#e8e9f0;}
.sp{padding:2px 8px;border-radius:20px;font-size:11px;font-weight:500;}
@media(max-width:600px){.sg{grid-template-columns:1fr;}.page-header-wrap{flex-direction:column;gap:12px;}th,td{padding:10px 12px;}}
</style>

<div class="page-header" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;" >
    <div>
        <h1>Mon Espace</h1>
        <p>Bienvenue, {{ auth()->user()->name }} 👋</p>
    </div>
    <a href="#" class="btn-reserve">+ Nouvelle réservation</a>
</div>

<div class="sg">
    <div class="sc">
        <div class="sl">Mes locations</div>
        <div class="sv">{{ $stats['total'] }}</div>
        <span class="sb bb">au total</span>
    </div>
    <div class="sc">
        <div class="sl">En cours</div>
        <div class="sv">{{ $stats['ongoing'] }}</div>
        <span class="sb bg">active</span>
    </div>
    <div class="sc">
        <div class="sl">Terminées</div>
        <div class="sv">{{ $stats['completed'] }}</div>
        <span class="sb" style="background:#1a1a2e;color:#a78bfa;">complétées</span>
    </div>
    <div class="sc">
        <div class="sl">Total dépensé</div>
        <div class="sv">{{ number_format($stats['spent'],0,',',' ') }}</div>
        <span class="sb by">FCFA</span>
    </div>
</div>

<div class="table-card">
    <div class="table-header">
        <h2>Mes dernières locations</h2>
    </div>
    <table>
        <thead>
            <tr>
                <th>Véhicule</th>
                <th>Début</th>
                <th>Fin</th>
                <th>Prix</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @forelse($my_rentals as $r)
            <tr>
                <td><strong>{{ $r->vehicle->brand }} {{ $r->vehicle->model }}</strong></td>
                <td>{{ $r->start_date->format('d/m/Y') }}</td>
                <td>{{ $r->end_date->format('d/m/Y') }}</td>
                <td><strong>{{ number_format($r->total_price,0,',',' ') }} F</strong></td>
                <td><span class="sp" style="background:#2e1f05;color:#fbbf24;">{{ ucfirst($r->status) }}</span></td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align:center;padding:32px;color:#555870;">
                    Aucune location — <a href="#" style="color:#f59e0b;">Réserver maintenant</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection