<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Perpustakaan</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Saira:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --v-purple: #705ec8;
            --v-pink: #fb1c52;
            --v-green: #2dce89;
            --v-blue: #01b8ff;
            --bg-gray: #f2f2f9;
            --text-main: #2b313c;
            --text-muted: #9ea9bd;
            --sidebar-width: 270px;
        }

        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Saira', sans-serif; background:var(--bg-gray); display:flex; color:var(--text-main); min-height: 100vh; }

        /* SIDEBAR STYLE */
        .sidebar { width:var(--sidebar-width); background:#fff; height:100vh; border-right:1px solid #ebedf4; position:sticky; top:0; overflow-y:auto; z-index: 1000; }
        .brand-section { padding:25px; border-bottom: 1px solid #f2f4f9; }
        .brand-logo { font-size:24px; font-weight:700; display:flex; align-items:center; gap:12px; color: var(--text-main); }
        .brand-logo i { color:var(--v-purple); filter: drop-shadow(0 2px 4px rgba(112, 94, 200, 0.3)); }

        .user-profile { text-align:center; padding:25px 0; border-bottom:1px solid #f2f4f9; background: linear-gradient(to bottom, #fff, #fafaff); }
        .avatar {
            width:75px; height:75px; border-radius:50%;
            background: linear-gradient(135deg, var(--v-purple), #9384d6);
            color:#fff; font-weight:700; font-size:24px;
            display:flex; align-items:center; justify-content:center;
            margin:0 auto 12px; box-shadow: 0 8px 15px rgba(112, 94, 200, 0.2);
        }
        .user-profile h4 { font-size:16px; font-weight:700; color: var(--text-main); }
        .user-profile p { font-size:12px; color:var(--text-muted); font-weight: 500; }

        .menu-label { padding:20px 25px 10px; font-size:11px; font-weight:700; color:#cbd4e1; text-transform:uppercase; letter-spacing: 1px; }
        .nav-item { display:flex; align-items:center; padding:14px 25px; color:#50555a; text-decoration:none; font-size:14px; transition: 0.3s; font-weight: 500; }
        .nav-item:hover { background: #f8f9fb; color: var(--v-purple); }
        .nav-item.active { background:#f0f2f9; color:var(--v-purple); font-weight:700; border-right: 3px solid var(--v-purple); }
        .nav-item i { width:25px; margin-right:12px; font-size: 16px; }

        .btn-logout { border: none; background: none; width: 100%; cursor: pointer; text-align: left; font-family: inherit; color: var(--v-pink); }
        .btn-logout:hover { background: #fff0f4; }

        /* MAIN CONTENT AREA */
        .main-content { flex:1; padding:30px; overflow-x: hidden; }

        /* DESAIN KOMPONEN GLOBAL (SINKRON DENGAN CONTENT) */
        .page-header-wrapper { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .header-text h2 { font-size: 26px; font-weight: 800; color: var(--text-main); }
        
        .breadcrumb-custom { display: flex; list-style: none; gap: 10px; font-size: 13px; margin-top: 5px; }
        .breadcrumb-custom a { color: var(--v-purple); text-decoration: none; font-weight: 600; }
        .separator { color: #cbd4e1; font-size: 10px; }

        .btn-gradient-glow { 
            background: linear-gradient(135deg, var(--v-purple), #9384d6); 
            border-radius: 12px; padding: 2px; text-decoration: none; display: inline-block;
            box-shadow: 0 4px 15px rgba(112, 94, 200, 0.3); transition: 0.3s;
        }
        .btn-gradient-glow:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(112, 94, 200, 0.4); }
        .btn-content { color: white; padding: 10px 22px; display: flex; align-items: center; gap: 10px; font-weight: 600; }

        /* GLOBAL ANIMATIONS */
        .animate-fade-in { animation: fadeIn 0.5s ease; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

    </style>
</head>

<body>

@if(auth()->check())
<div class="sidebar">
    <div class="brand-section">
        <div class="brand-logo"><i class="fas fa-book-open"></i> Perpustakaan</div>
    </div>

    <div class="user-profile">
        <div class="avatar">
            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
        </div>
        <h4>{{ auth()->user()->name }}</h4>
        <p>{{ auth()->user()->role == 'admin' ? 'Administrator' : 'Siswa / User' }}</p>
    </div>

    <div class="menu-label">Navigasi Utama</div>

    @if(auth()->user()->role == 'admin')
        <a href="{{ route('dashboard') }}" class="nav-item {{ Request::is('dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-line"></i> Dashboard
        </a>
        <a href="{{ route('book.index') }}" class="nav-item {{ Request::is('book*') ? 'active' : '' }}">
            <i class="fas fa-book"></i> Data Buku
        </a>
        <a href="{{ route('user.index') }}" class="nav-item {{ Request::is('user*') ? 'active' : '' }}">
            <i class="fas fa-user-graduate"></i> Data User
        </a>
        <a href="{{ route('loan.index') }}" class="nav-item {{ Request::is('loan*') ? 'active' : '' }}">
            <i class="fas fa-hand-holding"></i> Peminjaman
        </a>
    @else
        <a href="{{ route('dashboard') }}" class="nav-item {{ Request::is('dashboard') ? 'active' : '' }}">
            <i class="fas fa-home"></i> Dashboard
        </a>
        <a href="{{ route('peminjaman.index') }}" class="nav-item">
            <i class="fas fa-search"></i> Daftar Buku
        </a>
        <a href="{{ route('daftar_peminjaman.index') }}" class="nav-item">
            <i class="fas fa-history"></i> Riwayat Saya
        </a>
    @endif

    <div class="menu-label">Akun</div>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="nav-item btn-logout">
            <i class="fas fa-sign-out-alt"></i> Logout
        </button>
    </form>
</div>
@endif

<div class="main-content">
    @yield('content')
</div>

</body>
</html>