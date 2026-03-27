<div class="form-group full">
    <label>Photo du véhicule</label>

    {{-- Tabs upload / URL --}}
    <div style="display:flex;gap:0;margin-bottom:12px;border:1px solid #2a2d3a;border-radius:8px;overflow:hidden;">
        <button type="button" onclick="switchTab('upload')" id="tab-upload"
            style="flex:1;padding:9px;background:#f59e0b;color:#0f1117;border:none;cursor:pointer;font-size:12px;font-weight:700;font-family:'DM Sans',sans-serif;transition:.2s;">
            📁 Upload fichier
        </button>
        <button type="button" onclick="switchTab('url')" id="tab-url"
            style="flex:1;padding:9px;background:#0f1117;color:#9496a8;border:none;cursor:pointer;font-size:12px;font-family:'DM Sans',sans-serif;transition:.2s;">
            🔗 URL externe
        </button>
    </div>

    {{-- Upload --}}
    <div id="panel-upload">
        <div class="upload-zone" id="uploadZone">
            <input type="file" name="image" accept="image/*" onchange="previewImage(event)">
            <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="#555870" style="margin:0 auto 8px;display:block;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p style="font-size:13px;color:#555870;" id="uploadText">Cliquez ou glissez une image</p>
            <span style="font-size:11px;color:#3a3d50;">JPG, PNG, WEBP — max 3MB</span>
        </div>
        <img id="previewImg" style="width:100%;max-height:200px;object-fit:cover;border-radius:8px;margin-top:10px;display:none;border:1px solid #2a2d3a;" alt="Aperçu">
    </div>

    {{-- URL externe --}}
    <div id="panel-url" style="display:none;">
        <input type="url" name="image_url" id="imageUrlInput"
               placeholder="https://example.com/image.jpg"
               oninput="previewUrl(this.value)"
               style="width:100%;padding:11px 14px;background:#0f1117;border:1px solid #2a2d3a;border-radius:8px;color:#e8e9f0;font-size:14px;font-family:'DM Sans',sans-serif;outline:none;">
        <img id="urlPreviewImg" style="width:100%;max-height:200px;object-fit:cover;border-radius:8px;margin-top:10px;display:none;border:1px solid #2a2d3a;" alt="Aperçu URL">
        <p style="font-size:11px;color:#555870;margin-top:6px;">Collez un lien direct vers une image (Google Photos, Imgur, etc.)</p>
    </div>

    @error('image')<div class="err">{{ $message }}</div>@enderror
    @error('image_url')<div class="err">{{ $message }}</div>@enderror
</div>
<script>
function switchTab(tab) {
    const isUpload = tab === 'upload';
    document.getElementById('panel-upload').style.display = isUpload ? 'block' : 'none';
    document.getElementById('panel-url').style.display    = isUpload ? 'none' : 'block';
    document.getElementById('tab-upload').style.background = isUpload ? '#f59e0b' : '#0f1117';
    document.getElementById('tab-upload').style.color      = isUpload ? '#0f1117' : '#9496a8';
    document.getElementById('tab-url').style.background    = isUpload ? '#0f1117' : '#f59e0b';
    document.getElementById('tab-url').style.color         = isUpload ? '#9496a8' : '#0f1117';

    // Vide l'autre champ
    if (isUpload) document.querySelector('[name=image_url]') && (document.querySelector('[name=image_url]').value = '');
    else { const fi = document.querySelector('[name=image]'); if(fi) fi.value = ''; }
}

function previewImage(event) {
    const file = event.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        const img = document.getElementById('previewImg');
        img.src = e.target.result;
        img.style.display = 'block';
        document.getElementById('uploadText').textContent = file.name;
    };
    reader.readAsDataURL(file);
}

function previewUrl(url) {
    const img = document.getElementById('urlPreviewImg');
    if (url.startsWith('http')) {
        img.src = url;
        img.style.display = 'block';
        img.onerror = () => { img.style.display = 'none'; };
    } else {
        img.style.display = 'none';
    }
}
</script>