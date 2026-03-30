<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>AutoLoc — Location de Véhicules au Cameroun</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box;}
body{font-family:'DM Sans',sans-serif;background:#0f1117;color:#e8e9f0;overflow-x:hidden;}

/* ── NAVBAR ── */
.navbar{position:fixed;top:0;left:0;right:0;z-index:100;padding:0 5%;background:rgba(15,17,23,.95);border-bottom:1px solid #1e2130;backdrop-filter:blur(10px);}
.navbar-inner{display:flex;align-items:center;justify-content:space-between;height:64px;}
.nav-logo{font-family:'Syne',sans-serif;font-size:22px;font-weight:800;color:#fff;text-decoration:none;letter-spacing:-0.5px;}
.nav-logo em{color:#f59e0b;font-style:normal;}
.nav-links{display:flex;align-items:center;gap:32px;}
.nav-link{color:#9496a8;text-decoration:none;font-size:14px;font-weight:500;transition:.2s;}
.nav-link:hover{color:#fff;}
.nav-btns{display:flex;align-items:center;gap:10px;}
.btn-login{padding:8px 18px;border:1px solid #2a2d3a;border-radius:8px;color:#e8e9f0;text-decoration:none;font-size:14px;font-weight:500;transition:.2s;}
.btn-login:hover{border-color:#f59e0b;color:#f59e0b;}
.btn-signup{padding:8px 18px;background:#f59e0b;border-radius:8px;color:#0f1117;text-decoration:none;font-size:14px;font-weight:700;font-family:'Syne',sans-serif;transition:.2s;}
.btn-signup:hover{background:#e08d00;}
.hamburger{display:none;background:none;border:none;cursor:pointer;padding:4px;}
.hamburger svg{width:24px;height:24px;color:#e8e9f0;}
.mobile-menu{display:none;position:fixed;top:64px;left:0;right:0;background:#161820;border-bottom:1px solid #2a2d3a;padding:20px 5%;z-index:99;flex-direction:column;gap:16px;}
.mobile-menu.open{display:flex;}
.mobile-menu a{color:#9496a8;text-decoration:none;font-size:15px;padding:8px 0;border-bottom:1px solid #1e2130;}
.mobile-menu a:last-child{border-bottom:none;}

/* ── HERO ── */
.hero{min-height:100vh;padding:120px 5% 80px;display:flex;align-items:center;position:relative;overflow:hidden;}
.hero-bg{position:absolute;inset:0;background:radial-gradient(ellipse at 70% 50%, rgba(245,158,11,.08) 0%, transparent 60%),radial-gradient(ellipse at 10% 80%, rgba(96,165,250,.06) 0%, transparent 50%);pointer-events:none;}
.hero-content{max-width:600px;position:relative;z-index:1;}
.hero-badge{display:inline-flex;align-items:center;gap:8px;padding:6px 14px;background:#1e2130;border:1px solid #2a2d3a;border-radius:20px;font-size:12px;color:#9496a8;margin-bottom:24px;}
.hero-badge span{width:6px;height:6px;border-radius:50%;background:#4ade80;flex-shrink:0;}
.hero-title{font-family:'Syne',sans-serif;font-size:clamp(36px,6vw,64px);font-weight:800;color:#fff;line-height:1.1;margin-bottom:20px;letter-spacing:-1px;}
.hero-title em{color:#f59e0b;font-style:normal;}
.hero-subtitle{font-size:16px;color:#9496a8;line-height:1.7;margin-bottom:36px;max-width:480px;}
.hero-btns{display:flex;gap:12px;flex-wrap:wrap;}
.btn-primary{padding:14px 28px;background:#f59e0b;color:#0f1117;border-radius:10px;text-decoration:none;font-size:15px;font-weight:700;font-family:'Syne',sans-serif;transition:.2s;display:inline-flex;align-items:center;gap:8px;}
.btn-primary:hover{background:#e08d00;transform:translateY(-1px);}
.btn-secondary{padding:14px 28px;background:transparent;border:1px solid #2a2d3a;color:#e8e9f0;border-radius:10px;text-decoration:none;font-size:15px;font-weight:500;transition:.2s;}
.btn-secondary:hover{border-color:#f59e0b;color:#f59e0b;}
.hero-stats{display:flex;gap:32px;margin-top:48px;flex-wrap:wrap;}
.stat{border-left:2px solid #2a2d3a;padding-left:16px;}
.stat-num{font-family:'Syne',sans-serif;font-size:28px;font-weight:700;color:#fff;}
.stat-label{font-size:12px;color:#555870;margin-top:2px;}

/* ── SECTION ── */
.section{padding:80px 5%;}
.section-header{text-align:center;margin-bottom:48px;}
.section-tag{font-size:12px;color:#f59e0b;font-weight:600;text-transform:uppercase;letter-spacing:1.5px;margin-bottom:12px;}
.section-title{font-family:'Syne',sans-serif;font-size:clamp(24px,4vw,36px);font-weight:700;color:#fff;margin-bottom:12px;}
.section-sub{font-size:15px;color:#9496a8;max-width:500px;margin:0 auto;line-height:1.7;}

/* ── VÉHICULES ── */
.vehicles-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:20px;}
@media(max-width:1100px){.vehicles-grid{grid-template-columns:repeat(3,1fr);}}
@media(max-width:750px){.vehicles-grid{grid-template-columns:repeat(2,1fr);}}
@media(max-width:460px){.vehicles-grid{grid-template-columns:1fr;}}

.vehicle-card{background:#161820;border:1px solid #2a2d3a;border-radius:14px;overflow:hidden;transition:all .25s;cursor:pointer;}
.vehicle-card:hover{border-color:#f59e0b;transform:translateY(-4px);box-shadow:0 12px 40px rgba(245,158,11,.1);}
.vehicle-img{height:160px;background:#0f1117;position:relative;overflow:hidden;}
.vehicle-img img{width:100%;height:100%;object-fit:cover;transition:.3s;}
.vehicle-card:hover .vehicle-img img{transform:scale(1.05);}
.vehicle-img-placeholder{height:100%;display:flex;align-items:center;justify-content:center;}
.vehicle-img-placeholder svg{width:56px;height:56px;opacity:.15;}
.badge{position:absolute;font-size:10px;padding:4px 10px;border-radius:20px;font-weight:700;letter-spacing:.3px;}
.badge-type{top:10px;left:10px;}
.badge-car{background:rgba(7,30,56,.9);color:#60a5fa;border:1px solid rgba(96,165,250,.3);}
.badge-moto{background:rgba(46,31,5,.9);color:#fbbf24;border:1px solid rgba(251,191,36,.3);}
.badge-status{top:10px;right:10px;}
.badge-available{background:rgba(13,46,26,.9);color:#4ade80;border:1px solid rgba(74,222,128,.3);}
.badge-rented{background:rgba(46,13,13,.9);color:#f87171;border:1px solid rgba(248,113,113,.3);}

.vehicle-body{padding:14px 16px;}
.vehicle-name{font-family:'Syne',sans-serif;font-size:14px;font-weight:700;color:#fff;margin-bottom:2px;}
.vehicle-plate{font-size:11px;color:#555870;margin-bottom:8px;}
.vehicle-avail{font-size:11px;background:#2e1f05;color:#fbbf24;padding:3px 8px;border-radius:20px;display:inline-block;margin-bottom:8px;}
.vehicle-footer{display:flex;justify-content:space-between;align-items:center;}
.vehicle-price{font-family:'Syne',sans-serif;font-size:16px;font-weight:700;color:#f59e0b;}
.vehicle-price span{font-size:10px;color:#555870;font-family:'DM Sans',sans-serif;font-weight:400;}
.btn-rent{padding:6px 14px;border-radius:6px;font-size:11px;font-weight:700;text-decoration:none;font-family:'Syne',sans-serif;transition:.2s;border:none;cursor:pointer;}
.btn-rent-avail{background:#f59e0b;color:#0f1117;}
.btn-rent-avail:hover{background:#e08d00;}
.btn-rent-resa{background:#1e2130;color:#9496a8;border:1px solid #2a2d3a;}
.btn-rent-resa:hover{color:#fff;}

/* ── HOW IT WORKS ── */
.steps-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:20px;}
@media(max-width:800px){.steps-grid{grid-template-columns:repeat(2,1fr);}}
@media(max-width:480px){.steps-grid{grid-template-columns:1fr;}}
.step-card{background:#161820;border:1px solid #2a2d3a;border-radius:14px;padding:24px;text-align:center;transition:.2s;}
.step-card:hover{border-color:#f59e0b;}
.step-num{width:44px;height:44px;border-radius:12px;background:#f59e0b;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-family:'Syne',sans-serif;font-size:18px;font-weight:800;color:#0f1117;}
.step-title{font-family:'Syne',sans-serif;font-size:15px;font-weight:700;color:#fff;margin-bottom:8px;}
.step-text{font-size:13px;color:#9496a8;line-height:1.6;}

/* ── AVANTAGES ── */
.features-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;}
@media(max-width:750px){.features-grid{grid-template-columns:1fr 1fr;}}
@media(max-width:480px){.features-grid{grid-template-columns:1fr;}}
.feature-card{background:#161820;border:1px solid #2a2d3a;border-radius:14px;padding:24px;transition:.2s;}
.feature-card:hover{border-color:#2a2d4a;}
.feature-icon{width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;margin-bottom:16px;}
.feature-icon svg{width:22px;height:22px;}
.feature-title{font-family:'Syne',sans-serif;font-size:15px;font-weight:700;color:#fff;margin-bottom:8px;}
.feature-text{font-size:13px;color:#9496a8;line-height:1.6;}

/* ── CTA ── */
.cta-section{padding:80px 5%;text-align:center;}
.cta-card{background:linear-gradient(135deg,#1a1505 0%,#161820 50%,#071020 100%);border:1px solid #2a2d3a;border-radius:20px;padding:60px 40px;position:relative;overflow:hidden;}
.cta-card::before{content:'';position:absolute;top:-50%;right:-10%;width:400px;height:400px;background:radial-gradient(circle,rgba(245,158,11,.08) 0%,transparent 70%);pointer-events:none;}
.cta-title{font-family:'Syne',sans-serif;font-size:clamp(24px,4vw,40px);font-weight:800;color:#fff;margin-bottom:16px;}
.cta-sub{font-size:15px;color:#9496a8;margin-bottom:32px;max-width:480px;margin-left:auto;margin-right:auto;line-height:1.7;}

/* ── ABOUT ── */
.about-grid{display:grid;grid-template-columns:1fr 1fr;gap:48px;align-items:center;}
@media(max-width:750px){.about-grid{grid-template-columns:1fr;}}
.about-img{background:#161820;border:1px solid #2a2d3a;border-radius:16px;height:340px;display:flex;align-items:center;justify-content:center;position:relative;overflow:hidden;}
.about-img-inner{text-align:center;}
.about-img-icon{font-size:64px;margin-bottom:16px;}
.about-text{font-size:14px;color:#555870;}
.about-content{}
.about-title{font-family:'Syne',sans-serif;font-size:clamp(22px,3vw,32px);font-weight:700;color:#fff;margin-bottom:16px;line-height:1.2;}
.about-desc{font-size:15px;color:#9496a8;line-height:1.8;margin-bottom:24px;}
.about-points{display:flex;flex-direction:column;gap:12px;}
.about-point{display:flex;align-items:center;gap:10px;font-size:14px;color:#9496a8;}
.about-point svg{width:16px;height:16px;color:#f59e0b;flex-shrink:0;}

/* ── CONTACT ── */
.contact-grid{display:grid;grid-template-columns:1fr 1fr;gap:32px;}
@media(max-width:700px){.contact-grid{grid-template-columns:1fr;}}
.contact-info{display:flex;flex-direction:column;gap:20px;}
.contact-item{display:flex;align-items:flex-start;gap:14px;background:#161820;border:1px solid #2a2d3a;border-radius:12px;padding:16px 20px;}
.contact-item-icon{width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.contact-item-icon svg{width:18px;height:18px;}
.contact-item-label{font-size:11px;color:#555870;text-transform:uppercase;letter-spacing:.8px;margin-bottom:4px;}
.contact-item-value{font-size:14px;color:#e8e9f0;font-weight:500;}
.contact-form{background:#161820;border:1px solid #2a2d3a;border-radius:14px;padding:28px;}
.contact-form h3{font-family:'Syne',sans-serif;font-size:18px;font-weight:700;color:#fff;margin-bottom:20px;}
.cf-group{margin-bottom:16px;}
.cf-group label{font-size:12px;color:#9496a8;display:block;margin-bottom:6px;font-weight:500;}
.cf-group input,.cf-group textarea,.cf-group select{width:100%;padding:10px 14px;background:#0f1117;border:1px solid #2a2d3a;border-radius:8px;color:#e8e9f0;font-size:14px;font-family:'DM Sans',sans-serif;outline:none;transition:.2s;}
.cf-group input:focus,.cf-group textarea:focus{border-color:#f59e0b;}
.cf-group textarea{min-height:100px;resize:vertical;}
.btn-send{width:100%;padding:12px;background:#f59e0b;color:#0f1117;font-size:14px;font-weight:700;font-family:'Syne',sans-serif;border:none;border-radius:8px;cursor:pointer;transition:.2s;}
.btn-send:hover{background:#e08d00;}

/* ── FOOTER ── */
.footer{background:#161820;border-top:1px solid #2a2d3a;padding:40px 5% 24px;}
.footer-top{display:grid;grid-template-columns:2fr 1fr 1fr;gap:40px;margin-bottom:32px;}
@media(max-width:700px){.footer-top{grid-template-columns:1fr;gap:24px;}}
.footer-logo{font-family:'Syne',sans-serif;font-size:20px;font-weight:800;color:#fff;margin-bottom:12px;}
.footer-logo em{color:#f59e0b;font-style:normal;}
.footer-desc{font-size:13px;color:#555870;line-height:1.7;}
.footer-col-title{font-size:12px;color:#fff;font-weight:600;text-transform:uppercase;letter-spacing:.8px;margin-bottom:14px;}
.footer-links{display:flex;flex-direction:column;gap:8px;}
.footer-link{font-size:13px;color:#555870;text-decoration:none;transition:.2s;}
.footer-link:hover{color:#f59e0b;}
.footer-bottom{border-top:1px solid #1e2130;padding-top:20px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;}
.footer-copy{font-size:12px;color:#555870;}
.footer-made{font-size:12px;color:#555870;}
.footer-made span{color:#f59e0b;}

/* ── SCROLL ANIMATIONS ── */
.fade-up{opacity:0;transform:translateY(30px);transition:opacity .6s ease,transform .6s ease;}
.fade-up.visible{opacity:1;transform:translateY(0);}

/* ── RESPONSIVE NAVBAR ── */
@media(max-width:768px){
    .nav-links{display:none;}
    .nav-btns{display:none;}
    .hamburger{display:block;}
    .hero{padding:100px 5% 60px;}
    .section{padding:60px 5%;}
    .cta-card{padding:40px 20px;}
}
</style>
</head>
<body>

{{-- ── NAVBAR ── --}}
<nav class="navbar">
    <div class="navbar-inner">
        <a href="{{ route('home') }}" class="nav-logo">Auto<em>Loc</em></a>
        <div class="nav-links">
            <a href="#vehicules" class="nav-link">Véhicules</a>
            <a href="#comment" class="nav-link">Comment ça marche</a>
            <a href="#apropos" class="nav-link">À propos</a>
            <a href="#contact" class="nav-link">Contact</a>
        </div>
        <div class="nav-btns">
            @auth
                <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('client.dashboard') }}"
                   class="btn-login">Mon espace</a>
            @else
                <a href="{{ route('login') }}" class="btn-login">Connexion</a>
                <a href="{{ route('register') }}" class="btn-signup">S'inscrire</a>
            @endauth
        </div>
        <button class="hamburger" onclick="toggleMenu()">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>
</nav>

{{-- Mobile menu --}}
<div class="mobile-menu" id="mobileMenu">
    <a href="#vehicules" onclick="toggleMenu()">Véhicules</a>
    <a href="#comment" onclick="toggleMenu()">Comment ça marche</a>
    <a href="#apropos" onclick="toggleMenu()">À propos</a>
    <a href="#contact" onclick="toggleMenu()">Contact</a>
    @auth
        <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('client.dashboard') }}">Mon espace →</a>
    @else
        <a href="{{ route('login') }}">Connexion</a>
        <a href="{{ route('register') }}" style="color:#f59e0b;font-weight:600;">S'inscrire gratuitement →</a>
    @endauth
</div>

{{-- ── HERO ── --}}
<section class="hero">
    <div class="hero-bg"></div>
    <div class="hero-content">
        <div class="hero-badge">
            <span></span>
            {{ $stats['available'] }} véhicules disponibles maintenant
        </div>
        <h1 class="hero-title">
            Louez votre<br>véhicule<br><em>en toute simplicité</em>
        </h1>
        <p class="hero-subtitle">
            Voitures et motos disponibles à la location avec gestion des contrats,
            paiements sécurisés et disponibilité en temps réel.
        </p>
        <div class="hero-btns">
            <a href="#vehicules" class="btn-primary">
                Voir les véhicules
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
            <a href="#comment" class="btn-secondary">Comment ça marche</a>
        </div>
        <div class="hero-stats">
            <div class="stat">
                <div class="stat-num">{{ $stats['total_vehicles'] }}+</div>
                <div class="stat-label">Véhicules</div>
            </div>
            <div class="stat">
                <div class="stat-num">{{ $stats['available'] }}</div>
                <div class="stat-label">Disponibles</div>
            </div>
            <div class="stat">
                <div class="stat-num">{{ $stats['cities'] }}</div>
                <div class="stat-label">Villes</div>
            </div>
        </div>
    </div>
</section>

{{-- ── VÉHICULES ── --}}
<section class="section" id="vehicules">
    <div class="section-header fade-up">
        <div class="section-tag">Notre flotte</div>
        <h2 class="section-title">Véhicules disponibles</h2>
        <p class="section-sub">Choisissez parmi notre sélection de voitures et motos — réservez en quelques clics.</p>
    </div>

    <div class="vehicles-grid">
        @forelse($vehicles as $vehicle)
        <div class="vehicle-card fade-up">
            <div class="vehicle-img">
                @if($vehicle->image_url)
                    <img src="{{ $vehicle->image_url }}"
                         alt="{{ $vehicle->brand }} {{ $vehicle->model }}"
                         onerror="this.style.display='none'">
                @else
                    <div class="vehicle-img-placeholder">
                        <svg fill="none" viewBox="0 0 24 24" stroke="#3a3d50">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                @endif
                <span class="badge badge-type {{ $vehicle->type === 'car' ? 'badge-car' : 'badge-moto' }}">
                    {{ $vehicle->type === 'car' ? 'Voiture' : 'Moto' }}
                </span>
                <span class="badge badge-status {{ $vehicle->status === 'available' ? 'badge-available' : 'badge-rented' }}">
                    {{ $vehicle->status === 'available' ? 'Disponible' : 'Loué' }}
                </span>
            </div>
            <div class="vehicle-body">
                <div class="vehicle-name">{{ $vehicle->brand }} {{ $vehicle->model }}</div>
                <div class="vehicle-plate">{{ $vehicle->plate }} · {{ $vehicle->year }}</div>
                @if($vehicle->status === 'rented' && $vehicle->next_available_date)
                    <div class="vehicle-avail">Disponible le {{ $vehicle->next_available_date }}</div>
                @endif
                <div class="vehicle-footer">
                    <div class="vehicle-price">
                        {{ number_format($vehicle->price_per_day,0,',',' ') }} F
                        <span>/jour</span>
                    </div>
                    @auth
                        <a href="{{ route('client.vehicles.show', $vehicle) }}"
                           class="btn-rent {{ $vehicle->status === 'available' ? 'btn-rent-avail' : 'btn-rent-resa' }}">
                            {{ $vehicle->status === 'available' ? 'Louer' : 'Réserver' }}
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="btn-rent btn-rent-avail">
                            {{ $vehicle->status === 'available' ? 'Louer' : 'Réserver' }}
                        </a>
                    @endauth
                </div>
            </div>
        </div>
        @empty
        <div style="grid-column:1/-1;text-align:center;padding:60px;color:#555870;">
            <p style="font-size:16px;">Aucun véhicule disponible pour le moment.</p>
        </div>
        @endforelse
    </div>

    @auth
    <div style="text-align:center;margin-top:32px;">
        <a href="{{ route('client.vehicles') }}" class="btn-secondary">Voir tous les véhicules →</a>
    </div>
    @else
    <div style="text-align:center;margin-top:32px;">
        <a href="{{ route('register') }}" class="btn-primary">
            Créer un compte pour louer →
        </a>
    </div>
    @endauth
</section>

{{-- ── COMMENT ÇA MARCHE ── --}}
<section class="section" id="comment" style="background:#0a0c12;">
    <div class="section-header fade-up">
        <div class="section-tag">Simple & Rapide</div>
        <h2 class="section-title">Comment ça marche ?</h2>
        <p class="section-sub">Louez un véhicule en 4 étapes simples depuis votre téléphone.</p>
    </div>
    <div class="steps-grid">
        <div class="step-card fade-up">
            <div class="step-num">1</div>
            <div class="step-title">Créez votre compte</div>
            <div class="step-text">Inscrivez-vous gratuitement en moins de 2 minutes avec votre email.</div>
        </div>
        <div class="step-card fade-up">
            <div class="step-num">2</div>
            <div class="step-title">Choisissez un véhicule</div>
            <div class="step-text">Parcourez notre catalogue de voitures et motos disponibles.</div>
        </div>
        <div class="step-card fade-up">
            <div class="step-num">3</div>
            <div class="step-title">Réservez en ligne</div>
            <div class="step-text">Sélectionnez vos dates et confirmez votre réservation instantanément.</div>
        </div>
        <div class="step-card fade-up">
            <div class="step-num">4</div>
            <div class="step-title">Payez et roulez</div>
            <div class="step-text">Payez via Mobile Money ou carte bancaire. Votre contrat est généré automatiquement.</div>
        </div>
    </div>
</section>

{{-- ── AVANTAGES ── --}}
<section class="section">
    <div class="section-header fade-up">
        <div class="section-tag">Pourquoi nous choisir</div>
        <h2 class="section-title">Des avantages uniques</h2>
    </div>
    <div class="features-grid">
        <div class="feature-card fade-up">
            <div class="feature-icon" style="background:#071e38;">
                <svg fill="none" viewBox="0 0 24 24" stroke="#60a5fa"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            </div>
            <div class="feature-title">Paiement sécurisé</div>
            <div class="feature-text">Paiement via NotchPay — Mobile Money MTN/Orange ou carte bancaire. Vos données sont protégées.</div>
        </div>
        <div class="feature-card fade-up">
            <div class="feature-icon" style="background:#0d2e1a;">
                <svg fill="none" viewBox="0 0 24 24" stroke="#4ade80"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <div class="feature-title">Contrat automatique</div>
            <div class="feature-text">Votre contrat de location est généré automatiquement dès confirmation de votre réservation.</div>
        </div>
        <div class="feature-card fade-up">
            <div class="feature-icon" style="background:#2e1f05;">
                <svg fill="none" viewBox="0 0 24 24" stroke="#fbbf24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div class="feature-title">Disponibilité temps réel</div>
            <div class="feature-text">Consultez la disponibilité des véhicules en temps réel et réservez à l'avance.</div>
        </div>
        <div class="feature-card fade-up">
            <div class="feature-icon" style="background:#1a1a2e;">
                <svg fill="none" viewBox="0 0 24 24" stroke="#a78bfa"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
            </div>
            <div class="feature-title">Support client</div>
            <div class="feature-text">Notre équipe est disponible pour vous accompagner à chaque étape de votre location.</div>
        </div>
        <div class="feature-card fade-up">
            <div class="feature-icon" style="background:#2e0d0d;">
                <svg fill="none" viewBox="0 0 24 24" stroke="#f87171"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <div class="feature-title">Prix transparents</div>
            <div class="feature-text">Pas de frais cachés. Le prix affiché est le prix que vous payez, caution comprise.</div>
        </div>
        <div class="feature-card fade-up">
            <div class="feature-icon" style="background:#0f1117;border:1px solid #2a2d3a;">
                <svg fill="none" viewBox="0 0 24 24" stroke="#9496a8"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
            </div>
            <div class="feature-title">100% en ligne</div>
            <div class="feature-text">Gérez vos locations, contrats et paiements depuis votre téléphone ou ordinateur.</div>
        </div>
    </div>
</section>

{{-- ── À PROPOS ── --}}
<section class="section" id="apropos" style="background:#0a0c12;">
    <div class="about-grid">
        <div class="about-img fade-up">
            <div class="about-img-inner">
                <div class="about-img-icon">🚗</div>
                <div class="about-text">AutoLoc Cameroun</div>
                <div style="margin-top:20px;display:flex;gap:16px;justify-content:center;">
                    <div style="text-align:center;">
                        <div style="font-family:'Syne',sans-serif;font-size:24px;font-weight:700;color:#f59e0b;">{{ $stats['total_vehicles'] }}+</div>
                        <div style="font-size:11px;color:#555870;">Véhicules</div>
                    </div>
                    <div style="text-align:center;">
                        <div style="font-family:'Syne',sans-serif;font-size:24px;font-weight:700;color:#4ade80;">{{ $stats['available'] }}</div>
                        <div style="font-size:11px;color:#555870;">Disponibles</div>
                    </div>
                    <div style="text-align:center;">
                        <div style="font-family:'Syne',sans-serif;font-size:24px;font-weight:700;color:#60a5fa;">{{ $stats['cities'] }}</div>
                        <div style="font-size:11px;color:#555870;">Villes</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="about-content fade-up">
            <div class="section-tag">À propos d'AutoLoc</div>
            <h2 class="about-title">La référence de la location de véhicules au Cameroun</h2>
            <p class="about-desc">
                AutoLoc est une plateforme moderne de location de véhicules qui simplifie le processus
                de réservation, de paiement et de gestion des contrats. Notre mission est de vous offrir
                une expérience de location fluide, transparente et sécurisée.
            </p>
            <div class="about-points">
                <div class="about-point">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Véhicules régulièrement entretenus et vérifiés
                </div>
                <div class="about-point">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Contrats légaux générés automatiquement
                </div>
                <div class="about-point">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Paiements sécurisés via Mobile Money
                </div>
                <div class="about-point">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Disponible 24h/24 depuis votre téléphone
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── CTA ── --}}
<div class="cta-section">
    <div class="cta-card fade-up">
        <h2 class="cta-title">Prêt à prendre la route ?</h2>
        <p class="cta-sub">
            Rejoignez des centaines de clients qui font confiance à AutoLoc pour leurs besoins de mobilité.
        </p>
        @auth
        <a href="{{ route('client.vehicles') }}" class="btn-primary" style="display:inline-flex;">
            Voir les véhicules →
        </a>
        @else
        <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
            <a href="{{ route('register') }}" class="btn-primary">Créer mon compte gratuitement</a>
            <a href="{{ route('login') }}" class="btn-secondary">Se connecter</a>
        </div>
        @endauth
    </div>
</div>

{{-- ── CONTACT ── --}}
<section class="section" id="contact" style="background:#0a0c12;">
    <div class="section-header fade-up">
        <div class="section-tag">Nous contacter</div>
        <h2 class="section-title">Besoin d'aide ?</h2>
        <p class="section-sub">Notre équipe est disponible pour répondre à toutes vos questions.</p>
    </div>
    <div class="contact-grid">
        <div class="contact-info fade-up">
            <div class="contact-item">
                <div class="contact-item-icon" style="background:#071e38;">
                    <svg fill="none" viewBox="0 0 24 24" stroke="#60a5fa"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                </div>
                <div>
                    <div class="contact-item-label">Téléphone</div>
                    <div class="contact-item-value">+237 6XX XXX XXX</div>
                </div>
            </div>
            <div class="contact-item">
                <div class="contact-item-icon" style="background:#0d2e1a;">
                    <svg fill="none" viewBox="0 0 24 24" stroke="#4ade80"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <div class="contact-item-label">Email</div>
                    <div class="contact-item-value">contact@autoloc.cm</div>
                </div>
            </div>
            <div class="contact-item">
                <div class="contact-item-icon" style="background:#2e1f05;">
                    <svg fill="none" viewBox="0 0 24 24" stroke="#fbbf24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div>
                    <div class="contact-item-label">Adresse</div>
                    <div class="contact-item-value">Yaoundé, Cameroun</div>
                </div>
            </div>
            <div class="contact-item">
                <div class="contact-item-icon" style="background:#1a1a2e;">
                    <svg fill="none" viewBox="0 0 24 24" stroke="#a78bfa"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <div class="contact-item-label">Horaires</div>
                    <div class="contact-item-value">Lun–Sam : 8h – 18h</div>
                </div>
            </div>
        </div>
        <div class="contact-form fade-up">
            <h3>Envoyer un message</h3>
            <div class="cf-group">
                <label>Nom complet</label>
                <input type="text" placeholder="Jean Dupont">
            </div>
            <div class="cf-group">
                <label>Email</label>
                <input type="email" placeholder="jean@exemple.com">
            </div>
            <div class="cf-group">
                <label>Sujet</label>
                <input type="text" placeholder="Question sur une location...">
            </div>
            <div class="cf-group">
                <label>Message</label>
                <textarea placeholder="Votre message..."></textarea>
            </div>
            <button class="btn-send">Envoyer le message →</button>
        </div>
    </div>
</section>

{{-- ── FOOTER ── --}}
<footer class="footer">
    <div class="footer-top">
        <div>
            <div class="footer-logo">Auto<em>Loc</em></div>
            <div class="footer-desc">
                La plateforme de location de véhicules moderne au Cameroun.
                Voitures et motos disponibles avec contrats et paiements en ligne.
            </div>
        </div>
        <div>
            <div class="footer-col-title">Navigation</div>
            <div class="footer-links">
                <a href="#vehicules" class="footer-link">Véhicules</a>
                <a href="#comment" class="footer-link">Comment ça marche</a>
                <a href="#apropos" class="footer-link">À propos</a>
                <a href="#contact" class="footer-link">Contact</a>
            </div>
        </div>
        <div>
            <div class="footer-col-title">Compte</div>
            <div class="footer-links">
                <a href="{{ route('login') }}" class="footer-link">Connexion</a>
                <a href="{{ route('register') }}" class="footer-link">S'inscrire</a>
                @auth
                <a href="{{ route('client.dashboard') }}" class="footer-link">Mon espace</a>
                @endauth
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="footer-copy">© {{ date('Y') }} AutoLoc. Tous droits réservés.</div>
        <div class="footer-made">Fait avec <span>♥</span> au Cameroun</div>
    </div>
</footer>

<script>
// Mobile menu
function toggleMenu() {
    document.getElementById('mobileMenu').classList.toggle('open');
}

// Scroll animations
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
        }
    });
}, { threshold: 0.1 });

document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));

// Smooth scroll
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});

// Navbar scroll effect
window.addEventListener('scroll', () => {
    const nav = document.querySelector('.navbar');
    if (window.scrollY > 50) {
        nav.style.background = 'rgba(15,17,23,0.98)';
    } else {
        nav.style.background = 'rgba(15,17,23,0.95)';
    }
});
</script>
</body>
</html>