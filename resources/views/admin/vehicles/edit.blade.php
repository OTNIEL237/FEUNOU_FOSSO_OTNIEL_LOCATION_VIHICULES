@extends('layouts.app')
@section('title','Modifier '.$vehicle->brand)
@section('content')
<style>
.form-card{background:#161820;border:1px solid #2a2d3a;border-radius:14px;padding:32px;max-width:700px;}
.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
.form-group.full{grid-column:span 2;}
label{font-size:12px;color:#9496a8;display:block;margin-bottom:6px;font-weight:500;}
input,select,textarea{width:100%;padding:11px 14px;background:#0f1117;border:1px solid #2a2d3a;border-radius:8px;color:#e8e9f0;font-size:14px;font-family:'DM Sans',sans-serif;outline:none;transition:.2s;}
input:focus,select:focus,textarea:focus{border-color:#f59e0b;}
select option{background:#161820;}
.err{font-size:11px;color:#f87171;margin-top:4px;}
.btn-submit{background:#f59e0b;color:#0f1117;padding:12px 28px;border-radius:8px;font-size:14px;font-weight:700;font-family:'Syne',sans-serif;border:none;cursor:pointer;}
.btn-cancel{padding:12px 20px;background:transparent;border:1px solid #2a2d3a;border-radius:8px;color:#9496a8;font-size:14px;text-decoration:none;}
.back-link{display:inline-flex;align-items:center;gap:6px;color:#9496a8;font-size:13px;text-decoration:none;margin-bottom:24px;}
.back-link:hover{color:#f59e0b;}
.upload-zone{border:2px dashed #2a2d3a;border-radius:10px;padding:24px;text-align:center;cursor:pointer;transition:.2s;background:#0f1117;position:relative;}
.upload-zone:hover{border-color:#f59e0b;}
.upload-zone input[type=file]{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%;}
.current-img{width:100%;max-height:180px;object-fit:cover;border-radius:8px;margin-bottom:12px;border:1px solid #2a2d3a;}
.preview-img{width:100%;max-height:180px;object-fit:cover;border-radius:8px;margin-top:12px;display:none;border:1px solid #2a2d3a;}
@media(max-width:600px){.form-grid{grid-template-columns:1fr;}.form-group.full{grid-column:span 1;}}
</style>

<a href="{{ route('admin.vehicles.index') }}" class="back-link">← Retour</a>
<div class="page-header"><h1>Modifier le véhicule</h1><p>{{ $vehicle->brand }} {{ $vehicle->model }} — {{ $vehicle->plate }}</p></div>

<div class="form-card">
    <form method="POST" action="{{ route('admin.vehicles.update',$vehicle) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="form-grid">
            <div class="form-group">
                <label>Marque *</label>
                <input type="text" name="brand" value="{{ old('brand',$vehicle->brand) }}">
                @error('brand')<div class="err">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Modèle *</label>
                <input type="text" name="model" value="{{ old('model',$vehicle->model) }}">
            </div>
            <div class="form-group">
                <label>Type *</label>
                <select name="type">
                    <option value="car" {{ $vehicle->type=='car'?'selected':'' }}>Voiture</option>
                    <option value="motorcycle" {{ $vehicle->type=='motorcycle'?'selected':'' }}>Moto</option>
                </select>
            </div>
            <div class="form-group">
                <label>Année *</label>
                <input type="number" name="year" value="{{ old('year',$vehicle->year) }}" min="1990" max="{{ date('Y') }}">
            </div>
            <div class="form-group">
                <label>Plaque *</label>
                <input type="text" name="plate" value="{{ old('plate',$vehicle->plate) }}">
                @error('plate')<div class="err">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Prix par jour (FCFA) *</label>
                <input type="number" name="price_per_day" value="{{ old('price_per_day',$vehicle->price_per_day) }}" min="1">
            </div>
            <div class="form-group">
                <label>Kilométrage *</label>
                <input type="number" name="mileage" value="{{ old('mileage',$vehicle->mileage) }}" min="0">
            </div>
            <div class="form-group">
                <label>Statut *</label>
                <select name="status">
                    <option value="available" {{ $vehicle->status=='available'?'selected':'' }}>Disponible</option>
                    <option value="rented" {{ $vehicle->status=='rented'?'selected':'' }}>En location</option>
                    <option value="maintenance" {{ $vehicle->status=='maintenance'?'selected':'' }}>Maintenance</option>
                </select>
            </div>
            <div class="form-group full">
                <label>Photo du véhicule</label>
                @if($vehicle->image)
                    <img src="{{ asset('storage/'.$vehicle->image) }}" class="current-img" alt="Image actuelle">
                    <p style="font-size:11px;color:#555870;margin-bottom:8px;">Image actuelle — Choisir une nouvelle pour remplacer</p>
                @endif
                <div class="upload-zone">
                    <input type="file" name="image" accept="image/*" onchange="previewImage(event)">
                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#555870" style="margin:0 auto 8px;display:block;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <p style="font-size:13px;color:#555870;">Cliquez pour changer l'image</p>
                </div>
                <img id="previewImg" class="preview-img" src="" alt="Aperçu">
            </div>
            <div class="form-group full">
                <label>Description</label>
                <textarea name="description" rows="3">{{ old('description',$vehicle->description) }}</textarea>
            </div>
        </div>
        <div style="margin-top:24px;display:flex;gap:12px;flex-wrap:wrap;">
            <a href="{{ route('admin.vehicles.index') }}" class="btn-cancel">Annuler</a>
            <button type="submit" class="btn-submit">Enregistrer les modifications</button>
        </div>
    </form>
</div>
<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        const img = document.getElementById('previewImg');
        img.src = e.target.result;
        img.style.display = 'block';
    };
    reader.readAsDataURL(file);
}
</script>
@endsection