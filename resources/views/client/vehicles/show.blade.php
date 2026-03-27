@extends('layouts.app')
@section('title', $vehicle->brand.' '.$vehicle->model)
@section('content')
<style>
/* ── BACK LINK ── */
.back-link{display:inline-flex;align-items:center;gap:6px;color:#9496a8;font-size:13px;text-decoration:none;margin-bottom:24px;padding:8px 14px;background:#161820;border:1px solid #2a2d3a;border-radius:8px;transition:.2s;}
.back-link:hover{color:#f59e0b;border-color:#f59e0b;}

/* ── GRID ── */
.detail-grid{display:grid;grid-template-columns:1fr 380px;gap:24px;align-items:start;}
@media(max-width:820px){.detail-grid{grid-template-columns:1fr;}}

/* ── IMAGE CARD ── */
.img-card{background:#161820;border:1px solid #2a2d3a;border-radius:14px;overflow:hidden;}
.img-card img{width:100%;height:280px;object-fit:cover;display:block;}
.img-placeholder{height:220px;display:flex;align-items:center;justify-content:center;background:#0f1117;}
.img-placeholder svg{width:80px;height:80px;opacity:.2;}

/* ── DESC CARD ── */
.desc-card{background:#161820;border:1px solid #2a2d3a;border-radius:14px;padding:20px;margin-top:16px;}
.desc-title{font-size:11px;color:#555870;text-transform:uppercase;letter-spacing:.8px;font-weight:600;margin-bottom:8px;}
.desc-text{font-size:14px;color:#9496a8;line-height:1.7;}

/* ── INFO CARD ── */
.info-card{background:#161820;border:1px solid #2a2d3a;border-radius:14px;padding:24px;}

/* ── VEHICLE TITLE ── */
.vehicle-title{font-family:'Syne',sans-serif;font-size:24px;font-weight:700;color:#fff;margin-bottom:4px;}
.vehicle-sub{color:#555870;font-size:13px;margin-bottom:16px;}

/* ── PRICE ── */
.price-big{font-family:'Syne',sans-serif;font-size:30px;font-weight:700;color:#f59e0b;margin-bottom:2px;}
.price-sub{font-size:12px;color:#555870;margin-bottom:20px;}

/* ── SPECS ── */
.specs-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:20px;}
.spec-item{background:#0f1117;border-radius:8px;padding:12px 14px;}
.spec-label{font-size:10px;color:#555870;text-transform:uppercase;letter-spacing:.8px;font-weight:600;margin-bottom:4px;}
.spec-value{font-size:14px;font-weight:500;color:#e8e9f0;}

/* ── DIVIDER ── */
.divider{border:none;border-top:1px solid #2a2d3a;margin:20px 0;}

/* ── ALERT RENTED ── */
.alert-rented{background:#2e1f05;border:1px solid #92400e;border-radius:10px;padding:14px 16px;margin-bottom:20px;}
.alert-rented-title{font-size:12px;color:#fbbf24;font-weight:600;margin-bottom:4px;}
.alert-rented-text{font-size:13px;color:#9496a8;}
.alert-rented-date{color:#fbbf24;font-weight:600;}

/* ── RESERVATION BADGE ── */
.resa-badge{background:#071e38;border:1px solid #1e3a5f;border-radius:8px;padding:10px 14px;margin-bottom:16px;font-size:12px;color:#60a5fa;}

/* ── FORM ── */
.form-group{margin-bottom:16px;}
.form-group label{font-size:12px;color:#9496a8;display:block;margin-bottom:6px;font-weight:500;}
.form-group input,.form-group textarea{width:100%;padding:11px 14px;background:#0f1117;border:1px solid #2a2d3a;border-radius:8px;color:#e8e9f0;font-size:14px;font-family:'DM Sans',sans-serif;outline:none;transition:.2s;-webkit-appearance:none;}
.form-group input:focus,.form-group textarea:focus{border-color:#f59e0b;}
.form-group textarea{resize:vertical;min-height:70px;}
.err{font-size:11px;color:#f87171;margin-top:4px;}

/* ── PRICE CALC ── */
.price-calc{background:#0f1117;border:1px solid #2a2d3a;border-radius:8px;padding:14px;margin:16px 0;}
.price-calc-row{display:flex;justify-content:space-between;align-items:center;font-size:13px;color:#9496a8;}
.price-calc-total{font-family:'Syne',sans-serif;font-size:16px;font-weight:700;color:#f59e0b;}
.price-calc-deposit{font-size:11px;color:#555870;margin-top:6px;}

/* ── BUTTON ── */
.btn-big{width:100%;padding:13px;background:#f59e0b;color:#0f1117;font-size:15px;font-weight:700;font-family:'Syne',sans-serif;border:none;border-radius:8px;cursor:pointer;transition:.2s;margin-top:4px;}
.btn-big:hover{background:#e08d00;}
.btn-big-resa{background:#3730a3;color:#fff;}
.btn-big-resa:hover{background:#2d27a0;}
</style>

<a href="{{ route('client.vehicles') }}" class="back-link">
    ← Retour aux véhicules
</a>

<div class="detail-grid">

    {{-- ── COLONNE GAUCHE ── --}}
    <div>
        {{-- Image --}}
        <div class="img-card">
            @if($vehicle->image_url)
                <img src="{{ $vehicle->image_url }}"
                     alt="{{ $vehicle->brand }} {{ $vehicle->model }}"
                     onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                <div class="img-placeholder" style="display:none;">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14"/>
                    </svg>
                </div>
            @else
                <div class="img-placeholder">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
            @endif
        </div>

        {{-- Description --}}
        @if($vehicle->description)
        <div class="desc-card">
            <div class="desc-title">Description</div>
            <div class="desc-text">{{ $vehicle->description }}</div>
        </div>
        @endif

        {{-- Specs mobile (visible sous l'image sur mobile) --}}
        <div class="desc-card" style="margin-top:16px;">
            <div class="desc-title">Caractéristiques</div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-top:8px;">
                <div style="background:#0f1117;border-radius:8px;padding:10px 12px;">
                    <div style="font-size:10px;color:#555870;text-transform:uppercase;letter-spacing:.8px;font-weight:600;margin-bottom:3px;">Type</div>
                    <div style="font-size:13px;font-weight:500;color:#e8e9f0;">{{ $vehicle->type === 'car' ? 'Voiture' : 'Moto' }}</div>
                </div>
                <div style="background:#0f1117;border-radius:8px;padding:10px 12px;">
                    <div style="font-size:10px;color:#555870;text-transform:uppercase;letter-spacing:.8px;font-weight:600;margin-bottom:3px;">Année</div>
                    <div style="font-size:13px;font-weight:500;color:#e8e9f0;">{{ $vehicle->year }}</div>
                </div>
                <div style="background:#0f1117;border-radius:8px;padding:10px 12px;">
                    <div style="font-size:10px;color:#555870;text-transform:uppercase;letter-spacing:.8px;font-weight:600;margin-bottom:3px;">Kilométrage</div>
                    <div style="font-size:13px;font-weight:500;color:#e8e9f0;">{{ number_format($vehicle->mileage,0,',',' ') }} km</div>
                </div>
                <div style="background:#0f1117;border-radius:8px;padding:10px 12px;">
                    <div style="font-size:10px;color:#555870;text-transform:uppercase;letter-spacing:.8px;font-weight:600;margin-bottom:3px;">Statut</div>
                    <div style="font-size:13px;font-weight:500;color:{{ $vehicle->status === 'available' ? '#4ade80' : '#fbbf24' }};">
                        {{ $vehicle->status === 'available' ? 'Disponible' : 'En location' }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── COLONNE DROITE ── --}}
    <div class="info-card">
        <div class="vehicle-title">{{ $vehicle->brand }} {{ $vehicle->model }}</div>
        <div class="vehicle-sub">{{ $vehicle->plate }} · {{ $vehicle->year }}</div>

        <div class="price-big">{{ number_format($vehicle->price_per_day,0,',',' ') }} FCFA</div>
        <div class="price-sub">par jour de location</div>

        <hr class="divider">

        {{-- Alerte véhicule loué --}}
        @if($vehicle->status === 'rented' && isset($activeRental) && $activeRental)
        <div class="alert-rented">
            <div class="alert-rented-title">🔒 Véhicule actuellement en location</div>
            <div class="alert-rented-text">
                Disponible à partir du
                <span class="alert-rented-date">
                    {{ $activeRental->end_date->addDay()->format('d/m/Y') }}
                </span>
            </div>
            <div style="font-size:11px;color:#555870;margin-top:4px;">
                Vous pouvez programmer une réservation dès maintenant.
            </div>
        </div>
        @endif

        {{-- Badge réservation --}}
        @if(isset($isReservation) && $isReservation)
        <div class="resa-badge">
            📅 Réservation — disponible le {{ \Carbon\Carbon::parse($minDate)->format('d/m/Y') }}
        </div>
        @endif

        {{-- Formulaire --}}
        <form method="POST" action="{{ route('client.rentals.store') }}" id="reserveForm">
            @csrf
            <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">

            <div class="form-group">
                <label>Date de début</label>
                <input type="date"
                       name="start_date"
                       id="startDate"
                       value="{{ old('start_date', $minDate ?? date('Y-m-d')) }}"
                       min="{{ $minDate ?? date('Y-m-d') }}"
                       required>
                @error('start_date')<div class="err">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label>Date de fin</label>
                <input type="date"
                       name="end_date"
                       id="endDate"
                       value="{{ old('end_date') }}"
                       min="{{ isset($minDate) ? \Carbon\Carbon::parse($minDate)->addDay()->format('Y-m-d') : date('Y-m-d', strtotime('+1 day')) }}"
                       required>
                @error('end_date')<div class="err">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label>Notes (optionnel)</label>
                <textarea name="notes" placeholder="Informations supplémentaires...">{{ old('notes') }}</textarea>
            </div>

            {{-- Calcul prix --}}
            <div class="price-calc" id="priceCalc" style="display:none;">
                <div class="price-calc-row">
                    <span id="daysText">0 jour(s)</span>
                    <span class="price-calc-total" id="totalText">0 FCFA</span>
                </div>
                <div class="price-calc-deposit">
                    Caution (30%) : <span id="depositText">0</span> FCFA
                </div>
            </div>

            <button type="submit" class="btn-big {{ isset($isReservation) && $isReservation ? 'btn-big-resa' : '' }}">
                {{ isset($isReservation) && $isReservation ? '📅 Programmer la réservation →' : '✓ Confirmer la location →' }}
            </button>
        </form>
    </div>

</div>

<script>
const pricePerDay = {{ $vehicle->price_per_day }};
const startInput  = document.getElementById('startDate');
const endInput    = document.getElementById('endDate');
const calcBox     = document.getElementById('priceCalc');

function updateCalc() {
    const s = new Date(startInput.value);
    const e = new Date(endInput.value);
    if (startInput.value && endInput.value && e > s) {
        const days    = Math.round((e - s) / 86400000);
        const total   = days * pricePerDay;
        const deposit = Math.round(total * 0.3);
        document.getElementById('daysText').textContent    = days + ' jour(s)';
        document.getElementById('totalText').textContent   = total.toLocaleString('fr') + ' FCFA';
        document.getElementById('depositText').textContent = deposit.toLocaleString('fr');
        calcBox.style.display = 'block';
    } else {
        calcBox.style.display = 'none';
    }
}

startInput.addEventListener('change', function() {
    // Ajuste la date min de fin
    const s = new Date(this.value);
    s.setDate(s.getDate() + 1);
    endInput.min = s.toISOString().split('T')[0];
    if (endInput.value && new Date(endInput.value) <= new Date(this.value)) {
        endInput.value = s.toISOString().split('T')[0];
    }
    updateCalc();
});

endInput.addEventListener('change', updateCalc);
</script>
@endsection