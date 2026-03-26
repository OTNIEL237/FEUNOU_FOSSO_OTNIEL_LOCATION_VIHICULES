<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>AutoLoc — Inscription</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box;}
body{font-family:'DM Sans',sans-serif;background:#0f1117;color:#e8e9f0;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:16px;}
.card{background:#161820;border:1px solid #2a2d3a;border-radius:16px;padding:40px 36px;width:100%;max-width:500px;}
.logo{font-family:'Syne',sans-serif;font-size:26px;font-weight:800;color:#fff;letter-spacing:-1px;margin-bottom:24px;}
.logo em{color:#f59e0b;font-style:normal;}
h2{font-family:'Syne',sans-serif;font-size:22px;font-weight:700;color:#fff;margin-bottom:4px;}
.sub{color:#9496a8;font-size:13px;margin-bottom:24px;}
label{font-size:12px;color:#9496a8;display:block;margin-bottom:5px;font-weight:500;}
input{width:100%;padding:11px 14px;background:#0f1117;border:1px solid #2a2d3a;border-radius:8px;color:#e8e9f0;font-size:14px;font-family:'DM Sans',sans-serif;outline:none;transition:.2s;}
input:focus{border-color:#f59e0b;}
.field{margin-bottom:14px;}
.grid2{display:grid;grid-template-columns:1fr 1fr;gap:12px;}
.btn{width:100%;padding:13px;background:#f59e0b;color:#0f1117;font-size:14px;font-weight:700;font-family:'Syne',sans-serif;border:none;border-radius:8px;cursor:pointer;transition:.2s;margin-top:6px;}
.btn:hover{background:#e08d00;}
.link{text-align:center;margin-top:18px;font-size:13px;color:#555870;}
.link a{color:#f59e0b;text-decoration:none;}
.err{font-size:11px;color:#f87171;margin-top:4px;}

/* RESPONSIVE */
@media(max-width:500px){
    .card{padding:28px 20px;}
    .grid2{grid-template-columns:1fr;}
}
</style>
</head>
<body>
<div class="card">
    <div class="logo">Auto<em>Loc</em></div>
    <h2>Créer un compte</h2>
    <p class="sub">Rejoignez-nous et commencez à louer</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="field">
            <label>Nom complet</label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Jean Dupont" required>
            @error('name')<div class="err">{{ $message }}</div>@enderror
        </div>
        <div class="field">
            <label>Adresse email</label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="vous@example.com" required>
            @error('email')<div class="err">{{ $message }}</div>@enderror
        </div>
        <div class="grid2">
            <div class="field">
                <label>Téléphone</label>
                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="6XX XXX XXX">
            </div>
            <div class="field">
                <label>N° CNI</label>
                <input type="text" name="cin" value="{{ old('cin') }}" placeholder="123456789">
            </div>
        </div>
        <div class="field">
            <label>N° Permis de conduire</label>
            <input type="text" name="driving_license" value="{{ old('driving_license') }}" placeholder="CM-2024-XXXXX">
        </div>
        <div class="grid2">
            <div class="field">
                <label>Mot de passe</label>
                <input type="password" name="password" placeholder="••••••••" required>
                @error('password')<div class="err">{{ $message }}</div>@enderror
            </div>
            <div class="field">
                <label>Confirmer</label>
                <input type="password" name="password_confirmation" placeholder="••••••••" required>
            </div>
        </div>
        <button class="btn" type="submit">Créer mon compte</button>
    </form>
    <div class="link">Déjà un compte ? <a href="{{ route('login') }}">Se connecter</a></div>
</div>
</body>
</html>