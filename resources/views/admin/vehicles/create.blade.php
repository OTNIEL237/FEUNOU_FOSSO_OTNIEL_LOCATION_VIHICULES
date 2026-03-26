@extends('layouts.app')
@section('title','Ajouter un véhicule')
@section('content')
<style>
.form-card{background:#161820;border:1px solid #2a2d3a;border-radius:14px;padding:32px;max-width:700px;}
.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
.form-group{margin-bottom:0;}
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

/* Upload zone */
.upload-zone{border:2px dashed #2a2d3a;border-radius:10px;padding:32px;text-align:center;cursor:pointer;transition:.2s;background:#0f1117;position:relative;}
.upload-zone:hover{border-color:#f59e0b;}
.upload-zone input[type=file]{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%;}
.upload-zone svg{width:32px;height:32px;color:#555870;margin:0 auto 10px;display:block;}
.upload-zone p{font-size:13px;color:#555870;}
.upload-zone span{font-size:11px;color:#3a3d50;}
.preview-img{width:100%;max-height:200px;object-fit:cover;border-radius:8px;margin-top:12px;display:none;border:1px solid #2a2d3a;}

@media(max-width:600px){.form-grid{grid-template-columns:1fr;}.form-group.full{grid-column:span 1;}}
</style>

<a href="{{ route('admin.vehicles.index') }}" class="back-link">← Retour aux véhicules</a>
<div class="page-header"><h1>Ajouter un véhicule</h1><p>Remplissez les informations du véhicule</p></div>

<div class="form-card">
    <form method="POST" action="{{ route('admin.vehicles.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-grid">
            <div class="form-group">
                <label>Marque *</label>
                <input type="text" name="brand" value="{{ old('brand') }}" placeholder="Toyota, Honda...">
                @error('brand')<div class="err">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Modèle *</label>
                <input type="text" name="model" value="{{ old('model') }}" placeholder="Corolla, CB500...">
                @error('model')<div class="err">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Type *</label>
                <select name="type">
                    <option value="">-- Sélectionner --</option>
                    <option value="car" {{ old('type')=='car'?'selected':'' }}>Voiture</option>
                    <option value="motorcycle" {{ old('type')=='motorcycle'?'selected':'' }}>Moto</option>
                </select>
                @error('type')<div class="err">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Année *</label>
                <input type="number" name="year" value="{{ old('year',date('Y')) }}" min="1990" max="{{ date('Y') }}">
                @error('year')<div class="err">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Plaque d'immatriculation *</label>
                <input type="text" name="plate" value="{{ old('plate') }}" placeholder="LT-1234-A">
                @error('plate')<div class="err">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Prix par jour (FCFA) *</label>
                <input type="number" name="price_per_day" value="{{ old('price_per_day') }}" placeholder="15000" min="1">
                @error('price_per_day')<div class="err">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Kilométrage *</label>
                <input type="number" name="mileage" value="{{ old('mileage',0) }}" min="0">
                @error('mileage')<div class="err">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label>Statut *</label>
                <select name="status">
                    <option value="available" {{ old('status','available')=='available'?'selected':'' }}>Disponible</option>
                    <option value="rented" {{ old('status')=='rented'?'selected':'' }}>En location</option>
                    <option value="maintenance" {{ old('status')=='maintenance'?'selected':'' }}>Maintenance</option>
                </select>
            </div>
            <div class="form-group full">
                <label>Photo du véhicule</label>
                <div class="upload-zone" id="uploadZone">
                    <input type="file" name="image" accept="image/*" onchange="previewImage(event)">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <p>Cliquez ou glissez une image ici</p>
                    <span>JPG, PNG, WEBP — max 2MB</span>
                </div>
                <img id="previewImg" class="preview-img" src="" alt="Aperçu">
                @error('image')<div class="err">{{ $message }}</div>@enderror
            </div>
            <div class="form-group full">
                <label>Description</label>
                <textarea name="description" rows="3" placeholder="Informations supplémentaires...">{{ old('description') }}</textarea>
            </div>
        </div>
        <div style="margin-top:24px;display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
            <a href="{{ route('admin.vehicles.index') }}" class="btn-cancel">Annuler</a>
            <button type="submit" class="btn-submit">Enregistrer le véhicule</button>
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
        document.querySelector('.upload-zone svg').style.display = 'none';
        document.querySelector('.upload-zone p').textContent = file.name;
    };
    reader.readAsDataURL(file);
}
</script>
@endsection