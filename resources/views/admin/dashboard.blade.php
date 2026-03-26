@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('content')
<style>
/* ── STATS GRID ── */
.stats-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:28px;}
.stat-card{background:#161820;border:1px solid #2a2d3a;border-radius:14px;padding:22px 24px;position:relative;overflow:hidden;transition:.2s;}
.stat-card:hover{border-color:#333650;}
.stat-accent{position:absolute;top:0;left:0;width:3px;height:100%;border-radius:2px 0 0 2px;}
.stat-label{font-size:11px;color:#555870;text-transform:uppercase;letter-spacing:.9px;font-weight:600;}
.stat-value{font-family:'Syne',sans-serif;font-size:34px;font-weight:700;color:#fff;margin:8px 0 6px;line-height:1;}
.stat-badge{font-size:11px;padding:3px 10px;border-radius:20px;display:inline-block;font-weight:500;}
.stat-icon{position:absolute;right:20px;top:50%;transform:translateY(-50%);width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center;}
.stat-icon svg{width:20px;height:20px;}

/* ── COULEURS BADGES ── */
.bg{background:#0d2e1a;color:#4ade80;}
.by{background:#2e1f05;color:#fbbf24;}
.bb{background:#071e38;color:#60a5fa;}
.br{background:#2e0d0d;color:#f87171;}
.bv{background:#1a1a2e;color:#a78bfa;}

/* ── GRILLE PRINCIPALE ── */
.main-grid{display:grid;grid-template-columns:1fr 320px;gap:20px;margin-bottom:20px;}

/* ── CARDS ── */
.card{background:#161820;border:1px solid #2a2d3a;border-radius:14px;overflow:hidden;}
.card-header{padding:18px 24px;border-bottom:1px solid #2a2d3a;display:flex;justify-content:space-between;align-items:center;}
.card-header h2{font-family:'Syne',sans-serif;font-size:15px;font-weight:600;color:#fff;}
.card-link{font-size:12px;color:#f59e0b;text-decoration:none;font-weight:500;}
.card-link:hover{color:#e08d00;}

/* ── TABLE ── */
table{width:100%;border-collapse:collapse;}
th{padding:10px 20px;text-align:left;font-size:10px;color:#555870;text-transform:uppercase;letter-spacing:.9px;font-weight:600;background:#0f1117;}
td{padding:13px 20px;font-size:13px;color:#9496a8;border-top:1px solid #1a1c2a;}
td strong{color:#e8e9f0;font-weight:500;}
tr:hover td{background:#0f1117;}
.sp{padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;}

/* ── ACTIVITÉ RÉCENTE ── */
.activity-list{padding:8px 0;}
.activity-item{display:flex;align-items:flex-start;gap:12px;padding:14px 20px;border-bottom:1px solid #1a1c2a;transition:.15s;}
.activity-item:last-child{border-bottom:none;}
.activity-item:hover{background:#0f1117;}
.activity-dot{width:8px;height:8px;border-radius:50%;flex-shrink:0;margin-top:5px;}
.activity-text{font-size:13px;color:#9496a8;line-height:1.5;}
.activity-text strong{color:#e8e9f0;}
.activity-time{font-size:11px;color:#555870;margin-top:3px;}

/* ── VÉHICULES STATUS ── */
.vehicle-status-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:0;}
.vs-item{padding:20px;text-align:center;border-right:1px solid #2a2d3a;}
.vs-item:last-child{border-right:none;}
.vs-num{font-family:'Syne',sans-serif;font-size:28px;font-weight:700;color:#fff;margin-bottom:4px;}
.vs-label{font-size:11px;color:#555870;text-transform:uppercase;letter-spacing:.8px;}
.vs-dot{width:8px;height:8px;border-radius:50%;margin:0 auto 8px;}

/* ── MINI CHART BARS ── */
.chart-bars{display:flex;align-items:flex-end;gap:4px;height:60px;padding:0 20px 16px;}
.bar-wrap{flex:1;display:flex;flex-direction:column;align-items:center;gap:4px;}
.bar{width:100%;border-radius:4px 4px 0 0;background:#f59e0b;opacity:.7;transition:.3s;min-height:4px;}
.bar-label{font-size:9px;color:#555870;}

/* ── QUICK ACTIONS ── */
.quick-actions{display:grid;grid-template-columns:1fr 1fr;gap:10px;padding:16px;}
.qa-btn{background:#0f1117;border:1px solid #2a2d3a;border-radius:10px;padding:14px;text-align:center;text-decoration:none;transition:.2s;display:block;}
.qa-btn:hover{border-color:#f59e0b;background:#161820;}
.qa-btn svg{width:20px;height:20px;color:#f59e0b;margin:0 auto 8px;display:block;}
.qa-btn span{font-size:12px;color:#9496a8;display:block;}

/* ── RESPONSIVE ── */
@media(max-width:1100px){.main-grid{grid-template-columns:1fr;}.stats-grid{grid-template-columns:repeat(2,1fr);}}
@media(max-width:600px){.stats-grid{grid-template-columns:1fr;}th,td{padding:10px 12px;font-size:12px;}.chart-bars{padding:0 12px 12px;}}
</style>

{{-- ── HEADER ── --}}
<div class="page-header" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
    <div>
        <h1>Dashboard Admin</h1>
        <p>{{ now()->isoFormat('dddd D MMMM YYYY') }} — Bienvenue, {{ auth()->user()->name }}</p>
    </div>
    <div style="display:flex;gap:10px;flex-wrap:wrap;">
        <a href="{{ route('admin.payments.index') }}" style="padding:9px 18px;background:#161820;border:1px solid #2a2d3a;border-radius:8px;color:#9496a8;font-size:13px;text-decoration:none;display:flex;align-items:center;gap:6px;">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Paiements
        </a>
        <a href="{{ route('admin.vehicles.create') }}" style="padding:9px 18px;background:#f59e0b;border-radius:8px;color:#0f1117;font-size:13px;font-weight:700;text-decoration:none;font-family:'Syne',sans-serif;">
            + Ajouter véhicule
        </a>
    </div>
</div>

{{-- ── STATS CARDS ── --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-accent" style="background:#60a5fa;"></div>
        <div class="stat-icon" style="background:#071e38;"><svg fill="none" viewBox="0 0 24 24" stroke="#60a5fa"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2.8.933M13 16l2.8-.933"/></svg></div>
        <div class="stat-label">Véhicules total</div>
        <div class="stat-value">{{ $stats['total_vehicles'] }}</div>
        <span class="stat-badge bb">{{ $stats['available'] }} disponibles</span>
    </div>
    <div class="stat-card">
        <div class="stat-accent" style="background:#fbbf24;"></div>
        <div class="stat-icon" style="background:#2e1f05;"><svg fill="none" viewBox="0 0 24 24" stroke="#fbbf24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>
        <div class="stat-label">En location</div>
        <div class="stat-value">{{ $stats['rented'] }}</div>
        <span class="stat-badge by">actuellement</span>
    </div>
    <div class="stat-card">
        <div class="stat-accent" style="background:#4ade80;"></div>
        <div class="stat-icon" style="background:#0d2e1a;"><svg fill="none" viewBox="0 0 24 24" stroke="#4ade80"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197"/></svg></div>
        <div class="stat-label">Clients inscrits</div>
        <div class="stat-value">{{ $stats['total_clients'] }}</div>
        <span class="stat-badge bg">actifs</span>
    </div>
    <div class="stat-card">
        <div class="stat-accent" style="background:#f87171;"></div>
        <div class="stat-icon" style="background:#2e0d0d;"><svg fill="none" viewBox="0 0 24 24" stroke="#f87171"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
        <div class="stat-label">En attente</div>
        <div class="stat-value">{{ $stats['pending_rentals'] }}</div>
        <span class="stat-badge br">à traiter</span>
    </div>
    <div class="stat-card" style="grid-column:span 2">
        <div class="stat-accent" style="background:#a78bfa;"></div>
        <div class="stat-icon" style="background:#1a1a2e;"><svg fill="none" viewBox="0 0 24 24" stroke="#a78bfa"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg></div>
        <div class="stat-label">Revenus total</div>
        <div class="stat-value">{{ number_format($stats['total_revenue'], 0, ',', ' ') }} <span style="font-size:16px;color:#9496a8;font-family:'DM Sans',sans-serif;font-weight:400;">FCFA</span></div>
        <span class="stat-badge bv">paiements confirmés</span>
    </div>
</div>

{{-- ── MAIN GRID ── --}}
<div class="main-grid">

    {{-- Colonne gauche --}}
    <div style="display:flex;flex-direction:column;gap:20px;">

        {{-- Tableau locations récentes --}}
        <div class="card">
            <div class="card-header">
                <h2>Dernières locations</h2>
                <a href="{{ route('admin.rentals.index') }}" class="card-link">Voir tout →</a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Client</th>
                        <th>Véhicule</th>
                        <th>Période</th>
                        <th>Prix</th>
                        <th>Statut</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recent_rentals as $rental)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div style="width:30px;height:30px;border-radius:50%;background:#1e2130;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#f59e0b;font-family:'Syne',sans-serif;flex-shrink:0;">
                                    {{ strtoupper(substr($rental->user->name,0,2)) }}
                                </div>
                                <strong>{{ $rental->user->name }}</strong>
                            </div>
                        </td>
                        <td>{{ $rental->vehicle->brand }} {{ $rental->vehicle->model }}</td>
                        <td style="white-space:nowrap;">
                            {{ $rental->start_date->format('d/m') }} → {{ $rental->end_date->format('d/m/Y') }}
                        </td>
                        <td><strong>{{ number_format($rental->total_price,0,',',' ') }} F</strong></td>
                        <td>
                            <span class="sp" style="
                                @if($rental->status=='ongoing') background:#0d2e1a;color:#4ade80;
                                @elseif($rental->status=='pending') background:#2e1f05;color:#fbbf24;
                                @elseif($rental->status=='confirmed') background:#071e38;color:#60a5fa;
                                @elseif($rental->status=='completed') background:#1a1a2e;color:#a78bfa;
                                @else background:#2e0d0d;color:#f87171; @endif
                            ">{{ ucfirst($rental->status) }}</span>
                        </td>
                        <td>
                            <a href="{{ route('admin.rentals.show', $rental->id) }}" style="font-size:12px;color:#555870;text-decoration:none;" onmouseover="this.style.color='#f59e0b'" onmouseout="this.style.color='#555870'">Voir</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align:center;padding:48px;color:#555870;">
                            Aucune location pour le moment
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Graphique revenus (barres statiques) --}}
        <div class="card">
            <div class="card-header">
                <h2>Aperçu des revenus — {{ date('Y') }}</h2>
                <a href="{{ route('admin.payments.index') }}" class="card-link">Détails →</a>
            </div>
            <div style="padding:20px 20px 0;">
                <div style="display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:8px;">
                    @php
                        $months = ['Jan','Fév','Mar','Avr','Mai','Jun','Jul','Aoû','Sep','Oct','Nov','Déc'];
                        $monthlyRevenue = [];
                        for ($m = 1; $m <= 12; $m++) {
                            $monthlyRevenue[] = \App\Models\Payment::where('status','paid')
                                ->whereYear('paid_at', date('Y'))
                                ->whereMonth('paid_at', $m)
                                ->sum('amount');
                        }
                        $maxRevenue = max(array_merge($monthlyRevenue,[1]));
                    @endphp
                </div>
            </div>
            <div class="chart-bars">
                @foreach($months as $i => $month)
                @php $h = $monthlyRevenue[$i] > 0 ? max(8, round(($monthlyRevenue[$i] / $maxRevenue) * 100)) : 4; @endphp
                <div class="bar-wrap">
                    <div class="bar" style="height:{{ $h }}%;opacity:{{ $i == date('n')-1 ? '1' : '0.4' }};background:{{ $i == date('n')-1 ? '#f59e0b' : '#3a3d50' }};"></div>
                    <div class="bar-label">{{ $month }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Colonne droite --}}
    <div style="display:flex;flex-direction:column;gap:20px;">

        {{-- Status véhicules --}}
        <div class="card">
            <div class="card-header">
                <h2>État du parc</h2>
                <a href="{{ route('admin.vehicles.index') }}" class="card-link">Gérer</a>
            </div>
            <div class="vehicle-status-grid">
                <div class="vs-item">
                    <div class="vs-dot" style="background:#4ade80;"></div>
                    <div class="vs-num" style="color:#4ade80;">{{ $stats['available'] }}</div>
                    <div class="vs-label">Disponibles</div>
                </div>
                <div class="vs-item">
                    <div class="vs-dot" style="background:#fbbf24;"></div>
                    <div class="vs-num" style="color:#fbbf24;">{{ $stats['rented'] }}</div>
                    <div class="vs-label">En location</div>
                </div>
                <div class="vs-item">
                    <div class="vs-dot" style="background:#f87171;"></div>
                    <div class="vs-num" style="color:#f87171;">{{ $stats['total_vehicles'] - $stats['available'] - $stats['rented'] }}</div>
                    <div class="vs-label">Maintenance</div>
                </div>
            </div>
            {{-- Barre de progression --}}
            @php
                $total = max($stats['total_vehicles'], 1);
                $availPct = round($stats['available'] / $total * 100);
                $rentedPct = round($stats['rented'] / $total * 100);
                $maintPct = 100 - $availPct - $rentedPct;
            @endphp
            <div style="padding:16px 20px;">
                <div style="height:8px;border-radius:4px;background:#0f1117;overflow:hidden;display:flex;">
                    <div style="width:{{ $availPct }}%;background:#4ade80;border-radius:4px 0 0 4px;"></div>
                    <div style="width:{{ $rentedPct }}%;background:#fbbf24;"></div>
                    <div style="width:{{ $maintPct }}%;background:#f87171;border-radius:0 4px 4px 0;"></div>
                </div>
            </div>
        </div>

        {{-- Actions rapides --}}
        <div class="card">
            <div class="card-header"><h2>Actions rapides</h2></div>
            <div class="quick-actions">
                <a href="{{ route('admin.vehicles.create') }}" class="qa-btn">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/></svg>
                    <span>Nouveau véhicule</span>
                </a>
                <a href="{{ route('admin.contracts.index') }}" class="qa-btn">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>Contrats</span>
                </a>
                <a href="{{ route('admin.payments.index') }}" class="qa-btn">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <span>Paiements</span>
                </a>
                <a href="{{ route('admin.clients.index') }}" class="qa-btn">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197"/></svg>
                    <span>Voir clients</span>
                </a>
            </div>
        </div>

        {{-- Clients récents --}}
        <div class="card">
            <div class="card-header">
                <h2>Nouveaux clients</h2>
                <a href="{{ route('admin.clients.index') }}" class="card-link">Tous →</a>
            </div>
            <div style="padding:8px 0;">
                @forelse($recent_clients as $client)
                <div style="display:flex;align-items:center;gap:12px;padding:12px 20px;border-bottom:1px solid #1a1c2a;transition:.15s;" onmouseover="this.style.background='#0f1117'" onmouseout="this.style.background='transparent'">
                    <div style="width:36px;height:36px;border-radius:50%;background:#1e2130;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#f59e0b;font-family:'Syne',sans-serif;flex-shrink:0;">
                        {{ strtoupper(substr($client->name,0,2)) }}
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:13px;font-weight:500;color:#e8e9f0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $client->name }}</div>
                        <div style="font-size:11px;color:#555870;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $client->email }}</div>
                    </div>
                    <div style="font-size:11px;color:#555870;white-space:nowrap;">{{ $client->created_at->diffForHumans() }}</div>
                </div>
                @empty
                <div style="padding:32px;text-align:center;color:#555870;font-size:13px;">Aucun client</div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection