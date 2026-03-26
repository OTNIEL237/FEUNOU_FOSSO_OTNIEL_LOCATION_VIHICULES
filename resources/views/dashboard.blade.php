@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<style>
    .stats-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-bottom:32px; }
    .stat-card { background:#161820; border:1px solid #2a2d3a; border-radius:12px; padding:20px 24px; }
    .stat-label { font-size:12px; color:#555870; text-transform:uppercase; letter-spacing:.8px; font-weight:600; }
    .stat-value { font-family:'Syne',sans-serif; font-size:32px; font-weight:700; color:#fff; margin:6px 0 2px; }
    .stat-badge { font-size:12px; padding:3px 10px; border-radius:20px; display:inline-block; }
    .badge-green { background:#0d2e1a; color:#4ade80; }
    .badge-yellow { background:#2e1f05; color:#fbbf24; }
    .badge-blue { background:#071e38; color:#60a5fa; }
    .badge-red { background:#2e0d0d; color:#f87171; }

    .table-card { background:#161820; border:1px solid #2a2d3a; border-radius:12px; overflow:hidden; }
    .table-header { padding:20px 24px; border-bottom:1px solid #2a2d3a; display:flex; justify-content:space-between; align-items:center; }
    .table-header h2 { font-family:'Syne',sans-serif; font-size:16px; font-weight:600; color:#fff; }
    table { width:100%; border-collapse:collapse; }
    th { padding:12px 24px; text-align:left; font-size:11px; color:#555870; text-transform:uppercase; letter-spacing:.8px; font-weight:600; background:#0f1117; }
    td { padding:14px 24px; font-size:14px; color:#9496a8; border-top:1px solid #1e2130; }
    td strong { color:#e8e9f0; font-weight:500; }
    .status-pill { padding:3px 10px; border-radius:20px; font-size:12px; font-weight:500; }
    .status-pending { background:#2e1f05; color:#fbbf24; }
    .status-confirmed { background:#071e38; color:#60a5fa; }
    .status-ongoing { background:#0d2e1a; color:#4ade80; }
    .status-completed { background:#1a1a2e; color:#a78bfa; }
    .status-cancelled { background:#2e0d0d; color:#f87171; }

    .accent-bar { width:4px; height:40px; border-radius:2px; display:inline-block; }
</style>

<div class="page-header">
    <h1>Bonjour, {{ auth()->user()->name }} 👋</h1>
    <p>Voici un aperçu de votre système de location</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">Véhicules total</div>
        <div class="stat-value">{{ $stats['total_vehicles'] }}</div>
        <span class="stat-badge badge-blue">{{ $stats['available'] }} disponibles</span>
    </div>
    <div class="stat-card">
        <div class="stat-label">En location</div>
        <div class="stat-value">{{ $stats['rented'] }}</div>
        <span class="stat-badge badge-yellow">actuellement</span>
    </div>
    <div class="stat-card">
        <div class="stat-label">Clients inscrits</div>
        <div class="stat-value">{{ $stats['total_clients'] }}</div>
        <span class="stat-badge badge-green">actifs</span>
    </div>
    <div class="stat-card">
        <div class="stat-label">Réservations en attente</div>
        <div class="stat-value">{{ $stats['pending_rentals'] }}</div>
        <span class="stat-badge badge-red">à traiter</span>
    </div>
    <div class="stat-card" style="grid-column:span 2">
        <div class="stat-label">Revenus total</div>
        <div class="stat-value">{{ number_format($stats['total_revenue'], 0, ',', ' ') }} FCFA</div>
        <span class="stat-badge badge-green">paiements confirmés</span>
    </div>
</div>

<div class="table-card">
    <div class="table-header">
        <h2>Dernières locations</h2>
        <a href="#" style="font-size:13px;color:#f59e0b;text-decoration:none;">Voir tout →</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Client</th>
                <th>Véhicule</th>
                <th>Début</th>
                <th>Fin</th>
                <th>Prix</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recent_rentals as $rental)
            <tr>
                <td><strong>{{ $rental->user->name }}</strong></td>
                <td>{{ $rental->vehicle->brand }} {{ $rental->vehicle->model }}</td>
                <td>{{ $rental->start_date->format('d/m/Y') }}</td>
                <td>{{ $rental->end_date->format('d/m/Y') }}</td>
                <td><strong>{{ number_format($rental->total_price,0,',',' ') }} F</strong></td>
                <td>
                    <span class="status-pill status-{{ $rental->status }}">
                        {{ ucfirst($rental->status) }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center;padding:40px;color:#555870;">
                    Aucune location pour le moment
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection