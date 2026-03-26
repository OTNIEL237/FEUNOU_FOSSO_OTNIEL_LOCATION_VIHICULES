<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>AutoLoc — Connexion</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box;}
body{font-family:'DM Sans',sans-serif;background:#0f1117;color:#e8e9f0;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:16px;}
.wrap{display:flex;width:100%;max-width:900px;border-radius:16px;overflow:hidden;border:1px solid #2a2d3a;}
.left{flex:1;background:#161820;padding:48px 40px;display:flex;flex-direction:column;justify-content:center;}
.right{width:420px;background:#0f1117;border-left:1px solid #2a2d3a;padding:48px 40px;display:flex;flex-direction:column;justify-content:center;}
.logo{font-family:'Syne',sans-serif;font-size:36px;font-weight:800;color:#fff;letter-spacing:-1px;margin-bottom:12px;}
.logo em{color:#f59e0b;font-style:normal;}
.tagline{color:#555870;font-size:14px;line-height:1.7;max-width:280px;margin-bottom:36px;}
.car-card{background:#0f1117;border:1px solid #2a2d3a;border-radius:10px;padding:14px 18px;margin-bottom:10px;}
.car-name{font-size:13px;font-weight:500;color:#e8e9f0;}
.car-price{font-size:22px;font-weight:700;font-family:'Syne',sans-serif;color:#f59e0b;margin:4px 0;}
.car-badge{font-size:10px;background:#0d2e1a;color:#4ade80;padding:2px 8px;border-radius:20px;}
h2{font-family:'Syne',sans-serif;font-size:24px;font-weight:700;color:#fff;margin-bottom:6px;}
.sub{color:#9496a8;font-size:13px;margin-bottom:28px;}
label{font-size:12px;color:#9496a8;display:block;margin-bottom:5px;font-weight:500;}
input{width:100%;padding:11px 14px;background:#161820;border:1px solid #2a2d3a;border-radius:8px;color:#e8e9f0;font-size:14px;font-family:'DM Sans',sans-serif;outline:none;transition:.2s;}
input:focus{border-color:#f59e0b;}
.field{margin-bottom:16px;}
.btn{width:100%;padding:13px;background:#f59e0b;color:#0f1117;font-size:14px;font-weight:700;font-family:'Syne',sans-serif;border:none;border-radius:8px;cursor:pointer;transition:.2s;margin-top:4px;}
.btn:hover{background:#e08d00;}
.link{text-align:center;margin-top:18px;font-size:13px;color:#555870;}
.link a{color:#f59e0b;text-decoration:none;}
.error{background:#2e0d0d;border:1px solid #7f1d1d;color:#f87171;padding:10px 14px;border-radius:8px;font-size:12px;margin-bottom:16px;}

/* RESPONSIVE */
@media(max-width:700px){
    .wrap{flex-direction:column;border-radius:12px;}
    .left{padding:32px 24px;display:none;} /* cache le panneau gauche sur mobile */
    .right{width:100%;border-left:none;padding:36px 24px;}
    .logo-mobile{display:block !important;}
}
.logo-mobile{display:none;font-family:'Syne',sans-serif;font-size:28px;font-weight:800;color:#fff;letter-spacing:-1px;margin-bottom:24px;}
.logo-mobile em{color:#f59e0b;font-style:normal;}
</style>
</head>
<body>
<div class="wrap">
    <div class="left">
        <div class="logo">Auto<em>Loc</em></div>
        <p class="tagline">Le système de location de véhicules simple, rapide et fiable au Cameroun.</p>
        <div class="car-card">
            <div class="car-name">Toyota Corolla</div>
            <div class="car-price">15 000 F/jour</div>
            <div class="car-badge">disponible</div>
        </div>
        <div class="car-card">
            <div class="car-name">Honda CB500</div>
            <div class="car-price">10 000 F/jour</div>
            <div class="car-badge">disponible</div>
        </div>
    </div>
    <div class="right">
        <div class="logo-mobile">Auto<em>Loc</em></div>
        <h2>Connexion</h2>
        <p class="sub">Accédez à votre espace</p>

        @if($errors->any())
            <div class="error">Email ou mot de passe incorrect.</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="field">
                <label>Adresse email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="vous@example.com" required>
            </div>
            <div class="field">
                <label>Mot de passe</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>
            <button class="btn" type="submit">Se connecter</button>
        </form>
        <div class="link">Pas encore de compte ? <a href="{{ route('register') }}">S'inscrire</a></div>
    </div>
</div>
</body>
</html>