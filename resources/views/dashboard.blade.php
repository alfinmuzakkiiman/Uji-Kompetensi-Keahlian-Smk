@extends('layouts.app')

@section('content')
<div class="main-content-inner animate-fade-in">
    <div class="dash-header-flat">
        <div class="header-left">
            <h1 class="header-title">Overview <span class="dot-active"></span></h1>
            <p class="header-subtitle">Selamat datang di pusat kendali, {{ auth()->user()->name }}.</p>
        </div>
        <div class="header-right">
            <div class="live-clock-card">
                <span id="live-time">00:00</span>
                <span class="live-indicator">LIVE</span>
            </div>
        </div>
    </div>

    <div class="stats-sleek-grid">
        @php
            $data = auth()->user()->role == 'admin' 
                ? [
                    ['label' => 'Total Koleksi', 'val' => $totalBuku, 'icon' => 'fa-book', 'color' => '#705ec8', 'bg' => '#f4f2ff'],
                    ['label' => 'Member Aktif', 'val' => $totalUser, 'icon' => 'fa-users', 'color' => '#01b8ff', 'bg' => '#e6f8ff'],
                    ['label' => 'Transaksi Baru', 'val' => $peminjamanHariIni, 'icon' => 'fa-arrow-up', 'color' => '#fb1c52', 'bg' => '#fff0f4']
                  ]
                : [
                    ['label' => 'Buku Tersedia', 'val' => $totalBuku, 'icon' => 'fa-search', 'color' => '#705ec8', 'bg' => '#f4f2ff'],
                    ['label' => 'Dipinjam', 'val' => $dipinjam, 'icon' => 'fa-clock', 'color' => '#fb1c52', 'bg' => '#fff0f4'],
                    ['label' => 'Total Selesai', 'val' => $riwayat, 'icon' => 'fa-check-circle', 'color' => '#2dce89', 'bg' => '#e6f9f0']
                  ];
        @endphp

        @foreach($data as $d)
        <div class="sleek-card">
            <div class="sleek-card-body">
                <div class="icon-circle" style="background: {{ $d['bg'] }}; color: {{ $d['color'] }}">
                    <i class="fas {{ $d['icon'] }}"></i>
                </div>
                <div class="sleek-info">
                    <span class="sleek-label">{{ $d['label'] }}</span>
                    <h2 class="sleek-number">{{ $d['val'] }}</h2>
                </div>
            </div>
            <div class="sleek-progress">
                <div class="progress-fill" style="background: {{ $d['color'] }}; width: 65%;"></div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="dash-body-grid">
        <div class="main-panel-glass">
            <div class="panel-top">
                <h3>Aktivitas Sistem</h3>
                <button class="btn-minimal">Filter <i class="fas fa-chevron-down"></i></button>
            </div>
            <div class="activity-timeline">
                <div class="timeline-box">
                    <div class="t-line"></div>
                    <div class="t-item">
                        <div class="t-dot" style="border-color: #705ec8"></div>
                        <div class="t-content">
                            <strong>Sinkronisasi Data Buku</strong>
                            <p>Katalog buku fiksi diperbarui oleh sistem.</p>
                            <span class="t-time">Baru saja</span>
                        </div>
                    </div>
                    <div class="t-item">
                        <div class="t-dot" style="border-color: #fb1c52"></div>
                        <div class="t-content">
                            <strong>Notifikasi Pengembalian</strong>
                            <p>3 Buku melewati batas waktu peminjaman.</p>
                            <span class="t-time">1 jam yang lalu</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="side-panel-glass">
            <div class="card-identity">
                <div class="id-header">
                    <i class="fas fa-shield-alt text-purple"></i>
                    <span>Access Level</span>
                </div>
                <h4 class="id-role">{{ auth()->user()->role == 'admin' ? 'Root Administrator' : 'Student Member' }}</h4>
                <div class="id-footer">
                    <span class="status-badge">Active Connection</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* TYPOGRAPHY & HEADER */
    .dash-header-flat { display: flex; justify-content: space-between; align-items: center; margin-bottom: 35px; }
    .header-title { font-size: 32px; font-weight: 800; color: #1a1a1a; letter-spacing: -1px; display: flex; align-items: center; gap: 10px; }
    .dot-active { width: 10px; height: 10px; background: #2dce89; border-radius: 50%; display: inline-block; box-shadow: 0 0 10px #2dce89; }
    .header-subtitle { color: #94a3b8; font-size: 15px; margin-top: 2px; }

    .live-clock-card { background: #fff; padding: 10px 20px; border-radius: 12px; border: 1px solid #e2e8f0; display: flex; align-items: center; gap: 12px; font-weight: 700; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); }
    .live-indicator { font-size: 10px; color: #fb1c52; background: #fff1f2; padding: 2px 8px; border-radius: 4px; animation: pulse 1.5s infinite; }
    @keyframes pulse { 0% { opacity: 1; } 50% { opacity: 0.4; } 100% { opacity: 1; } }

    /* SLEEK STATS CARDS */
    .stats-sleek-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; }
    .sleek-card { background: #fff; border-radius: 20px; border: 1px solid #e2e8f0; padding: 25px; transition: all 0.3s ease; position: relative; overflow: hidden; }
    .sleek-card:hover { transform: translateY(-5px); border-color: #cbd5e1; box-shadow: 0 12px 24px -10px rgba(0,0,0,0.1); }
    
    .sleek-card-body { display: flex; align-items: center; gap: 20px; }
    .icon-circle { width: 56px; height: 56px; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 20px; }
    .sleek-label { font-size: 13px; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; }
    .sleek-number { font-size: 30px; font-weight: 800; color: #0f172a; margin-top: 4px; }

    .sleek-progress { position: absolute; bottom: 0; left: 0; width: 100%; height: 4px; background: #f1f5f9; }
    .progress-fill { height: 100%; transition: width 1s ease-in-out; }

    /* DASH BODY */
    .dash-body-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 25px; margin-top: 30px; }
    .main-panel-glass, .side-panel-glass { background: #fff; border-radius: 24px; border: 1px solid #e2e8f0; padding: 30px; }
    .panel-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
    .panel-top h3 { font-size: 18px; font-weight: 700; color: #0f172a; }
    .btn-minimal { background: #f8fafc; border: 1px solid #e2e8f0; padding: 8px 16px; border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer; }

    /* TIMELINE */
    .timeline-box { position: relative; padding-left: 20px; }
    .t-line { position: absolute; left: 0; top: 5px; width: 2px; height: 100%; background: #f1f5f9; }
    .t-item { position: relative; padding-bottom: 25px; }
    .t-dot { position: absolute; left: -24px; top: 5px; width: 10px; height: 10px; background: #fff; border: 2.5px solid; border-radius: 50%; z-index: 2; }
    .t-content strong { display: block; font-size: 14px; color: #334155; }
    .t-content p { font-size: 13px; color: #64748b; margin: 4px 0; }
    .t-time { font-size: 11px; color: #94a3b8; font-weight: 500; }

    /* SIDE CARD */
    .card-identity { background: #0f172a; border-radius: 20px; padding: 25px; color: white; }
    .id-header { display: flex; align-items: center; gap: 10px; font-size: 12px; font-weight: 600; color: #94a3b8; }
    .id-role { font-size: 20px; font-weight: 700; margin: 15px 0; background: linear-gradient(to right, #fff, #94a3b8); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    .status-badge { font-size: 11px; color: #2dce89; background: rgba(45, 206, 137, 0.1); padding: 4px 12px; border-radius: 50px; border: 1px solid rgba(45, 206, 137, 0.2); }

    @media (max-width: 992px) { .dash-body-grid { grid-template-columns: 1fr; } }
</style>

<script>
    function updateTime() {
        const now = new Date();
        const timeStr = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
        document.getElementById('live-time').textContent = timeStr;
    }
    setInterval(updateTime, 1000);
    updateTime();
</script>
@endsection