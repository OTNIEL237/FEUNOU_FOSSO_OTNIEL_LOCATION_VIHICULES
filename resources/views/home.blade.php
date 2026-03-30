<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoLoc — Elite Car Rental Cameroon</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #06070a;
            --card-bg: #111319;
            --accent: #f59e0b;
            --accent-hover: #d97706;
            --text-main: #e8e9f0;
            --text-dim: #9496a8;
            --border: rgba(255, 255, 255, 0.08);
            --glass: rgba(17, 19, 25, 0.8);
            --transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; outline: none; }
        
        html { scroll-behavior: smooth; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg);
            color: var(--text-main);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* ── ANIMATIONS ── */
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        @keyframes reveal {
            from { opacity: 0; transform: translateY(30px); filter: blur(10px); }
            to { opacity: 1; transform: translateY(0); filter: blur(0); }
        }

        .reveal { opacity: 0; }
        .reveal.visible { animation: reveal 0.8s forwards; }

        /* ── NAVBAR ── */
        .navbar {
            position: fixed;
            top: 0; width: 100%; z-index: 1000;
            padding: 20px 5%;
            transition: var(--transition);
        }

        .navbar.scrolled {
            padding: 12px 5%;
            background: var(--glass);
            backdrop-filter: blur(15px);
            border-bottom: 1px solid var(--border);
        }

        .navbar-inner {
            max-width: 1400px; margin: 0 auto;
            display: flex; align-items: center; justify-content: space-between;
        }

        .nav-logo {
            font-family: 'Syne', sans-serif;
            font-size: 24px; font-weight: 800;
            color: #fff; text-decoration: none;
            display: flex; align-items: center; gap: 8px;
        }

        .nav-logo span { color: var(--accent); }

        .nav-links { display: flex; gap: 32px; align-items: center; }

        .nav-link {
            text-decoration: none; color: var(--text-dim);
            font-size: 14px; font-weight: 500; transition: var(--transition);
        }

        .nav-link:hover { color: var(--accent); }

        .nav-btns { display: flex; gap: 15px; }

        .btn {
            padding: 10px 22px; border-radius: 12px;
            font-size: 14px; font-weight: 600; text-decoration: none;
            transition: var(--transition); cursor: pointer;
            border: none; font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .btn-outline {
            background: transparent; color: #fff;
            border: 1px solid var(--border);
        }

        .btn-outline:hover { border-color: var(--accent); color: var(--accent); }

        .btn-filled {
            background: var(--accent); color: #000;
        }

        .btn-filled:hover { 
            background: var(--accent-hover); 
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(245, 158, 11, 0.2);
        }

        /* ── HERO ── */
        .hero {
            min-height: 100vh;
            display: flex; align-items: center;
            padding: 100px 5%;
            position: relative;
            background: radial-gradient(circle at 80% 20%, rgba(245, 158, 11, 0.05), transparent 40%);
        }

        .hero::after {
            content: ''; position: absolute; bottom: 0; left: 0; width: 100%;
            height: 200px; background: linear-gradient(to top, var(--bg), transparent);
        }

        .hero-content { max-width: 800px; z-index: 10; }

        .hero-tag {
            display: inline-flex; align-items: center; gap: 10px;
            padding: 6px 16px; background: rgba(255,255,255,0.03);
            border: 1px solid var(--border); border-radius: 100px;
            font-size: 12px; font-weight: 600; color: var(--accent);
            margin-bottom: 25px;
        }

        .hero-tag .dot { width: 6px; height: 6px; background: #4ade80; border-radius: 50%; box-shadow: 0 0 10px #4ade80; }

        .hero-title {
            font-family: 'Syne', sans-serif;
            font-size: clamp(40px, 8vw, 85px);
            line-height: 0.95; font-weight: 800; color: #fff;
            margin-bottom: 30px; letter-spacing: -2px;
        }

        .hero-title span { color: var(--accent); }

        .hero-desc {
            font-size: 18px; color: var(--text-dim);
            max-width: 550px; margin-bottom: 40px;
        }

        /* ── STATS ── */
        .hero-stats { display: flex; gap: 50px; margin-top: 60px; }
        .stat-item h3 { font-family: 'Syne', sans-serif; font-size: 32px; color: #fff; }
        .stat-item p { font-size: 12px; color: var(--text-dim); text-transform: uppercase; letter-spacing: 1px; }

        /* ── GRID VEHICULES ── */
        .section { padding: 100px 5%; max-width: 1400px; margin: 0 auto; }
        
        .section-head { text-align: center; margin-bottom: 60px; }
        .section-head h2 { font-family: 'Syne', sans-serif; font-size: 40px; margin-bottom: 15px; }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 30px;
        }

        .card {
            background: var(--card-bg);
            border-radius: 24px;
            border: 1px solid var(--border);
            overflow: hidden;
            transition: var(--transition);
            position: relative;
        }

        .card:hover {
            transform: translateY(-10px);
            border-color: rgba(245, 158, 11, 0.3);
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        }

        .card-img {
            width: 100%; height: 220px;
            background: #000; position: relative; overflow: hidden;
        }

        .card-img img {
            width: 100%; height: 100%; object-fit: cover;
            transition: transform 0.6s ease;
        }

        .card:hover .card-img img { transform: scale(1.1); }

        .card-badge {
            position: absolute; top: 15px; right: 15px;
            padding: 5px 12px; border-radius: 8px;
            font-size: 11px; font-weight: 700; text-transform: uppercase;
            background: rgba(0,0,0,0.6); backdrop-filter: blur(5px);
            border: 1px solid rgba(255,255,255,0.1);
        }

        .badge-available { color: #4ade80; }

        .card-content { padding: 25px; }

        .card-title { font-family: 'Syne', sans-serif; font-size: 20px; margin-bottom: 5px; }
        
        .card-meta { 
            display: flex; gap: 15px; color: var(--text-dim); 
            font-size: 13px; margin-bottom: 20px;
        }

        .card-footer {
            display: flex; align-items: center; justify-content: space-between;
            padding-top: 20px; border-top: 1px solid var(--border);
        }

        .card-price { font-family: 'Syne', sans-serif; font-size: 22px; color: var(--accent); }
        .card-price span { font-size: 12px; color: var(--text-dim); font-family: 'Plus Jakarta Sans'; }

        /* ── STEPS ── */
        .steps-container {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px; margin-top: 50px;
        }

        .step-item {
            position: relative; padding: 40px;
            background: rgba(255,255,255,0.02);
            border-radius: 30px; border: 1px solid var(--border);
            transition: var(--transition);
        }

        .step-item:hover { background: rgba(245, 158, 11, 0.05); border-color: var(--accent); }

        .step-num {
            font-family: 'Syne', sans-serif; font-size: 50px;
            color: rgba(255,255,255,0.05); position: absolute;
            top: 20px; right: 30px;
        }

        .step-item h3 { font-family: 'Syne', sans-serif; margin-bottom: 15px; font-size: 20px; }

        /* ── RESPONSIVE ── */
        @media (max-width: 992px) {
            .nav-links { display: none; }
            .hero-title { font-size: 60px; }
        }

        @media (max-width: 768px) {
            .hero-stats { flex-direction: column; gap: 30px; }
            .section { padding: 60px 5%; }
            .navbar { padding: 15px 5%; }
        }

        /* Menu Mobile */
        .mobile-toggle {
            display: none; background: none; border: none; color: #fff; font-size: 24px;
        }

        @media (max-width: 992px) { .mobile-toggle { display: block; } }

    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar" id="navbar">
        <div class="navbar-inner">
            <a href="{{ route('home') }}" class="nav-logo">AUTO<span>LOC</span></a>
            
            <div class="nav-links">
                <a href="#vehicules" class="nav-link">La Flotte</a>
                <a href="#comment" class="nav-link">Processus</a>
                <a href="#apropos" class="nav-link">Elite Service</a>
                <a href="#contact" class="nav-link">Assistance</a>
            </div>

            <div class="nav-btns">
                @auth
                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('client.dashboard') }}" class="btn btn-filled">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline">Connexion</a>
                    <a href="{{ route('register') }}" class="btn btn-filled">S'inscrire</a>
                @endauth
            </div>

            <button class="mobile-toggle">☰</button>
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero">
        <div class="hero-content">
            <div class="hero-tag reveal">
                <span class="dot"></span>
                {{ $stats['available'] }} Véhicules Prêts à Douala & Yaoundé
            </div>
            <h1 class="hero-title reveal" style="transition-delay: 0.1s;">
                L'excellence de la <span>Mobilité</span> au Cameroun.
            </h1>
            <p class="hero-desc reveal" style="transition-delay: 0.2s;">
                Découvrez une sélection exclusive de voitures et motos. Réservation digitale, 
                contrats automatisés et service premium 24h/7.
            </p>
            
            <div class="hero-btns reveal" style="transition-delay: 0.3s;">
                <a href="#vehicules" class="btn btn-filled" style="padding: 18px 35px;">Explorer la Flotte</a>
                <a href="#comment" class="btn btn-outline" style="padding: 18px 35px; margin-left: 15px;">Notre Concept</a>
            </div>

            <div class="hero-stats reveal" style="transition-delay: 0.4s;">
                <div class="stat-item">
                    <h3>{{ $stats['total_vehicles'] }}+</h3>
                    <p>Véhicules</p>
                </div>
                <div class="stat-item">
                    <h3>{{ $stats['cities'] }}</h3>
                    <p>Villes Couvertes</p>
                </div>
                <div class="stat-item">
                    <h3>24/7</h3>
                    <p>Assistance</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FLOTTE -->
    <section class="section" id="vehicules">
        <div class="section-head reveal">
            <p style="color: var(--accent); font-weight: 700; letter-spacing: 2px; text-transform: uppercase; font-size: 12px; margin-bottom: 10px;">Select Collection</p>
            <h2>Nos Véhicules Stars</h2>
        </div>

        <div class="grid">
            @forelse($vehicles as $index => $vehicle)
            <div class="card reveal" style="transition-delay: {{ $index * 0.1 }}s;">
                <div class="card-img">
                    @if($vehicle->image_url)
                        <img src="{{ $vehicle->image_url }}" alt="{{ $vehicle->brand }}">
                    @else
                        <div style="background: #1a1c23; height: 100%; display: flex; align-items: center; justify-content: center;">🚗</div>
                    @endif
                    <div class="card-badge badge-available">
                        {{ $vehicle->status === 'available' ? 'Disponible' : 'Réservé' }}
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-meta">
                        <span>{{ $vehicle->type === 'car' ? 'Berline' : 'Moto' }}</span>
                        <span>•</span>
                        <span>{{ $vehicle->year }}</span>
                    </div>
                    <h3 class="card-title">{{ $vehicle->brand }} {{ $vehicle->model }}</h3>
                    <p style="font-size: 12px; color: var(--text-dim); margin-bottom: 20px;">Immat: {{ $vehicle->plate }}</p>
                    
                    <div class="card-footer">
                        <div class="card-price">
                            {{ number_format($vehicle->price_per_day,0,',',' ') }} <span>XAF / jour</span>
                        </div>
                        <a href="{{ route('login') }}" class="btn btn-filled" style="padding: 8px 15px; font-size: 12px;">Réserver</a>
                    </div>
                </div>
            </div>
            @empty
            <p>Aucun véhicule n'est disponible pour le moment.</p>
            @endforelse
        </div>
    </section>

    <!-- PROCESSUS -->
    <section class="section" id="comment" style="background: #090a0f;">
        <div class="section-head reveal">
            <h2>Expérience Digitale</h2>
            <p style="color: var(--text-dim);">Louer une voiture n'a jamais été aussi fluide.</p>
        </div>

        <div class="steps-container">
            <div class="step-item reveal">
                <div class="step-num">01</div>
                <h3>Sélection</h3>
                <p style="color: var(--text-dim); font-size: 14px;">Choisissez votre véhicule idéal parmi notre catalogue mis à jour en temps réel.</p>
            </div>
            <div class="step-item reveal" style="transition-delay: 0.1s;">
                <div class="step-num">02</div>
                <h3>Réservation</h3>
                <p style="color: var(--text-dim); font-size: 14px;">Définissez vos dates et validez votre identité en quelques clics sécurisés.</p>
            </div>
            <div class="step-item reveal" style="transition-delay: 0.2s;">
                <div class="step-num">03</div>
                <h3>Paiement</h3>
                <p style="color: var(--text-dim); font-size: 14px;">Payez via Mobile Money (Orange/MTN) ou Carte via notre passerelle sécurisée.</p>
            </div>
            <div class="step-item reveal" style="transition-delay: 0.3s;">
                <div class="step-num">04</div>
                <h3>Contrat</h3>
                <p style="color: var(--text-dim); font-size: 14px;">Récupérez vos clés. Votre contrat numérique est déjà dans votre boîte mail.</p>
            </div>
        </div>
    </section>

    <!-- CONTACT QUICK FORM -->
    <section class="section" id="contact">
        <div style="background: linear-gradient(to right, #111319, #08090d); border-radius: 40px; padding: 60px; border: 1px solid var(--border); display: grid; grid-template-columns: 1fr 1fr; gap: 50px; align-items: center;">
            <div class="reveal">
                <h2 style="font-family: 'Syne'; font-size: 45px; margin-bottom: 20px;">Prêt à prendre <br> la <span>route</span> ?</h2>
                <p style="color: var(--text-dim); margin-bottom: 30px;">Une question ? Notre équipe d'élite vous répond en moins de 15 minutes.</p>
                <div style="display: flex; gap: 20px;">
                    <div class="btn btn-outline">WhatsApp Support</div>
                    <div class="btn btn-filled">Nous Appeler</div>
                </div>
            </div>
            <div class="reveal" style="transition-delay: 0.2s;">
                <form style="display: flex; flex-direction: column; gap: 15px;">
                    <input type="text" placeholder="Nom complet" style="padding: 15px; border-radius: 12px; background: #000; border: 1px solid var(--border); color: #fff;">
                    <input type="email" placeholder="Email" style="padding: 15px; border-radius: 12px; background: #000; border: 1px solid var(--border); color: #fff;">
                    <textarea placeholder="Votre message" style="padding: 15px; border-radius: 12px; background: #000; border: 1px solid var(--border); color: #fff; height: 100px;"></textarea>
                    <button class="btn btn-filled">Envoyer la demande</button>
                </form>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer style="padding: 60px 5%; border-top: 1px solid var(--border); text-align: center;">
        <div class="nav-logo" style="justify-content: center; margin-bottom: 30px;">AUTO<span>LOC</span></div>
        <div style="display: flex; justify-content: center; gap: 30px; margin-bottom: 30px;">
            <a href="#" class="nav-link">Facebook</a>
            <a href="#" class="nav-link">Instagram</a>
            <a href="#" class="nav-link">LinkedIn</a>
        </div>
        <p style="color: var(--text-dim); font-size: 13px;">© {{ date('Y') }} AutoLoc Cameroon. Luxury Mobility Solutions.</p>
    </footer>

    <script>
        // Effet scroll navbar
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 50) nav.classList.add('scrolled');
            else nav.classList.remove('scrolled');
        });

        // Intersection Observer pour les animations au scroll
        const observerOptions = { threshold: 0.1 };
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
    </script>
</body>
</html>