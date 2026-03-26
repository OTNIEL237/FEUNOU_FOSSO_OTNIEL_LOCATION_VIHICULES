@extends('layouts.app')
@section('title','Véhicules disponibles')
@section('content')
<style>
.top-bar{display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;margin-bottom:28px;}
.filters{display:flex;gap:10px;flex-wrap:wrap;}
.filter-btn{padding:7px 16px;border-radius:20px;border:1px solid #2a2d3a;background:transparent;color:#9496a8;font-size:12px;font-family:'DM Sans',sans-serif;cursor:pointer;transition:.2s;}
.filter-btn:hover,.filter-btn.active{background:#f59e0b;color:#0f1117;border-color:#f59e0b;font-weight:600;}
.search-box{display:flex;align-items:center;gap:8px;background:#161820;border:1px solid #2a2d3a;border-radius:8px;padding:8px 14px;}
.search-box input{background:transparent;border:none;outline:none;color:#e8e9f0;font-size:13px;font-family:'DM Sans',sans-serif;width:200px;}
.search-box input::placeholder{color:#555870;}

.vehicles-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;}
.vehicle-card{background:#161820;border:1px solid #2a2d3a;border-radius:14px;overflow:hidden;transition:.2s;}
.vehicle-card:hover{border-color:#f59e0b;transform:translateY(-2px);}
.vehicle-img{height:140px;background:#0f1117;display:flex;align-items:center;justify-content:center;position:relative;}
.vehicle-img svg{width:80px;height:80px;opacity:.3;}
.vehicle-img img{width:100%;height:100%;object-fit:cover;}
.type-badge{position:absolute;top:10px;left:10px;font-size:10px;padding:3px 10px;border-radius:20px;font-weight:600;}
.type-car{background:#071e38;color:#60a5fa;}
.type-moto{background:#2e1f05;color:#fbbf24;}
.vehicle-body{padding:16px;}
.vehicle-name{font-family:'Syne',sans-serif;font-size:16px;font-weight:700;color:#fff;}
.vehicle-plate{font-size:11px;color:#555870;margin-top:2px;}
.vehicle-meta{display:flex;justify-content:space-between;align-items:center;margin-top:12px;}
.vehicle-price{font-family:'Syne',sans-serif;font-size:18px;font-weight:700;color:#f59e0b;}
.vehicle-price span{font-size:11px;color:#555870;font-family:'DM Sans',sans-serif;font-weight:400;}
.btn-reserve{background:#f59e0b;color:#0f1117;padding:7px 16px;border-radius:8px;font-size:12px;font-weight:700;text-decoration:none;font-family:'Syne',sans-serif;white-space:nowrap;}
.vehicle-details{display:flex;gap:12px;margin-top:10px;}
.detail-chip{font-size:11px;color:#9496a8;background:#0f1117;padding:3px 10px;border-radius:20px;}
.empty-state{text-align:center;padding:80px 20px;color:#555870;}
.empty-state svg{width:48px;height:48px;margin-bottom:16px;opacity:.3;}
.pagination-wrap{margin-top:24px;display:flex;justify-content:center;}

.alert-success{background:#0d2e1a;border:1px solid #166534;color:#4ade80;padding:12px 20px;border-radius:10px;margin-bottom:20px;font-size:13px;}

@media(max-width:900px){.vehicles-grid{grid-template-columns:repeat(2,1fr);}}
@media(max-width:580px){.vehicles-grid{grid-template-columns:1fr;}.search-box input{width:120px;}}
</style>

<div class="top-bar">
    <div>
        <h1 style="font-family:'Syne',sans-serif;font-size:22px;font-weight:700;color:#fff;">Véhicules disponibles</h1>
        <p style="color:#9496a8;font-size:13px;margin-top:2px;">{{ $vehicles->total() }} véhicule(s) trouvé(s)</p>
    </div>
    <div style="display:flex;gap:10px;flex-wrap:wrap;">
        <div class="filters">
            <a href="{{ route('client.vehicles') }}" class="filter-btn {{ !request('type') ? 'active' : '' }}">Tous</a>
            <a href="{{ route('client.vehicles',['type'=>'car']) }}" class="filter-btn {{ request('type')=='car' ? 'active' : '' }}">Voitures</a>
            <a href="{{ route('client.vehicles',['type'=>'motorcycle']) }}" class="filter-btn {{ request('type')=='motorcycle' ? 'active' : '' }}">Motos</a>
        </div>
        <form method="GET" action="{{ route('client.vehicles') }}">
            <input type="hidden" name="type" value="{{ request('type') }}">
            <div class="search-box">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="#555870"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher...">
            </div>
        </form>
    </div>
</div>

@if(session('success'))
    <div class="alert-success">✓ {{ session('success') }}</div>
@endif

@if($vehicles->isEmpty())
    <div class="empty-state">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
        <p style="font-size:16px;font-weight:500;color:#e8e9f0;margin-bottom:8px;">Aucun véhicule disponible</p>
        <p style="font-size:13px;">Revenez plus tard ou modifiez vos filtres.</p>
    </div>
@else
    <div class="vehicles-grid">
        @foreach($vehicles as $vehicle)
        <div class="vehicle-card">
            <div class="vehicle-img">
                @if($vehicle->image)
                    <img src="{{ asset('storage/'.$vehicle->image) }}"
                         style="width:100%;height:100%;object-fit:cover;"
                         alt="{{ $vehicle->brand }} {{ $vehicle->model }}">
                @else
                    @if($vehicle->type === 'car')
                        <svg width="80" height="80" fill="none" viewBox="0 0 24 24" stroke="#3a3d50"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2.8.933M13 16l2.8-.933M13 16H9m4 0h2m2-.933L21 14V9"/></svg>
                    @else
                        <svg width="80" height="80" fill="none" viewBox="0 0 24 24" stroke="#3a3d50"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                    @endif
                @endif
                <span class="type-badge {{ $vehicle->type === 'car' ? 'type-car' : 'type-moto' }}">
                    {{ $vehicle->type === 'car' ? 'Voiture' : 'Moto' }}
                </span>
            </div>
            <div class="vehicle-body">
                <div class="vehicle-name">{{ $vehicle->brand }} {{ $vehicle->model }}</div>
                <div class="vehicle-plate">{{ $vehicle->plate }} · {{ $vehicle->year }}</div>
                <div class="vehicle-details">
                    <span class="detail-chip">{{ number_format($vehicle->mileage,0,',',' ') }} km</span>
                    <span class="detail-chip">{{ ucfirst($vehicle->type) }}</span>
                </div>
                <div class="vehicle-meta">
                    <div class="vehicle-price">
                        {{ number_format($vehicle->price_per_day,0,',',' ') }} F<span>/jour</span>
                    </div>
                    <a href="{{ route('client.vehicles.show',$vehicle) }}" class="btn-reserve">Réserver</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="pagination-wrap">{{ $vehicles->links() }}</div>
@endif
@endsection