<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>AutoLoc — @yield('title', 'Dashboard')</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
{{-- ❌ SUPPRIME @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
<style>
*{margin:0;padding:0;box-sizing:border-box;}
body{font-family:'DM Sans',sans-serif;background:#0f1117;color:#e8e9f0;min-height:100vh;display:flex;}

/* ── SIDEBAR ── */
.sidebar{width:240px;background:#161820;border-right:1px solid #2a2d3a;display:flex;flex-direction:column;position:fixed;height:100vh;z-index:100;transition:.3s;}
.sidebar-logo{padding:24px 20px;border-bottom:1px solid #2a2d3a;}
.sidebar-logo span{font-family:'Syne',sans-serif;font-size:22px;font-weight:800;color:#fff;letter-spacing:-0.5px;}
.sidebar-logo span em{color:#f59e0b;font-style:normal;}
.sidebar nav{padding:16px 12px;flex:1;overflow-y:auto;}
.nav-label{font-size:10px;color:#555870;text-transform:uppercase;letter-spacing:1px;padding:8px 8px 4px;font-weight:600;}
.nav-item{display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:8px;color:#9496a8;text-decoration:none;font-size:14px;font-weight:500;margin-bottom:2px;transition:all .2s;}
.nav-item:hover{background:#1e2130;color:#fff;}
.nav-item.active{background:#1e2130;color:#f59e0b;}
.nav-icon{width:18px;height:18px;flex-shrink:0;}

/* ── SIDEBAR FOOTER ── */
.sidebar-footer{padding:16px 12px;border-top:1px solid #2a2d3a;}
.user-card{display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:8px;}
.user-avatar{width:34px;height:34px;border-radius:50%;background:#f59e0b;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;color:#0f1117;flex-shrink:0;font-family:'Syne',sans-serif;}
.user-info p{font-size:13px;font-weight:500;color:#e8e9f0;line-height:1.3;}
.user-info span{font-size:11px;color:#555870;text-transform:capitalize;}
.logout-btn{width:100%;padding:8px 12px;background:transparent;border:none;color:#9496a8;font-size:13px;text-align:left;cursor:pointer;border-radius:8px;font-family:'DM Sans',sans-serif;transition:.2s;display:flex;align-items:center;gap:8px;}
.logout-btn:hover{background:#1e2130;color:#f87171;}

/* ── MAIN ── */
.main{margin-left:240px;flex:1;padding:32px;min-height:100vh;}
.page-header{margin-bottom:32px;}
.page-header h1{font-family:'Syne',sans-serif;font-size:26px;font-weight:700;color:#fff;}
.page-header p{color:#9496a8;font-size:14px;margin-top:4px;}

/* ── MOBILE ── */
.mobile-toggle{display:none;position:fixed;top:16px;left:16px;z-index:200;background:#f59e0b;border:none;border-radius:8px;width:40px;height:40px;cursor:pointer;align-items:center;justify-content:center;}
.overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.6);z-index:99;}

/* ── PAGINATION ── */
.pagination{display:flex;gap:6px;list-style:none;flex-wrap:wrap;}
.pagination li a,.pagination li span{padding:6px 12px;background:#161820;border:1px solid #2a2d3a;border-radius:6px;color:#9496a8;text-decoration:none;font-size:13px;display:block;}
.pagination li.active span{background:#f59e0b;color:#0f1117;border-color:#f59e0b;}
.pagination li a:hover{border-color:#f59e0b;color:#f59e0b;}

/* ── RESPONSIVE ── */
@media(max-width:768px){
    .sidebar{transform:translateX(-100%);}
    .sidebar.open{transform:translateX(0);}
    .main{margin-left:0;padding:20px 16px;padding-top:72px;}
    .mobile-toggle{display:flex;}
    .overlay.show{display:block;}
}
</style>
</head>
<body>

<button class="mobile-toggle" onclick="toggleSidebar()">
    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#0f1117" stroke-width="2.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
    </svg>
</button>

<div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

<aside class="sidebar" id="sidebar">
    <div class="sidebar-logo">
        <span>Auto<em>Loc</em></span>
    </div>

    <nav>
        @if(auth()->user()->role === 'admin')
            <div class="nav-label">Menu</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>
            <a href="{{ route('admin.vehicles.index') }}" class="nav-item {{ request()->routeIs('admin.vehicles*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2.8.933M13 16l2.8-.933M13 16H9m4 0h2m2-.933L21 14V9"/></svg>
                Véhicules
            </a>
            <a href="{{ route('admin.rentals.index') }}" class="nav-item {{ request()->routeIs('admin.rentals*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Locations
            </a>
            <a href="{{ route('admin.contracts.index') }}" class="nav-item {{ request()->routeIs('admin.contracts*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Contrats
            </a>
            <a href="{{ route('admin.payments.index') }}" class="nav-item {{ request()->routeIs('admin.payments*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                Paiements
            </a>
            <div class="nav-label" style="margin-top:8px;">Gestion</div>
            <a href="{{ route('admin.clients.index') }}" class="nav-item {{ request()->routeIs('admin.clients*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197"/></svg>
                Clients
            </a>
        @else
            <div class="nav-label">Menu</div>
            <a href="{{ route('client.dashboard') }}" class="nav-item {{ request()->routeIs('client.dashboard') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>
            <a href="{{ route('client.vehicles') }}" class="nav-item {{ request()->routeIs('client.vehicles*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2.8.933M13 16l2.8-.933M13 16H9m4 0h2m2-.933L21 14V9"/></svg>
                Véhicules
            </a>
            <a href="{{ route('client.rentals') }}" class="nav-item {{ request()->routeIs('client.rentals*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Mes Locations
            </a>
            <a href="{{ route('client.contracts') }}" class="nav-item {{ request()->routeIs('client.contracts*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Mes Contrats
            </a>
        @endif
    </nav>

    <div class="sidebar-footer">
        <div class="user-card">
            <div class="user-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>
            <div class="user-info">
                <p>{{ auth()->user()->name }}</p>
                <span>{{ auth()->user()->role }}</span>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Déconnexion
            </button>
        </form>
    </div>
</aside>

<main class="main">
    @yield('content')
</main>

<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('open');
    document.getElementById('overlay').classList.toggle('show');
}
</script>
</body>
</html>