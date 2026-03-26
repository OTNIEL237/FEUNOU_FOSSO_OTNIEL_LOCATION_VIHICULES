@extends('layouts.app')
@section('title','Mes Locations')
@section('content')
<style>
.rental-list{display:flex;flex-direction:column;gap:12px;}
.rental-card{background:#161820;border:1px solid #2a2d3a;border-radius:12px;padding:20px 24px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;transition:.2s;}
.rental-card:hover{border-color:#2a2d4a;}
.rental-left{display:flex;align-items:center;gap:16px;}
.rental-icon{width:44px;height:44px;background:#0f1117;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.rental-icon svg{width:22px;height:22px;color:#f59e0b;}
.rental-name{font-family:'Syne',sans-serif;font-size:15px;font-weight:600;color:#fff;}
.rental-dates{font-size:12px;color:#555870;margin-top:3px;}
.rental-right{display:flex;align-items:center;gap:16px;flex-wrap:wrap;}
.rental-price{font-family:'Syne',sans-serif;font-size:16px;font-weight:700;color:#f59e0b;}
.sp{padding:4px 12px;border-radius:20px;font-size:11px;font-weight:600;}
.btn-sm{font-size:12px;padding:6px 14px;border-radius:8px;background:#1e2130;color:#9496a8;text-decoration:none;border:1px solid #2a2d3a;transition:.2s;}
.btn-sm:hover{color:#fff;border-color:#555870;}
.empty-state{text-align:center;padding:80px;color:#555870;}
.alert-success{background:#0d2e1a;border:1px solid #166534;color:#4ade80;padding:12px 20px;border-radius:10px;margin-bottom:20px;font-size:13px;}
@media(max-width:600px){.rental-card{flex-direction:column;align-items:flex-start;}.rental-right{width:100%;justify-content:space-between;}}
</style>

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:28px;flex-wrap:wrap;gap:12px;">
    <div>
        <h1 style="font-family:'Syne',sans-serif;font-size:22px;font-weight:700;color:#fff;">Mes Locations</h1>
        <p style="color:#9496a8;font-size:13px;margin-top:2px;">{{ $rentals->total() }} location(s) au total</p>
    </div>
    <a href="{{ route('client.vehicles') }}" style="background:#f59e0b;color:#0f1117;padding:10px 20px;border-radius:8px;font-weight:700;font-family:'Syne',sans-serif;font-size:13px;text-decoration:none;">+ Nouvelle réservation</a>
</div>

@if(session('success'))
    <div class="alert-success">✓ {{ session('success') }}</div>
@endif

@if($rentals->isEmpty())
    <div class="empty-state">
        <p style="font-size:16px;font-weight:500;color:#e8e9f0;margin-bottom:8px;">Aucune location</p>
        <p style="font-size:13px;margin-bottom:20px;">Commencez par réserver un véhicule.</p>
        <a href="{{ route('client.vehicles') }}" style="background:#f59e0b;color:#0f1117;padding:10px 24px;border-radius:8px;font-weight:700;font-family:'Syne',sans-serif;font-size:13px;text-decoration:none;">Voir les véhicules</a>
    </div>
@else
    <div class="rental-list">
        @foreach($rentals as $rental)
        <div class="rental-card">
            <div class="rental-left">
                <div class="rental-icon">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <div>
                    <div class="rental-name">{{ $rental->vehicle->brand }} {{ $rental->vehicle->model }}</div>
                    <div class="rental-dates">
                        {{ $rental->start_date->format('d/m/Y') }} → {{ $rental->end_date->format('d/m/Y') }}
                        · {{ $rental->total_days }} jour(s)
                    </div>
                </div>
            </div>
            <div class="rental-right">
                <div class="rental-price">{{ number_format($rental->total_price,0,',',' ') }} F</div>
                <span class="sp" style="
                    @if($rental->status=='ongoing') background:#0d2e1a;color:#4ade80;
                    @elseif($rental->status=='pending') background:#2e1f05;color:#fbbf24;
                    @elseif($rental->status=='confirmed') background:#071e38;color:#60a5fa;
                    @elseif($rental->status=='completed') background:#1a1a2e;color:#a78bfa;
                    @else background:#2e0d0d;color:#f87171; @endif
                ">{{ ucfirst($rental->status) }}</span>
                @if($rental->contract)
                <a href="{{ route('client.contracts.show',$rental->contract) }}" class="btn-sm">Contrat</a>
                @endif

                @if(in_array($rental->status, ['pending','confirmed']) && !$rental->payments()->where('status','paid')->exists())
                <a href="{{ route('client.payment.checkout', $rental) }}"
                style="background:#f59e0b;color:#0f1117;padding:6px 14px;border-radius:8px;font-size:12px;font-weight:700;text-decoration:none;font-family:'Syne',sans-serif;">
                    Payer
                </a>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    <div style="margin-top:24px;display:flex;justify-content:center;">{{ $rentals->links() }}</div>
@endif
@endsection