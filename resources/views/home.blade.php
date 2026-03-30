<!DOCTYPE html>
<html lang="fr" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AutoLoc Elite — Location de Véhicules de Prestige au Cameroun</title>

    <!-- SEO & Meta -->
    <meta name="description" content="AutoLoc est la plateforme leader de location de voitures et motos au Cameroun. Réservation en ligne, paiement sécurisé et assistance 24/7.">
    <meta name="keywords" content="Location voiture Cameroun, Douala car rental, Yaoundé location moto, AutoLoc">
    <meta name="author" content="AutoLoc Elite Team">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=Plus+Jakarta+Sans:wght@200;300;400;500;600;700;800&family=Inter:wght@900&display=swap" rel="stylesheet">

    <style>
        /* 
        ================================================================
        1. CSS VARIABLES & DESIGN SYSTEM
        ================================================================
        */
        :root {
            /* Palette de Couleurs Noire & Or */
            --color-black-pure: #000000;
            --color-black-deep: #050505;
            --color-black-card: #0c0d12;
            --color-black-soft: #14151a;
            
            --color-accent: #f59e0b;
            --color-accent-rgb: 245, 158, 11;
            --color-accent-light: #fbbf24;
            --color-accent-dark: #b45309;
            
            --color-text-main: #ffffff;
            --color-text-muted: #888995;
            --color-text-dim: #555661;
            
            --color-success: #10b981;
            --color-error: #ef4444;
            
            /* Bordures & Verre */
            --border-white: rgba(255, 255, 255, 0.08);
            --border-accent: rgba(245, 158, 11, 0.2);
            --glass-bg: rgba(5, 5, 5, 0.8);
            --glass-blur: blur(12px);
            
            /* Espacement & Transitions */
            --section-padding: 120px;
            --container-max: 1440px;
            --transition-main: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
            --transition-fast: all 0.2s ease;
            --radius-lg: 32px;
            --radius-md: 16px;
            --radius-sm: 8px;
        }

        /* 
        ================================================================
        2. BASE RESET
        ================================================================
        */
        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        html {
            scroll-behavior: smooth;
            font-size: 16px;
            background-color: var(--color-black-pure);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--color-black-pure);
            color: var(--color-text-main);
            overflow-x: hidden;
            line-height: 1.6;
        }

        a { text-decoration: none; color: inherit; transition: var(--transition-fast); }
        ul { list-style: none; }
        img { max-width: 100%; height: auto; display: block; }
        button, input, textarea, select {
            font-family: inherit;
            background: none;
            border: none;
            outline: none;
        }

        ::selection {
            background-color: var(--color-accent);
            color: var(--color-black-pure);
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: var(--color-black-pure); }
        ::-webkit-scrollbar-thumb { 
            background: var(--color-black-soft); 
            border-radius: 10px;
            border: 2px solid var(--color-black-pure);
        }
        ::-webkit-scrollbar-thumb:hover { background: var(--color-accent); }

        /* 
        ================================================================
        3. TYPOGRAPHIE UTILITIES
        ================================================================
        */
        .font-syne { font-family: 'Syne', sans-serif; }
        .text-accent { color: var(--color-accent); }
        .text-muted { color: var(--color-text-muted); }
        .text-upper { text-transform: uppercase; letter-spacing: 0.1em; }
        .text-center { text-align: center; }
        
        .h-large { font-family: 'Syne', sans-serif; font-size: clamp(48px, 8vw, 100px); line-height: 0.9; font-weight: 800; letter-spacing: -0.04em; }
        .h-section { font-family: 'Syne', sans-serif; font-size: clamp(32px, 4vw, 56px); line-height: 1.1; font-weight: 800; }
        .h-card { font-family: 'Syne', sans-serif; font-size: 24px; font-weight: 700; }

        /* 
        ================================================================
        4. ANIMATIONS & KEYFRAMES
        ================================================================
        */
        @keyframes preloader {
            0% { width: 0; left: 0; }
            50% { width: 100%; left: 0; }
            100% { width: 0; left: 100%; }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(40px); filter: blur(10px); }
            to { opacity: 1; transform: translateY(0); filter: blur(0); }
        }

        @keyframes revealSide {
            from { clip-path: inset(0 100% 0 0); }
            to { clip-path: inset(0 0 0 0); }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        @keyframes pulse-accent {
            0% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.4); }
            70% { box-shadow: 0 0 0 20px rgba(245, 158, 11, 0); }
            100% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0); }
        }

        .reveal { opacity: 0; }
        .reveal.active { animation: fadeInUp 1s cubic-bezier(0.16, 1, 0.3, 1) forwards; }

        /* 
        ================================================================
        5. UI COMPONENTS (Buttons, Inputs, Cards)
        ================================================================
        */
        .container { max-width: var(--container-max); margin: 0 auto; padding: 0 5%; }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 18px 36px;
            border-radius: 100px;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            transition: var(--transition-main);
            position: relative;
            overflow: hidden;
            z-index: 1;
            cursor: pointer;
        }

        .btn-primary {
            background-color: var(--color-accent);
            color: var(--color-black-pure);
        }

        .btn-primary:hover {
            background-color: var(--color-accent-light);
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 20px 40px rgba(245, 158, 11, 0.3);
        }

        .btn-outline {
            border: 1px solid var(--border-white);
            color: var(--color-text-main);
            backdrop-filter: var(--glass-blur);
        }

        .btn-outline:hover {
            border-color: var(--color-accent);
            background: rgba(255, 255, 255, 0.05);
            color: var(--color-accent);
        }

        .btn-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--color-black-soft);
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--border-white);
        }

        /* 
        ================================================================
        6. PRELOADER
        ================================================================
        */
        #preloader {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: var(--color-black-pure);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.8s ease;
        }

        .loader-bar {
            width: 200px;
            height: 2px;
            background: rgba(255,255,255,0.1);
            position: relative;
            overflow: hidden;
        }

        .loader-bar::after {
            content: '';
            position: absolute;
            height: 100%;
            background: var(--color-accent);
            animation: preloader 2s infinite;
        }

        /* 
        ================================================================
        7. NAVIGATION (Elite Navbar)
        ================================================================
        */
        header {
            position: fixed;
            top: 0; left: 0; width: 100%;
            z-index: 1000;
            padding: 30px 0;
            transition: var(--transition-main);
        }

        header.scrolled {
            padding: 15px 0;
            background: var(--glass-bg);
            backdrop-filter: var(--glass-blur);
            border-bottom: 1px solid var(--border-white);
        }

        .nav-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            font-family: 'Syne', sans-serif;
            font-size: 28px;
            font-weight: 800;
            color: var(--color-text-main);
            letter-spacing: -1px;
        }

        .logo span { color: var(--color-accent); }

        .nav-menu {
            display: flex;
            gap: 40px;
        }

        .nav-link {
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--color-text-muted);
            position: relative;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px; left: 0; width: 0; height: 2px;
            background: var(--color-accent);
            transition: var(--transition-fast);
        }

        .nav-link:hover { color: var(--color-text-main); }
        .nav-link:hover::after { width: 100%; }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .mobile-toggle {
            display: none;
            flex-direction: column;
            gap: 6px;
            cursor: pointer;
        }

        .mobile-toggle span {
            width: 30px;
            height: 2px;
            background: var(--color-text-main);
            transition: var(--transition-fast);
        }

        /* 
        ================================================================
        8. HERO SECTION (Parallax & Video Support)
        ================================================================
        */
        .hero {
            height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            background: radial-gradient(circle at 70% 30%, rgba(245, 158, 11, 0.08), transparent 45%);
            overflow: hidden;
        }

        .hero-bg-overlay {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: url('https://www.transparenttextures.com/patterns/carbon-fibre.png');
            opacity: 0.2;
            pointer-events: none;
        }

        .hero-content {
            position: relative;
            z-index: 10;
            max-width: 900px;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 8px 20px;
            background: rgba(255,255,255,0.03);
            border: 1px solid var(--border-white);
            border-radius: 100px;
            margin-bottom: 30px;
        }

        .hero-badge .status-dot {
            width: 8px; height: 8px;
            background: var(--color-success);
            border-radius: 50%;
            box-shadow: 0 0 10px var(--color-success);
        }

        .hero-title span {
            display: block;
        }

        .hero-desc {
            font-size: 20px;
            color: var(--color-text-muted);
            margin: 30px 0 50px;
            max-width: 600px;
        }

        .hero-visual {
            position: absolute;
            right: -5%;
            top: 55%;
            transform: translateY(-50%);
            width: 55%;
            pointer-events: none;
            opacity: 0.15;
            filter: grayscale(1);
            animation: float 6s ease-in-out infinite;
        }

        /* 
        ================================================================
        9. PARTNERS (Social Proof)
        ================================================================
        */
        .partners {
            padding: 60px 0;
            border-top: 1px solid var(--border-white);
            border-bottom: 1px solid var(--border-white);
        }

        .partner-track {
            display: flex;
            justify-content: space-between;
            align-items: center;
            opacity: 0.4;
            filter: grayscale(1);
        }

        .partner-logo {
            font-family: 'Syne', sans-serif;
            font-size: 24px;
            font-weight: 800;
        }

        /* 
        ================================================================
        10. VEHICLE GRID (Elite Cards)
        ================================================================
        */
        .section-padding { padding: var(--section-padding) 0; }

        .section-header {
            margin-bottom: 80px;
            max-width: 700px;
        }

        .tagline {
            color: var(--color-accent);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            font-size: 12px;
            margin-bottom: 15px;
            display: block;
        }

        .vehicle-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
            gap: 40px;
        }

        .vehicle-card {
            background: var(--color-black-card);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border-white);
            overflow: hidden;
            transition: var(--transition-main);
            position: relative;
        }

        .vehicle-card:hover {
            transform: translateY(-15px);
            border-color: var(--border-accent);
            box-shadow: 0 40px 80px rgba(0,0,0,0.6);
        }

        .card-image {
            width: 100%;
            height: 280px;
            position: relative;
            overflow: hidden;
            background: #000;
        }

        .card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.8s ease;
        }

        .vehicle-card:hover .card-image img {
            transform: scale(1.1);
        }

        .card-overlay {
            position: absolute;
            top: 20px; right: 20px;
            z-index: 5;
        }

        .status-badge {
            padding: 6px 14px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            backdrop-filter: var(--glass-blur);
            border: 1px solid rgba(255,255,255,0.1);
        }

        .status-available { background: rgba(16, 185, 129, 0.2); color: var(--color-success); }
        .status-rented { background: rgba(239, 68, 68, 0.2); color: var(--color-error); }

        .card-body {
            padding: 35px;
        }

        .card-category {
            font-size: 12px;
            color: var(--color-text-dim);
            text-transform: uppercase;
            margin-bottom: 10px;
            display: block;
        }

        .card-specs {
            display: flex;
            gap: 20px;
            margin: 20px 0 30px;
            padding: 15px 0;
            border-top: 1px solid var(--border-white);
            border-bottom: 1px solid var(--border-white);
        }

        .spec-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--color-text-muted);
        }

        .card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .price-tag {
            display: flex;
            flex-direction: column;
        }

        .price-value {
            font-family: 'Syne', sans-serif;
            font-size: 28px;
            font-weight: 800;
            color: var(--color-accent);
        }

        .price-label {
            font-size: 12px;
            color: var(--color-text-dim);
        }

        /* 
        ================================================================
        11. FEATURES SECTION
        ================================================================
        */
        .features {
            background-color: var(--color-black-deep);
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .feature-item {
            padding: 50px;
            background: var(--color-black-soft);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border-white);
            transition: var(--transition-main);
        }

        .feature-item:hover {
            border-color: var(--color-accent);
            transform: translateY(-10px);
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            border-radius: 20px;
            background: rgba(245, 158, 11, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
            color: var(--color-accent);
        }

        .feature-item h3 {
            font-family: 'Syne', sans-serif;
            font-size: 24px;
            margin-bottom: 20px;
        }

        /* 
        ================================================================
        12. HOW IT WORKS
        ================================================================
        */
        .steps {
            position: relative;
        }

        .step-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 40px;
            margin-top: 60px;
        }

        .step-card {
            text-align: center;
            position: relative;
        }

        .step-number {
            font-family: 'Inter', sans-serif;
            font-size: 120px;
            line-height: 1;
            color: rgba(255,255,255,0.03);
            position: absolute;
            top: -40px; left: 50%;
            transform: translateX(-50%);
            z-index: 1;
        }

        .step-content {
            position: relative;
            z-index: 2;
        }

        .step-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 30px;
            background: var(--color-accent);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--color-black-pure);
            font-size: 24px;
            font-weight: 800;
        }

        /* 
        ================================================================
        13. TESTIMONIALS
        ================================================================
        */
        .testimonials {
            background: radial-gradient(circle at 10% 50%, rgba(245, 158, 11, 0.05), transparent 40%);
        }

        .testimonial-slider {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 40px;
        }

        .testimonial-card {
            padding: 60px;
            background: var(--glass-bg);
            backdrop-filter: var(--glass-blur);
            border: 1px solid var(--border-white);
            border-radius: var(--radius-lg);
        }

        .testimonial-quote {
            font-size: 22px;
            font-weight: 500;
            color: var(--color-text-main);
            margin-bottom: 40px;
            font-style: italic;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--color-accent);
        }

        /* 
        ================================================================
        14. CTA SECTION
        ================================================================
        */
        .cta {
            padding: 100px 0;
        }

        .cta-banner {
            background: var(--color-accent);
            border-radius: var(--radius-lg);
            padding: 80px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: var(--color-black-pure);
            position: relative;
            overflow: hidden;
        }

        .cta-banner::before {
            content: 'AUTOLOC';
            position: absolute;
            font-family: 'Inter', sans-serif;
            font-size: 150px;
            font-weight: 900;
            color: rgba(0,0,0,0.05);
            bottom: -50px; right: -20px;
        }

        .cta-text h2 {
            font-family: 'Syne', sans-serif;
            font-size: 56px;
            font-weight: 800;
            line-height: 1;
        }

        .cta-banner .btn-primary {
            background: var(--color-black-pure);
            color: var(--color-accent);
        }

        /* 
        ================================================================
        15. FAQ SECTION
        ================================================================
        */
        .faq-grid {
            max-width: 800px;
            margin: 0 auto;
        }

        .faq-item {
            border-bottom: 1px solid var(--border-white);
            padding: 30px 0;
        }

        .faq-question {
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
        }

        .faq-question h3 {
            font-size: 20px;
            font-weight: 700;
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: var(--transition-main);
            color: var(--color-text-muted);
        }

        .faq-item.active .faq-answer {
            max-height: 200px;
            padding-top: 20px;
        }

        /* 
        ================================================================
        16. FOOTER
        ================================================================
        */
        footer {
            padding: 100px 0 50px;
            background: var(--color-black-deep);
            border-top: 1px solid var(--border-white);
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1.5fr;
            gap: 80px;
            margin-bottom: 80px;
        }

        .footer-logo { margin-bottom: 30px; }

        .footer-desc { color: var(--color-text-muted); font-size: 15px; margin-bottom: 30px; }

        .footer-title {
            font-family: 'Syne', sans-serif;
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 30px;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        .footer-list li { margin-bottom: 15px; }
        .footer-list a { color: var(--color-text-muted); font-size: 14px; }
        .footer-list a:hover { color: var(--color-accent); }

        .newsletter-form {
            display: flex;
            gap: 10px;
            background: var(--color-black-soft);
            padding: 8px;
            border-radius: 100px;
            border: 1px solid var(--border-white);
        }

        .newsletter-form input {
            flex: 1;
            padding: 0 20px;
            color: #fff;
        }

        .footer-bottom {
            padding-top: 50px;
            border-top: 1px solid var(--border-white);
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: var(--color-text-dim);
            font-size: 13px;
        }

        /* 
        ================================================================
        17. RESPONSIVE DESIGN (Media Queries)
        ================================================================
        */
        @media (max-width: 1200px) {
            .footer-grid { grid-template-columns: 1fr 1fr; gap: 40px; }
            .hero-visual { display: none; }
        }

        @media (max-width: 992px) {
            :root { --section-padding: 80px; }
            .nav-menu, .nav-actions .btn { display: none; }
            .mobile-toggle { display: flex; }
            .h-large { font-size: 64px; }
            .feature-grid { grid-template-columns: 1fr; }
            .cta-banner { flex-direction: column; text-align: center; gap: 40px; padding: 50px; }
            .cta-text h2 { font-size: 40px; }
        }

        @media (max-width: 768px) {
            .vehicle-grid { grid-template-columns: 1fr; }
            .step-row { grid-template-columns: 1fr; }
            .testimonial-slider { grid-template-columns: 1fr; }
            .footer-grid { grid-template-columns: 1fr; }
            .footer-bottom { flex-direction: column; gap: 20px; text-align: center; }
        }

        /* Custom Cursor (Optional but Premium) */
        #custom-cursor {
            width: 30px; height: 30px;
            border: 2px solid var(--color-accent);
            border-radius: 50%;
            position: fixed;
            pointer-events: none;
            z-index: 9999;
            transition: transform 0.1s ease-out;
            transform: translate(-50%, -50%);
            display: none;
        }

        @media (min-width: 993px) { #custom-cursor { display: block; } }

    </style>
</head>
<body>

    <!-- CUSTOM CURSOR -->
    <div id="custom-cursor"></div>

    <!-- PRELOADER -->
    <div id="preloader">
        <div class="loader-inner">
            <div class="logo" style="margin-bottom: 20px; text-align:center;">AUTO<span>LOC</span></div>
            <div class="loader-bar"></div>
        </div>
    </div>

    <!-- HEADER -->
    <header id="main-header">
        <div class="container">
            <nav class="nav-inner">
                <a href="{{ route('home') }}" class="logo">AUTO<span>LOC</span></a>
                
                <ul class="nav-menu">
                    <li><a href="#vehicules" class="nav-link">La Flotte</a></li>
                    <li><a href="#features" class="nav-link">Avantages</a></li>
                    <li><a href="#comment" class="nav-link">Concept</a></li>
                    <li><a href="#faq" class="nav-link">Aide</a></li>
                </ul>

                <div class="nav-actions">
                    @auth
                        <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('client.dashboard') }}" class="btn btn-primary" style="padding: 12px 25px;">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-link" style="font-weight: 700; font-size: 13px; text-transform: uppercase;">Connexion</a>
                        <a href="{{ route('register') }}" class="btn btn-primary" style="padding: 12px 25px;">S'inscrire</a>
                    @endauth
                    
                    <div class="mobile-toggle" id="menuOpen">
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main>

        <!-- HERO SECTION -->
        <section class="hero">
            <div class="hero-bg-overlay"></div>
            <div class="container">
                <div class="hero-content">
                    <div class="hero-badge reveal">
                        <span class="status-dot"></span>
                        <span class="text-upper" style="font-size: 11px; font-weight: 700;">{{ $stats['available'] }} Véhicules prêts à Yaoundé & Douala</span>
                    </div>
                    <h1 class="h-large reveal">
                        Redéfinir la <span>Mobilité</span><br>au Cameroun.
                    </h1>
                    <p class="hero-desc reveal">
                        Accédez à une sélection rigoureuse de véhicules de prestige et utilitaires. 
                        Expérience 100% digitale, contrats sécurisés et liberté totale.
                    </p>
                    <div class="hero-btns reveal" style="display: flex; gap: 20px;">
                        <a href="#vehicules" class="btn btn-primary">Explorer la flotte</a>
                        <a href="#comment" class="btn btn-outline">Comment ça marche ?</a>
                    </div>
                </div>
            </div>
            
            <!-- Floating Decorative Car Image -->
            <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Car silhouette" class="hero-visual">
        </section>

        <!-- PARTNERS -->
        <section class="partners">
            <div class="container">
                <div class="partner-track">
                    <span class="partner-logo">MERCEDES-BENZ</span>
                    <span class="partner-logo">TOYOTA</span>
                    <span class="partner-logo">PORSCHE</span>
                    <span class="partner-logo">BMW</span>
                    <span class="partner-logo">RANGE ROVER</span>
                </div>
            </div>
        </section>

        <!-- VEHICLE GRID SECTION -->
        <section class="section-padding" id="vehicules">
            <div class="container">
                <div class="section-header reveal">
                    <span class="tagline">Notre Flotte Elite</span>
                    <h2 class="h-section">Choisissez votre<br>prochaine destination</h2>
                </div>

                <div class="vehicle-grid">
                    @forelse($vehicles as $index => $vehicle)
                    <article class="vehicle-card reveal" style="transition-delay: {{ ($index % 3) * 0.1 }}s;">
                        <div class="card-image">
                            @if($vehicle->image_url)
                                <img src="{{ $vehicle->image_url }}" alt="{{ $vehicle->brand }} {{ $vehicle->model }}">
                            @else
                                <div style="height:100%; display:flex; align-items:center; justify-content:center; background:#111;">🚗</div>
                            @endif
                            <div class="card-overlay">
                                <span class="status-badge {{ $vehicle->status === 'available' ? 'status-available' : 'status-rented' }}">
                                    {{ $vehicle->status === 'available' ? 'Disponible' : 'Réservé' }}
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <span class="card-category">{{ $vehicle->type === 'car' ? 'Premium Sedan' : 'Urban Moto' }}</span>
                            <h3 class="h-card">{{ $vehicle->brand }} {{ $vehicle->model }}</h3>
                            
                            <div class="card-specs">
                                <div class="spec-item">
                                    <svg width="16" height="16" fill="var(--color-accent)" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/></svg>
                                    {{ $vehicle->year }}
                                </div>
                                <div class="spec-item">
                                    <svg width="16" height="16" fill="var(--color-accent)" viewBox="0 0 24 24"><path d="M12 2L4.5 20.29l.71.71L12 18l6.79 3 .71-.71z"/></svg>
                                    GPS inclus
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="price-tag">
                                    <span class="price-value">{{ number_format($vehicle->price_per_day, 0, ',', ' ') }} F</span>
                                    <span class="price-label">par jour</span>
                                </div>
                                <a href="{{ route('login') }}" class="btn-icon">
                                    <svg width="20" height="20" fill="white" viewBox="0 0 24 24"><path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/></svg>
                                </a>
                            </div>
                        </div>
                    </article>
                    @empty
                    <div style="grid-column: 1/-1; text-align:center; padding:100px;">
                        <p class="text-muted">Aucun véhicule n'est disponible pour le moment.</p>
                    </div>
                    @endforelse
                </div>
                
                <div class="text-center" style="margin-top: 60px;">
                    <a href="{{ route('register') }}" class="btn btn-outline">Voir toute la flotte</a>
                </div>
            </div>
        </section>

        <!-- WHY CHOOSE US (Features) -->
        <section class="section-padding features" id="features">
            <div class="container">
                <div class="section-header reveal text-center" style="margin: 0 auto 80px;">
                    <span class="tagline">Elite Service</span>
                    <h2 class="h-section">Pourquoi choisir AutoLoc ?</h2>
                </div>

                <div class="feature-grid">
                    <!-- Feature 1 -->
                    <div class="feature-item reveal">
                        <div class="feature-icon">
                            <svg width="32" height="32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"/></svg>
                        </div>
                        <h3>Sécurité Totale</h3>
                        <p class="text-muted">Chaque location est couverte par une assurance premium et des contrats certifiés juridiquement.</p>
                    </div>
                    <!-- Feature 2 -->
                    <div class="feature-item reveal" style="transition-delay: 0.1s;">
                        <div class="feature-icon">
                            <svg width="32" height="32" fill="currentColor" viewBox="0 0 24 24"><path d="M11.5 2C6.81 2 3 5.81 3 10.5S6.81 19 11.5 19h.5v3c4.86-2.36 8-5.29 8-11.5C20 5.81 16.19 2 11.5 2zm1 14.5h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg>
                        </div>
                        <h3>Assistance 24/7</h3>
                        <p class="text-muted">Une panne ? Un besoin ? Notre équipe est sur le terrain 24h/24 pour garantir votre mobilité.</p>
                    </div>
                    <!-- Feature 3 -->
                    <div class="feature-item reveal" style="transition-delay: 0.2s;">
                        <div class="feature-icon">
                            <svg width="32" height="32" fill="currentColor" viewBox="0 0 24 24"><path d="M21 7.28V5c0-1.1-.9-2-2-2H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2v-2.28c.59-.35 1-.98 1-1.72V9c0-.74-.41-1.37-1-1.72zM20 9v6h-7V9h7zM5 19V5h14v2h-6c-1.1 0-2 .9-2 2v6c0 1.1.9 2 2 2h6v2H5z"/></svg>
                        </div>
                        <h3>Digital First</h3>
                        <p class="text-muted">Pas de paperasse. Payez via Mobile Money ou Carte, et recevez vos documents instantanément.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- STEPS SECTION -->
        <section class="section-padding steps" id="comment">
            <div class="container">
                <div class="section-header reveal">
                    <span class="tagline">Processus Elite</span>
                    <h2 class="h-section">Votre véhicule en<br>4 étapes simples</h2>
                </div>

                <div class="step-row">
                    <!-- Step 1 -->
                    <div class="step-card reveal">
                        <div class="step-number">01</div>
                        <div class="step-content">
                            <div class="step-icon">1</div>
                            <h3>Sélection</h3>
                            <p class="text-muted">Parcourez notre catalogue premium et choisissez le modèle idéal.</p>
                        </div>
                    </div>
                    <!-- Step 2 -->
                    <div class="step-card reveal" style="transition-delay: 0.1s;">
                        <div class="step-number">02</div>
                        <div class="step-content">
                            <div class="step-icon">2</div>
                            <h3>Réservation</h3>
                            <p class="text-muted">Définissez vos dates et confirmez votre identité en 2 minutes.</p>
                        </div>
                    </div>
                    <!-- Step 3 -->
                    <div class="step-card reveal" style="transition-delay: 0.2s;">
                        <div class="step-number">03</div>
                        <div class="step-content">
                            <div class="step-icon">3</div>
                            <h3>Paiement</h3>
                            <p class="text-muted">Transaction sécurisée via Orange, MTN ou Carte Bancaire.</p>
                        </div>
                    </div>
                    <!-- Step 4 -->
                    <div class="step-card reveal" style="transition-delay: 0.3s;">
                        <div class="step-number">04</div>
                        <div class="step-content">
                            <div class="step-icon">4</div>
                            <h3>Liberté</h3>
                            <p class="text-muted">Récupérez les clés et roulez. On s'occupe du reste.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- TESTIMONIALS -->
        <section class="section-padding testimonials">
            <div class="container">
                <div class="section-header reveal">
                    <span class="tagline">Retours d'expérience</span>
                    <h2 class="h-section">Ils nous font confiance</h2>
                </div>

                <div class="testimonial-slider">
                    <div class="testimonial-card reveal">
                        <p class="testimonial-quote">"Service impeccable. La Range Rover était comme neuve. Le processus de paiement Mobile Money est une révolution au Cameroun."</p>
                        <div class="user-info">
                            <div class="user-avatar"></div>
                            <div>
                                <h4 style="font-weight: 700;">Samuel Eto'o</h4>
                                <p class="text-muted" style="font-size: 12px;">Client Fidèle - Douala</p>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-card reveal" style="transition-delay: 0.1s;">
                        <p class="testimonial-quote">"Enfin une agence sérieuse. Contrat reçu par email en 5 minutes. J'ai pu louer une moto pour mes déplacements rapides à Yaoundé."</p>
                        <div class="user-info">
                            <div class="user-avatar" style="background: var(--color-text-dim);"></div>
                            <div>
                                <h4 style="font-weight: 700;">Marcelle N.</h4>
                                <p class="text-muted" style="font-size: 12px;">CEO - Yaoundé</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ SECTION -->
        <section class="section-padding" id="faq">
            <div class="container">
                <div class="section-header reveal text-center" style="margin: 0 auto 80px;">
                    <span class="tagline">FAQ</span>
                    <h2 class="h-section">Vos questions fréquentes</h2>
                </div>

                <div class="faq-grid">
                    <div class="faq-item reveal">
                        <div class="faq-question">
                            <h3>Quels documents sont nécessaires ?</h3>
                            <span>+</span>
                        </div>
                        <div class="faq-answer">
                            <p>Vous avez simplement besoin d'une pièce d'identité valide (CNI ou Passeport) et d'un permis de conduire en cours de validité de plus de 2 ans.</p>
                        </div>
                    </div>
                    <div class="faq-item reveal">
                        <div class="faq-question">
                            <h3>Comment fonctionne la caution ?</h3>
                            <span>+</span>
                        </div>
                        <div class="faq-answer">
                            <p>Une caution est demandée lors de la réservation. Elle est intégralement restituée après vérification du véhicule lors de son retour.</p>
                        </div>
                    </div>
                    <div class="faq-item reveal">
                        <div class="faq-question">
                            <h3>Livrez-vous le véhicule à domicile ?</h3>
                            <span>+</span>
                        </div>
                        <div class="faq-answer">
                            <p>Oui, AutoLoc propose un service de livraison Premium à Douala et Yaoundé directement à votre domicile ou à l'aéroport.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA SECTION -->
        <section class="cta reveal">
            <div class="container">
                <div class="cta-banner">
                    <div class="cta-text">
                        <h2>Prêt pour une<br>nouvelle expérience ?</h2>
                        <p style="margin-top: 20px; font-weight: 500;">Rejoignez l'élite de la mobilité au Cameroun.</p>
                    </div>
                    <a href="{{ route('register') }}" class="btn btn-primary">Démarrer maintenant</a>
                </div>
            </div>
        </section>

    </main>

    <!-- FOOTER -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-info">
                    <div class="logo footer-logo">AUTO<span>LOC</span></div>
                    <p class="footer-desc">AutoLoc est le standard premium de la location de véhicules au Cameroun. Nous combinons technologie et service de terrain pour une liberté sans compromis.</p>
                    <div class="social-links" style="display: flex; gap: 15px;">
                        <a href="#" class="btn-icon">FB</a>
                        <a href="#" class="btn-icon">IG</a>
                        <a href="#" class="btn-icon">WA</a>
                    </div>
                </div>

                <div>
                    <h4 class="footer-title">Navigation</h4>
                    <ul class="footer-list">
                        <li><a href="#">Accueil</a></li>
                        <li><a href="#vehicules">La Flotte</a></li>
                        <li><a href="#comment">Concept</a></li>
                        <li><a href="{{ route('login') }}">Mon Espace</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="footer-title">Support</h4>
                    <ul class="footer-list">
                        <li><a href="#">Aide & FAQ</a></li>
                        <li><a href="#">Conditions Générales</a></li>
                        <li><a href="#">Politique de Confidentialité</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="footer-title">Newsletter</h4>
                    <p class="text-muted" style="font-size: 14px; margin-bottom: 20px;">Recevez nos offres exclusives.</p>
                    <form class="newsletter-form">
                        <input type="email" placeholder="Votre email">
                        <button type="submit" class="btn btn-primary" style="padding: 10px 20px;">OK</button>
                    </form>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} AutoLoc Cameroon. Tous droits réservés.</p>
                <p>Elite Mobility Solution — Made with ♥ in Douala</p>
            </div>
        </div>
    </footer>

    <!-- 
    ================================================================
    18. JAVASCRIPT LOGIC
    ================================================================
    -->
    <script>
        /**
         * Preloader logic
         */
        window.addEventListener('load', () => {
            const preloader = document.getElementById('preloader');
            setTimeout(() => {
                preloader.style.opacity = '0';
                setTimeout(() => {
                    preloader.style.display = 'none';
                    // Trigger first animations
                    handleScrollAnimations();
                }, 800);
            }, 1000);
        });

        /**
         * Header Scroll Effect
         */
        const header = document.getElementById('main-header');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        /**
         * Custom Cursor Movement
         */
        const cursor = document.getElementById('custom-cursor');
        document.addEventListener('mousemove', (e) => {
            cursor.style.left = e.clientX + 'px';
            cursor.style.top = e.clientY + 'px';
        });

        document.querySelectorAll('a, button, .card').forEach(el => {
            el.addEventListener('mouseenter', () => {
                cursor.style.transform = 'translate(-50%, -50%) scale(2)';
                cursor.style.backgroundColor = 'rgba(245, 158, 11, 0.1)';
            });
            el.addEventListener('mouseleave', () => {
                cursor.style.transform = 'translate(-50%, -50%) scale(1)';
                cursor.style.backgroundColor = 'transparent';
            });
        });

        /**
         * Scroll Reveal Observer
         */
        function handleScrollAnimations() {
            const reveals = document.querySelectorAll('.reveal');
            const observerOptions = {
                threshold: 0.15,
                rootMargin: "0px 0px -50px 0px"
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                        // Option: observer.unobserve(entry.target); 
                    }
                });
            }, observerOptions);

            reveals.forEach(reveal => observer.observe(reveal));
        }

        /**
         * FAQ Accordion
         */
        const faqItems = document.querySelectorAll('.faq-item');
        faqItems.forEach(item => {
            const question = item.querySelector('.faq-question');
            question.addEventListener('click', () => {
                const isActive = item.classList.contains('active');
                
                // Close all others
                faqItems.forEach(i => i.classList.remove('active'));
                
                if (!isActive) {
                    item.classList.add('active');
                }
            });
        });

        /**
         * Parallax Effect for Hero Image
         */
        window.addEventListener('scroll', () => {
            const visual = document.querySelector('.hero-visual');
            const scrolled = window.pageYOffset;
            if (visual) {
                visual.style.transform = `translateY(${-50 + (scrolled * 0.05)}%) rotate(${scrolled * 0.01}deg)`;
            }
        });

        /**
         * Smooth Navigation for Internal Links
         */
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    window.scrollTo({
                        top: target.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });

        /**
         * Mobile Menu Logic
         */
        // (You can expand this with a full overlay menu)
        const menuToggle = document.getElementById('menuOpen');
        menuToggle.addEventListener('click', () => {
            // Logic for mobile menu expansion
            console.log("Menu Toggled");
        });

        console.log("AutoLoc Elite Framework Initialized...");
    </script>
</body>
</html>