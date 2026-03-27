{{-- Aperçu véhicule avec Cloudinary --}}
<div class="vehicle-preview" style="{{ $vehicle->image_url ? 'padding:0;overflow:hidden;' : '' }}">
    @if($vehicle->image_url)
        <img src="{{ $vehicle->image_url }}"
             style="width:100%;height:100%;object-fit:cover;border-radius:14px;"
             alt="{{ $vehicle->brand }}">
    @else
        <svg width="140" height="140" fill="none" viewBox="0 0 24 24" stroke="#3a3d50">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.8"
                d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
        </svg>
    @endif
</div>

{{-- Message si véhicule loué --}}
@if($vehicle->status === 'rented' && isset($activeRental))
<div style="background:#2e1f05;border:1px solid #92400e;border-radius:10px;padding:14px 16px;margin-bottom:20px;">
    <div style="font-size:12px;color:#fbbf24;font-weight:600;margin-bottom:4px;">
        🔒 Véhicule actuellement en location
    </div>
    <div style="font-size:13px;color:#9496a8;">
        Disponible à partir du
        <strong style="color:#fbbf24;">{{ $activeRental->end_date->addDay()->format('d/m/Y') }}</strong>
    </div>
    <div style="font-size:11px;color:#555870;margin-top:4px;">
        Vous pouvez programmer une réservation pour cette date.
    </div>
</div>
@endif

{{-- Formulaire avec date minimum dynamique --}}
<form method="POST" action="{{ route('client.rentals.store') }}">
    @csrf
    <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
    
    @php
        $minDate = date('Y-m-d');
        $isReservation = false;
        if ($vehicle->status === 'rented' && isset($activeRental)) {
            $minDate = $activeRental->end_date->addDay()->format('Y-m-d');
            $isReservation = true;
        }
    @endphp

    @if($isReservation)
    <div style="background:#071e38;border:1px solid #1e3a5f;border-radius:8px;padding:10px 14px;margin-bottom:16px;font-size:12px;color:#60a5fa;">
        📅 Réservation future — Les dates commencent le {{ \Carbon\Carbon::parse($minDate)->format('d/m/Y') }}
    </div>
    @endif

    <div class="form-group">
        <label>Date de début</label>
        <input type="date"
               name="start_date"
               id="startDate"
               value="{{ old('start_date', $minDate) }}"
               min="{{ $minDate }}"
               required>
        @error('start_date')<div class="err">{{ $message }}</div>@enderror
    </div>
    
    <div class="form-group">
        <label>Date de fin</label>
        <input type="date"
               name="end_date"
               id="endDate"
               value="{{ old('end_date') }}"
               min="{{ \Carbon\Carbon::parse($minDate)->addDay()->format('Y-m-d') }}"
               required>
        @error('end_date')<div class="err">{{ $message }}</div>@enderror
    </div>
    
    <div class="form-group">
        <label>Notes (optionnel)</label>
        <textarea name="notes" rows="2" placeholder="Informations supplémentaires...">{{ old('notes') }}</textarea>
    </div>

    <button type="submit" class="btn-big">
        {{ $isReservation ? '📅 Programmer la réservation →' : '🔑 Confirmer la location →' }}
    </button>
</form>