@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Nos véhicules</h1>

    {{-- Filtres --}}
    <div class="filters">
        <a href="{{ route('client.vehicles') }}" class="filter-btn {{ !request('filter') && !request('type') ? 'active' : '' }}">
            Tous
        </a>
        <a href="{{ route('client.vehicles',['filter'=>'available']) }}" 
           class="filter-btn {{ request('filter')=='available' ? 'active' : '' }}">
            Disponibles
        </a>
        <a href="{{ route('client.vehicles',['filter'=>'rented']) }}" 
           class="filter-btn {{ request('filter')=='rented' ? 'active' : '' }}">
            À réserver
        </a>
        <a href="{{ route('client.vehicles',['type'=>'car']) }}" 
           class="filter-btn {{ request('type')=='car' ? 'active' : '' }}">
            Voitures
        </a>
        <a href="{{ route('client.vehicles',['type'=>'motorcycle']) }}" 
           class="filter-btn {{ request('type')=='motorcycle' ? 'active' : '' }}">
            Motos
        </a>
    </div>

    {{-- Liste des véhicules --}}
    <div class="vehicles-grid">
        @foreach($vehicles as $vehicle)
        <div class="vehicle-card" style="{{ $vehicle->status === 'rented' ? 'opacity:.9;' : '' }}">
            <div class="vehicle-img">
                @if($vehicle->image_url)
                    <img src="{{ $vehicle->image_url }}"
                         style="width:100%;height:100%;object-fit:cover;"
                         alt="{{ $vehicle->brand }} {{ $vehicle->model }}">
                @else
                    <svg width="80" height="80" fill="none" viewBox="0 0 24 24" stroke="#3a3d50">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                @endif

                {{-- Badge statut --}}
                @if($vehicle->status === 'rented')
                    <span class="type-badge" style="background:#2e0d0d;color:#f87171;top:10px;right:10px;left:auto;">
                        🔒 Loué
                    </span>
                @endif
                
                <span class="type-badge {{ $vehicle->type === 'car' ? 'type-car' : 'type-moto' }}">
                    {{ $vehicle->type === 'car' ? '🚗 Voiture' : '🏍️ Moto' }}
                </span>
            </div>

            <div class="vehicle-body">
                <div class="vehicle-name">{{ $vehicle->brand }} {{ $vehicle->model }}</div>
                <div class="vehicle-plate">{{ $vehicle->plate }} · {{ $vehicle->year }}</div>

                {{-- Prochaine disponibilité --}}
                @if($vehicle->status === 'rented' && $vehicle->next_available_date)
                    <div style="margin-top:8px;font-size:11px;background:#2e1f05;color:#fbbf24;padding:4px 10px;border-radius:20px;display:inline-block;">
                        📅 Disponible le {{ $vehicle->next_available_date }}
                    </div>
                @endif

                <div class="vehicle-details">
                    <span class="detail-chip">{{ number_format($vehicle->mileage,0,',',' ') }} km</span>
                </div>
                
                <div class="vehicle-meta">
                    <div class="vehicle-price">
                        {{ number_format($vehicle->price_per_day,0,',',' ') }} F<span>/jour</span>
                    </div>
                    <a href="{{ route('client.vehicles.show',$vehicle) }}"
                       class="btn-reserve"
                       style="{{ $vehicle->status === 'rented' ? 'background:#3a3d50;color:#9496a8;' : '' }}">
                        {{ $vehicle->status === 'rented' ? '📅 Réserver' : '🔑 Louer' }}
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{ $vehicles->links() }}
</div>
@endsection