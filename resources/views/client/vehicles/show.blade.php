@extends('layouts.app')
@section('title',$vehicle->brand.' '.$vehicle->model)
@section('content')
<style>
.back-link{display:inline-flex;align-items:center;gap:6px;color:#9496a8;font-size:13px;text-decoration:none;margin-bottom:24px;}
.back-link:hover{color:#f59e0b;}
.vehicle-detail-grid{display:grid;grid-template-columns:1fr 380px;gap:24px;}
.vehicle-preview{background:#161820;border:1px solid #2a2d3a;border-radius:14px;padding:40px;display:flex;align-items:center;justify-content:center;min-height:240px;}
.vehicle-preview svg{width:140px;height:140px;opacity:.25;}
.vehicle-preview img{width:100%;height:100%;object-fit:cover;border-radius:14px;}
.info-card{background:#161820;border:1px solid #2a2d3a;border-radius:14px;padding:24px;}
.vehicle-title{font-family:'Syne',sans-serif;font-size:26px;font-weight:700;color:#fff;}
.vehicle-sub{color:#555870;font-size:13px;margin-top:4px;}
.price-big{font-family:'Syne',sans-serif;font-size:32px;font-weight:700;color:#f59e0b;margin:20px 0 4px;}
.price-sub{font-size:12px;color:#555870;}
.specs{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin:20px 0;}
.spec-item{background:#0f1117;border-radius:8px;padding:12px 14px;}
.spec-label{font-size:10px;color:#555870;text-transform:uppercase;letter-spacing:.8px;font-weight:600;}
.spec-value{font-size:14px;font-weight:500;color:#e8e9f0;margin-top:4px;}
.divider{border:none;border-top:1px solid #2a2d3a;margin:20px 0;}
.form-group{margin-bottom:16px;}
.form-group label{font-size:12px;color:#9496a8;display:block;margin-bottom:6px;font-weight:500;}
.form-group input,.form-group textarea{width:100%;padding:10px 14px;background:#0f1117;border:1px solid #2a2d3a;border-radius:8px;color:#e8e9f0;font-size:13px;font-family:'DM Sans',sans-serif;outline:none;transition:.2s;}
.form-group input:focus,.form-group textarea:focus{border-color:#f59e0b;}
.price-calc{background:#0f1117;border-radius:8px;padding:14px;margin:16px 0;font-size:13px;color:#9496a8;}
.price-calc strong{color:#f59e0b;font-family:'Syne',sans-serif;font-size:18px;}
.btn-big{width:100%;padding:13px;background:#f59e0b;color:#0f1117;font-size:15px;font-weight:700;font-family:'Syne',sans-serif;border:none;border-radius:8px;cursor:pointer;transition:.2s;}
.btn-big:hover{background:#e08d00;}
.err{font-size:11px;color:#f87171;margin-top:4px;}
@media(max-width:800px){.vehicle-detail-grid{grid-template-columns:1fr;}}
</style>

<a href="{{ route('client.vehicles') }}" class="back-link">
    ← Retour aux véhicules
</a>

<div class="vehicle-detail-grid">
    <div>
        <div class="vehicle-preview" style="{{ $vehicle->image ? 'padding:0;' : '' }}">
            @if($vehicle->image)
                <img src="{{ asset('storage/'.$vehicle->image) }}"
                     style="width:100%;height:100%;object-fit:cover;border-radius:14px;"
                     alt="{{ $vehicle->brand }} {{ $vehicle->model }}">
            @else
                <svg width="140" height="140" fill="none" viewBox="0 0 24 24" stroke="#3a3d50">
                    @if($vehicle->type==='car')
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.8" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.8" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2.8.933M13 16l2.8-.933M13 16H9m4 0h2m2-.933L21 14V9"/>
                    @else
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.8" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                    @endif
                </svg>
            @endif
        </div>
        @if($vehicle->description)
        <div style="background:#161820;border:1px solid #2a2d3a;border-radius:14px;padding:20px;margin-top:16px;">
            <div style="font-size:12px;color:#555870;text-transform:uppercase;letter-spacing:.8px;font-weight:600;margin-bottom:8px;">Description</div>
            <p style="font-size:14px;color:#9496a8;line-height:1.7;">{{ $vehicle->description }}</p>
        </div>
        @endif
    </div>

    <div class="info-card">
        <div class="vehicle-title">{{ $vehicle->brand }} {{ $vehicle->model }}</div>
        <div class="vehicle-sub">{{ $vehicle->plate }} · {{ $vehicle->year }}</div>
        <div class="price-big">{{ number_format($vehicle->price_per_day,0,',',' ') }} FCFA</div>
        <div class="price-sub">par jour de location</div>

        <div class="specs">
            <div class="spec-item">
                <div class="spec-label">Type</div>
                <div class="spec-value">{{ $vehicle->type === 'car' ? 'Voiture' : 'Moto' }}</div>
            </div>
            <div class="spec-item">
                <div class="spec-label">Kilométrage</div>
                <div class="spec-value">{{ number_format($vehicle->mileage,0,',',' ') }} km</div>
            </div>
            <div class="spec-item">
                <div class="spec-label">Année</div>
                <div class="spec-value">{{ $vehicle->year }}</div>
            </div>
            <div class="spec-item">
                <div class="spec-label">Statut</div>
                <div class="spec-value" style="color:#4ade80;">Disponible</div>
            </div>
        </div>

        <hr class="divider">

        <form method="POST" action="{{ route('client.rentals.store') }}" id="reserveForm">
            @csrf
            <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">

            <div class="form-group">
                <label>Date de début</label>
                <input type="date" name="start_date" id="startDate" value="{{ old('start_date') }}" min="{{ date('Y-m-d') }}" required>
                @error('start_date')<div class="err">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Date de fin</label>
                <input type="date" name="end_date" id="endDate" value="{{ old('end_date') }}" min="{{ date('Y-m-d',strtotime('+1 day')) }}" required>
                @error('end_date')<div class="err">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Notes (optionnel)</label>
                <textarea name="notes" rows="2" placeholder="Informations supplémentaires...">{{ old('notes') }}</textarea>
            </div>

            <div class="price-calc" id="priceCalc" style="display:none;">
                <div style="display:flex;justify-content:space-between;align-items:center;">
                    <span id="daysText"></span>
                    <strong id="totalText"></strong>
                </div>
                <div style="font-size:11px;margin-top:6px;color:#555870;">+ Caution : <span id="depositText"></span> FCFA (30%)</div>
            </div>

            <button type="submit" class="btn-big">Confirmer la réservation →</button>
        </form>
    </div>
</div>

<script>
const pricePerDay = {{ $vehicle->price_per_day }};
const startInput = document.getElementById('startDate');
const endInput   = document.getElementById('endDate');
const calc       = document.getElementById('priceCalc');

function updateCalc() {
    const s = new Date(startInput.value);
    const e = new Date(endInput.value);
    if (startInput.value && endInput.value && e > s) {
        const days  = Math.round((e - s) / 86400000);
        const total = days * pricePerDay;
        document.getElementById('daysText').textContent = days + ' jour(s)';
        document.getElementById('totalText').textContent = total.toLocaleString('fr') + ' FCFA';
        document.getElementById('depositText').textContent = Math.round(total * 0.3).toLocaleString('fr');
        calc.style.display = 'block';
    } else {
        calc.style.display = 'none';
    }
}
startInput.addEventListener('change', updateCalc);
endInput.addEventListener('change', updateCalc);
</script>
@endsection