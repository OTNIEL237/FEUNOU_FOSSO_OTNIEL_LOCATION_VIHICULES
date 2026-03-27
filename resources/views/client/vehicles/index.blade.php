@extends('layouts.app')
@section('title','Véhicules')
@section('content')
<style>
/* ── PAGE ── */
.page-title{font-family:'Syne',sans-serif;font-size:22px;font-weight:700;color:#fff;margin-bottom:4px;}
.page-sub{color:#9496a8;font-size:13px;margin-bottom:24px;}

/* ── TOP BAR ── */
.top-bar{display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:16px;margin-bottom:24px;}
.filters{display:flex;gap:8px;flex-wrap:wrap;}
.filter-btn{padding:7px 16px;border-radius:20px;border:1px solid #2a2d3a;background:transparent;color:#9496a8;font-size:12px;font-family:'DM Sans',sans-serif;cursor:pointer;transition:.2s;text-decoration:none;display:inline-block;}
.filter-btn:hover,.filter-btn.active{background:#f59e0b;color:#0f1117;border-color:#f59e0b;font-weight:600;}
.search-wrap{display:flex;align-items:center;gap:8px;background:#161820;border:1px solid #2a2d3a;border-radius:8px;padding:8px 14px;}
.search-wrap input{background:transparent;border:none;outline:none;color:#e8e9f0;font-size:13px;font-family:'DM Sans',sans-serif;width:180px;}
.search-wrap input::placeholder{color:#555870;}

/* ── GRID ── */
.vehicles-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;}
@media(max-width:900px){.vehicles-grid{grid-template-columns:repeat(2,1fr);}}
@media(max-width:560px){.vehicles-grid{grid-template-columns:1fr;}}

/* ── CARD ── */
.vehicle-card{background:#161820;border:1px solid #2a2d3a;border-radius:14px;overflow:hidden;transition:all .2s;display:flex;flex-direction:column;}
.vehicle-card:hover{border-color:#f59e0b;transform:translateY(-2px);}

/* ── IMAGE ── */
.vehicle-img{height:160px;background:#0f1117;position:relative;overflow:hidden;flex-shrink:0;}
.vehicle-img img{width:100%;height:100%;object-fit:cover;display:block;}
.vehicle-img-placeholder{width:100%;height:100%;display:flex;align-items:center;justify-content:center;}
.vehicle-img-placeholder svg{width:64px;height:64px;opacity:.2;}

/* ── BADGES ── */
.badge{position:absolute;font-size:10px;padding:3px 10px;border-radius:20px;font-weight:600;z-index:2;}
.badge-type-car{top:10px;left:10px;background:#071e38;color:#60a5fa;}
.badge-type-moto{top:10px;left:10px;background:#2e1f05;color:#fbbf24;}
.badge-rented{top:10px;right:10px;background:rgba(46,13,13,.9);color:#f87171;border:1px solid #7f1d1d;}
.badge-available{top:10px;right:10px;background:rgba(13,46,26,.9);color:#4ade80;border:1px solid #166534;}

/* ── BODY ── */
.vehicle-body{padding:16px;flex:1;display:flex;flex-direction:column;}
.vehicle-name{font-family:'Syne',sans-serif;font-size:15px;font-weight:700;color:#fff;margin-bottom:2px;}
.vehicle-plate{font-size:11px;color:#555870;margin-bottom:8px;}
.availability-chip{font-size:11px;background:#2e1f05;color:#fbbf24;padding:3px 10px;border-radius:20px;display:inline-block;margin-bottom:10px;}
.vehicle-chips{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:12px;}
.chip{font-size:11px;color:#9496a8;background:#0f1117;padding:3px 10px;border-radius:20px;}
.vehicle-footer{display:flex;justify-content:space-between;align-items:center;margin-top:auto;}
.vehicle-price{font-family:'Syne',sans-serif;font-size:17px;font-weight:700;color:#f59e0b;}
.vehicle-price span{font-size:11px;color:#555870;font-family:'DM Sans',sans-serif;font-weight:400;}
.btn-louer{background:#f59e0b;color:#0f1117;padding:7px 16px;border-radius:8px;font-size:12px;font-weight:700;text-decoration:none;font-family:'Syne',sans-serif;white-space:nowrap;transition:.2s;}
.btn-louer:hover{background:#e08d00;}
.btn-reserver{background:#1e2130;color:#9496a8;padding:7px 16px;border-radius:8px;font-size:12px;font-weight:700;text-decoration:none;font-family:'Syne',sans-serif;border:1px solid #2a2d3a;white-space:nowrap;transition:.2s;}
.btn-reserver:hover{color:#fff;border-color:#555870;}

/* ── EMPTY ── */
.empty-state{text-align:center;padding:80px 20px;color:#555870;}
.empty-state svg{width:48px;height:48px;margin:0 auto 16px;display:block;opacity:.3;}

/* ── ALERT ── */
.alert-success{background:#0d2e1a;border:1px solid #166534;color:#4ade80;padding:12px 20px;border-radius:10px;margin-bottom:20px;font-size:13px;}

/* ── PAGINATION ── */
.pagination-wrap{margin-top:28px;display:flex;justify-content:center;}
.pagination-wrap nav{display:flex;gap:6px;}
.pagination-wrap .page-link{padding:6px 12px;background:#161820;border:1px solid #2a2d3a;border-radius:6px;color:#9496a8;text-decoration:none;font-size:13px;}
.pagination-wrap .page-link:hover{border-color:#f59e0b;color:#f59e0b;}
.pagination-wrap .active .page-link{background:#f59e0b;color:#0f1117;border-color:#f59e0b;}
</style>

{{-- ── HEADER ── --}}
<div class="top-bar">
    <div>
        <div class="page-title">Nos véhicules</div>
        <div class="page-sub">{{ $vehicles->total() }} véhicule(s) disponible(s)</div>
    </div>
    <form method="GET" action="{{ route('client.vehicles') }}" style="display:flex;gap:8px;flex-wrap:wrap;align-items:center;">
        <input type="hidden" name="type" value="{{ request('type') }}">
        <input type="hidden" name="filter" value="{{ request('filter') }}">
        <div class="search-wrap">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="#555870">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher...">
        </div>
        <button type="submit" style="padding:8px 16px;background:#f59e0b;border:none;border-radius:8px;color:#0f1117;font-weight:700;font-family:'DM Sans',sans-serif;cursor:pointer;font-size:13px;">OK</button>
    </form>
</div>

{{-- ── FILTRES ── --}}
<div class="filters" style="margin-bottom:24px;">
    <a href="{{ route('client.vehicles') }}"
       class="filter-btn {{ !request('filter') && !request('type') ? 'active' : '' }}">
        Tous
    </a>
    <a href="{{ route('client.vehicles',['filter'=>'available']) }}"
       class="filter-btn {{ request('filter')=='available' ? 'active' : '' }}">
        ✅ Disponibles
    </a>
    <a href="{{ route('client.vehicles',['filter'=>'rented']) }}"
       class="filter-btn {{ request('filter')=='rented' ? 'active' : '' }}">
        📅 À réserver
    </a>
    <a href="{{ route('client.vehicles',['type'=>'car']) }}"
       class="filter-btn {{ request('type')=='car' ? 'active' : '' }}">
        🚗 Voitures
    </a>
    <a href="{{ route('client.vehicles',['type'=>'motorcycle']) }}"
       class="filter-btn {{ request('type')=='motorcycle' ? 'active' : '' }}">
        🏍️ Motos
    </a>
</div>

@if(session('success'))
    <div class="alert-success">✓ {{ session('success') }}</div>
@endif

{{-- ── GRID VÉHICULES ── --}}
@if($vehicles->isEmpty())
    <div class="empty-state">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
        </svg>
        <p style="font-size:16px;font-weight:600;color:#e8e9f0;margin-bottom:8px;">Aucun véhicule trouvé</p>
        <p style="font-size:13px;">Modifiez vos filtres ou revenez plus tard.</p>
    </div>
@else
    <div class="vehicles-grid">
        @foreach($vehicles as $vehicle)
        <div class="vehicle-card">

            {{-- Image --}}
            <div class="vehicle-img">
                @if($vehicle->image_url)
                    <img src="{{ $vehicle->image_url }}"
                         alt="{{ $vehicle->brand }} {{ $vehicle->model }}"
                         onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                    <div class="vehicle-img-placeholder" style="display:none;position:absolute;inset:0;">
                        <svg fill="none" viewBox="0 0 24 24" stroke="#3a3d50">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01"/>
                        </svg>
                    </div>
                @else
                    <div class="vehicle-img-placeholder">
                        <svg fill="none" viewBox="0 0 24 24" stroke="#3a3d50">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                @endif

                {{-- Badge type --}}
                <span class="badge {{ $vehicle->type === 'car' ? 'badge-type-car' : 'badge-type-moto' }}">
                    {{ $vehicle->type === 'car' ? 'Voiture' : 'Moto' }}
                </span>

                {{-- Badge statut --}}
                @if($vehicle->status === 'available')
                    <span class="badge badge-available">Disponible</span>
                @else
                    <span class="badge badge-rented">Loué</span>
                @endif
            </div>

            {{-- Body --}}
            <div class="vehicle-body">
                <div class="vehicle-name">{{ $vehicle->brand }} {{ $vehicle->model }}</div>
                <div class="vehicle-plate">{{ $vehicle->plate }} · {{ $vehicle->year }}</div>

                {{-- Disponibilité si loué --}}
                @if($vehicle->status === 'rented' && $vehicle->next_available_date)
                    <div class="availability-chip">
                        📅 Disponible le {{ $vehicle->next_available_date }}
                    </div>
                @endif

                <div class="vehicle-chips">
                    <span class="chip">{{ number_format($vehicle->mileage,0,',',' ') }} km</span>
                    <span class="chip">{{ $vehicle->year }}</span>
                </div>

                <div class="vehicle-footer">
                    <div class="vehicle-price">
                        {{ number_format($vehicle->price_per_day,0,',',' ') }} F
                        <span>/jour</span>
                    </div>
                    <a href="{{ route('client.vehicles.show', $vehicle) }}"
                       class="{{ $vehicle->status === 'available' ? 'btn-louer' : 'btn-reserver' }}">
                        {{ $vehicle->status === 'available' ? 'Louer' : 'Réserver' }}
                    </a>
                </div>
            </div>

        </div>
        @endforeach
    </div>

    <div class="pagination-wrap">
        {{ $vehicles->links() }}
    </div>
@endif

@endsection