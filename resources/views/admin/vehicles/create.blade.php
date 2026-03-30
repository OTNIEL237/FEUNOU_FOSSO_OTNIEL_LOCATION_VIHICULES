@extends('layouts.app')
@section('title','Ajouter un véhicule')
@section('content')
<style>
.back-link{display:inline-flex;align-items:center;gap:6px;color:#9496a8;font-size:13px;text-decoration:none;margin-bottom:24px;padding:8px 14px;background:#161820;border:1px solid #2a2d3a;border-radius:8px;transition:.2s;}
.back-link:hover{color:#f59e0b;border-color:#f59e0b;}
.form-card{background:#161820;border:1px solid #2a2d3a;border-radius:14px;padding:32px;max-width:720px;}
.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
.form-group{display:flex;flex-direction:column;gap:6px;}
.form-group.full{grid-column:span 2;}
.form-group label{font-size:12px;color:#9496a8;font-weight:500;text-transform:uppercase;letter-spacing:.6px;}
.form-group input,.form-group select,.form-group textarea{width:100%;padding:11px 14px;background:#0f1117;border:1px solid #2a2d3a;border-radius:8px;color:#e8e9f0;font-size:14px;font-family:'DM Sans',sans-serif;outline:none;transition:.2s;-webkit-appearance:none;appearance:none;}
.form-group select{background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239496a8' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 14px center;padding-right:36px;}
.form-group input:focus,.form-group select:focus,.form-group textarea:focus{border-color:#f59e0b;box-shadow:0 0 0 3px rgba(245,158,11,.1);}
.form-group textarea{resize:vertical;min-height:80px;}
.err{font-size:11px;color:#f87171;}

/* Tabs image */
.img-tabs{display:flex;border:1px solid #2a2d3a;border-radius:8px;overflow:hidden;margin-bottom:12px;}
.img-tab{flex:1;padding:10px;text-align:center;font-size:13px;font-family:'DM Sans',sans-serif;font-weight:600;cursor:pointer;border:none;transition:.2s;}
.img-tab.active{background:#f59e0b;color:#0f1117;}
.img-tab.inactive{background:#0f1117;color:#555870;}
.img-tab.inactive:hover{color:#9496a8;}

/* Upload zone */
.upload-zone{border:2px dashed #2a2d3a;border-radius:10px;padding:28px;text-align:center;cursor:pointer;transition:.2s;background:#0f1117;position:relative;overflow:hidden;}
.upload-zone:hover{border-color:#f59e0b;}
.upload-zone input[type=file]{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%;}
.upload-zone-icon{width:40px;height:40px;margin:0 auto 10px;display:flex;align-items:center;justify-content:center;background:#1e2130;border-radius:10px;}
.upload-zone-icon svg{width:20px;height:20px;color:#9496a8;}
.upload-zone p{font-size:13px;color:#9496a8;margin-bottom:4px;}
.upload-zone span{font-size:11px;color:#3a3d50;}
.preview-img{width:100%;max-height:200px;object-fit:cover;border-radius:8px;margin-top:12px;display:none;border:1px solid #2a2d3a;}

/* Buttons */
.btn-submit{background:#f59e0b;color:#0f1117;padding:12px 28px;border-radius:8px;font-size:14px;font-weight:700;font-family:'Syne',sans-serif;border:none;cursor:pointer;transition:.2s;}
.btn-submit:hover{background:#e08d00;}
.btn-cancel{padding:12px 20px;background:transparent;border:1px solid #2a2d3a;border-radius:8px;color:#9496a8;font-size:14px;text-decoration:none;transition:.2s;}
.btn-cancel:hover{color:#fff;border-color:#555870;}

@media(max-width:600px){
    .form-grid{grid-template-columns:1fr;}
    .form-group.full{grid-column:span 1;}
    .form-card{padding:20px 16px;}
}
</style>

<a href="{{ route('admin.vehicles.index') }}" class="back-link">← Retour aux véhicules</a>

<div class="page-header">
    <h1>Ajouter un véhicule</h1>
    <p>Remplissez les informations du nouveau véhicule</p>
</div>

<div class="form-card">
    <form method="POST" action="{{ route('admin.vehicles.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-grid">

            <div class="form-group">
                <label>Marque *</label>
                <input type="text" name="brand" value="{{ old('brand') }}" placeholder="Toyota, Honda, BMW...">
                @error('brand')<span class="err">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label>Modèle *</label>
                <input type="text" name="model" value="{{ old('model') }}" placeholder="Corolla, CB500...">
                @error('model')<span class="err">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label>Type *</label>
                <select name="type">
                    <option value="">-- Sélectionner --</option>
                    <option value="car" {{ old('type')=='car'?'selected':'' }}>🚗 Voiture</option>
                    <option value="motorcycle" {{ old('type')=='motorcycle'?'selected':'' }}>🏍️ Moto</option>
                </select>
                @error('type')<span class="err">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label>Année *</label>
                <input type="number" name="year" value="{{ old('year', date('Y')) }}"
                       min="1990" max="{{ date('Y') }}" placeholder="{{ date('Y') }}">
                @error('year')<span class="err">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label>Plaque d'immatriculation *</label>
                <input type="text" name="plate" value="{{ old('plate') }}" placeholder="LT-1234-A">
                @error('plate')<span class="err">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label>Prix par jour (FCFA) *</label>
                <input type="number" name="price_per_day" value="{{ old('price_per_day') }}"
                       placeholder="15000" min="1">
                @error('price_per_day')<span class="err">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label>Kilométrage *</label>
                <input type="number" name="mileage" value="{{ old('mileage', 0) }}" min="0">
                @error('mileage')<span class="err">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label>Statut *</label>
                <select name="status">
                    <option value="available" {{ old('status','available')=='available'?'selected':'' }}>✅ Disponible</option>
                    <option value="rented" {{ old('status')=='rented'?'selected':'' }}>🔒 En location</option>
                    <option value="maintenance" {{ old('status')=='maintenance'?'selected':'' }}>🔧 Maintenance</option>
                </select>
                @error('status')<span class="err">{{ $message }}</span>@enderror
            </div>

            {{-- Photo --}}
            <div class="form-group full">
                <label>Photo du véhicule</label>

                <div class="img-tabs">
                    <button type="button" class="img-tab active" id="tab-upload" onclick="switchTab('upload')">
                        📁 Upload fichier
                    </button>
                    <button type="button" class="img-tab inactive" id="tab-url" onclick="switchTab('url')">
                        🔗 URL externe
                    </button>
                </div>

                {{-- Panel Upload --}}
                <div id="panel-upload">
                    <div class="upload-zone" id="uploadZone">
                        <input type="file" name="image" accept="image/*" id="fileInput" onchange="previewFile(event)">
                        <div class="upload-zone-icon">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <p id="uploadText">Cliquez ou glissez une image ici</p>
                        <span>JPG, PNG, WEBP — max 3MB</span>
                    </div>
                    <img id="previewImg" class="preview-img" src="" alt="Aperçu">
                </div>

                {{-- Panel URL --}}
                <div id="panel-url" style="display:none;">
                    <input type="url" name="image_url" id="imageUrlInput"
                           placeholder="https://exemple.com/photo-voiture.jpg"
                           oninput="previewUrl(this.value)"
                           style="width:100%;padding:11px 14px;background:#0f1117;border:1px solid #2a2d3a;border-radius:8px;color:#e8e9f0;font-size:14px;font-family:'DM Sans',sans-serif;outline:none;transition:.2s;">
                    <p style="font-size:11px;color:#555870;margin-top:6px;">
                        Collez un lien direct vers une image (Imgur, Google Drive, etc.)
                    </p>
                    <img id="urlPreviewImg" class="preview-img" src="" alt="Aperçu URL">
                </div>

                @error('image')<span class="err">{{ $message }}</span>@enderror
                @error('image_url')<span class="err">{{ $message }}</span>@enderror
            </div>

            <div class="form-group full">
                <label>Description</label>
                <textarea name="description" placeholder="Informations supplémentaires sur le véhicule...">{{ old('description') }}</textarea>
            </div>

        </div>

        <div style="display:flex;align-items:center;gap:12px;margin-top:24px;flex-wrap:wrap;">
            <a href="{{ route('admin.vehicles.index') }}" class="btn-cancel">Annuler</a>
            <button type="submit" class="btn-submit">✓ Enregistrer le véhicule</button>
        </div>
    </form>
</div>

<script>
function switchTab(tab) {
    const isUpload = tab === 'upload';

    document.getElementById('panel-upload').style.display = isUpload ? 'block' : 'none';
    document.getElementById('panel-url').style.display    = isUpload ? 'none'  : 'block';

    document.getElementById('tab-upload').className = 'img-tab ' + (isUpload ? 'active' : 'inactive');
    document.getElementById('tab-url').className    = 'img-tab ' + (isUpload ? 'inactive' : 'active');

    // Vide l'autre champ
    if (isUpload) {
        const u = document.getElementById('imageUrlInput');
        if (u) u.value = '';
        document.getElementById('urlPreviewImg').style.display = 'none';
    } else {
        const f = document.getElementById('fileInput');
        if (f) f.value = '';
        document.getElementById('previewImg').style.display = 'none';
    }
}

function previewFile(event) {
    const file = event.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        const img = document.getElementById('previewImg');
        img.src = e.target.result;
        img.style.display = 'block';
        document.getElementById('uploadText').textContent = '✓ ' + file.name;
    };
    reader.readAsDataURL(file);
}

function previewUrl(url) {
    const img = document.getElementById('urlPreviewImg');
    if (url && url.startsWith('http')) {
        img.src = url;
        img.style.display = 'block';
        img.onerror = () => {
            img.style.display = 'none';
        };
    } else {
        img.style.display = 'none';
    }
}
</script>
@endsection