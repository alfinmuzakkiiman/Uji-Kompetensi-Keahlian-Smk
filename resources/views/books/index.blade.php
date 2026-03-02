@extends('layouts.app')

@section('content')
<div class="main-content">
    <div class="page-header-wrapper">
        <div class="header-text">
            <h2 class="animate-fade-in">Katalog Koleksi Buku</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb-custom">
                    <li><a href="#"><i class="fas fa-home"></i></a></li>
                    <li><i class="fas fa-chevron-right separator"></i></li>
                    <li class="active">Data Buku</li>
                </ol>
            </nav>
        </div>
        <div class="header-action">
            <a href="{{ route('book.add') }}" class="btn-gradient-glow">
                <div class="btn-content">
                    <i class="fas fa-plus-circle"></i>
                    <span>Tambah Buku Baru</span>
                </div>
            </a>
        </div>
    </div>

    <div class="stats-row">
        <div class="glass-card stat-item">
            <div class="stat-icon purple"><i class="fas fa-book"></i></div>
            <div class="stat-info">
                <span class="label">Total Judul</span>
                <span class="number">{{ $books->count() }}</span>
            </div>
        </div>
        <div class="glass-card stat-item">
            <div class="stat-icon green"><i class="fas fa-check-double"></i></div>
            <div class="stat-info">
                <span class="label">Tersedia</span>
                <span class="number">{{ $books->sum('stok') }}</span>
            </div>
        </div>
        <div class="glass-card stat-item">
            <div class="stat-icon pink"><i class="fas fa-exclamation-circle"></i></div>
            <div class="stat-info">
                <span class="label">Stok Tipis</span>
                <span class="number text-danger">{{ $books->where('stok', '<', 5)->count() }}</span>
            </div>
        </div>
    </div>

    <div class="main-table-card">
        <div class="table-header-flex">
            <h3><i class="fas fa-layer-group"></i> List Inventaris Buku</h3>
            <div class="table-tools">
                <div class="search-box-modern">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Cari berdasarkan judul atau penerbit...">
                </div>
                <button class="btn-icon-only" title="Filter Data"><i class="fas fa-filter"></i></button>
            </div>
        </div>

        @if (session('success'))
            <div class="toast-custom success animate-slide-down">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="table-responsive-custom">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th width="60">No</th>
                        <th>Informasi Buku</th>
                        <th>Penerbit</th>
                        <th class="text-center">Tahun</th>
                        <th class="text-center">Persediaan</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($books as $book)
                        <tr class="row-hover-effect">
                            <td class="text-id">#{{ $loop->iteration }}</td>
                            <td>
                                <div class="book-cell">
                                    <div class="book-avatar">{{ substr($book->judul, 0, 1) }}</div>
                                    <div class="book-meta">
                                        <span class="book-title">{{ $book->judul }}</span>
                                        <small>ISBN: 978-602-{{ 100 + $book->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="penerbit-tag">{{ $book->penerbit }}</span></td>
                            <td class="text-center"><strong>{{ $book->tahun_terbit }}</strong></td>
                            <td class="text-center">
                                <div class="stock-progress-container">
                                    <span class="stock-number">{{ $book->stok }} Pcs</span>
                                    <div class="progress-bar-mini">
                                        <div class="progress-fill {{ $book->stok < 5 ? 'critical' : '' }}" 
                                             style="width: {{ min(($book->stok / 20) * 100, 100) }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="action-pill">
                                    <a href="{{ route('book.edit', $book->id) }}" class="btn-edit" title="Edit Data">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <div class="divider-v"></div>
                                    <a href="{{ route('book.delete', $book->id) }}" 
                                       onclick="return confirm('Hapus buku ini?')" 
                                       class="btn-delete" title="Hapus Data">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-state">
                                <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" alt="Empty">
                                <p>Ops! Katalog buku masih kosong.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* VARIABLES */
    :root {
        --v-purple: #705ec8;
        --v-purple-light: #f0eeff;
        --v-pink: #fb1c52;
        --v-green: #2dce89;
        --text-dark: #1c273c;
        --text-muted: #9ea9bd;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* HEADER UPGRADE */
    .page-header-wrapper { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
    .breadcrumb-custom { display: flex; list-style: none; gap: 10px; align-items: center; font-size: 13px; margin-top: 5px; }
    .breadcrumb-custom .separator { font-size: 8px; color: #cbd4e1; }
    .breadcrumb-custom a { color: var(--v-purple); text-decoration: none; }
    .breadcrumb-custom .active { color: var(--text-muted); }

    /* BTN GRADIENT GLOW */
    .btn-gradient-glow {
        background: linear-gradient(135deg, var(--v-purple), #9384d6);
        padding: 2px; border-radius: 12px; text-decoration: none;
        display: inline-block; box-shadow: 0 10px 20px rgba(112, 94, 200, 0.2);
        transition: var(--transition);
    }
    .btn-gradient-glow .btn-content {
        background: transparent; color: white; padding: 12px 25px;
        border-radius: 10px; display: flex; align-items: center; gap: 10px; font-weight: 600;
    }
    .btn-gradient-glow:hover { transform: translateY(-3px); box-shadow: 0 15px 30px rgba(112, 94, 200, 0.4); }

    /* SMART STATS */
    .stats-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px; }
    .glass-card { background: white; padding: 20px; border-radius: 15px; border: 1px solid rgba(255,255,255,0.7); box-shadow: 0 10px 25px rgba(0,0,0,0.03); display: flex; align-items: center; gap: 15px; }
    .stat-icon { width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; }
    .stat-icon.purple { background: var(--v-purple-light); color: var(--v-purple); }
    .stat-icon.green { background: #e6f9f0; color: var(--v-green); }
    .stat-icon.pink { background: #fff0f4; color: var(--v-pink); }
    .stat-info .number { display: block; font-size: 24px; font-weight: 700; color: var(--text-dark); }
    .stat-info .label { font-size: 13px; color: var(--text-muted); }

    /* TABLE MODERN */
    .main-table-card { background: white; border-radius: 20px; padding: 25px; box-shadow: 0 15px 35px rgba(168, 180, 208, 0.1); }
    .table-header-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
    .search-box-modern { position: relative; }
    .search-box-modern i { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted); }
    .search-box-modern input { padding: 10px 20px 10px 45px; border-radius: 10px; border: 1px solid #ebedf4; width: 300px; outline: none; transition: var(--transition); }
    .search-box-modern input:focus { border-color: var(--v-purple); box-shadow: 0 0 0 4px rgba(112, 94, 200, 0.1); width: 350px; }

    .table-modern { width: 100%; border-collapse: separate; border-spacing: 0 8px; }
    .table-modern th { padding: 15px; color: var(--text-muted); font-size: 12px; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #f2f4f9; }
    .table-modern td { padding: 15px; background: white; border-top: 1px solid #f8f9fb; border-bottom: 1px solid #f8f9fb; }
    .table-modern td:first-child { border-left: 1px solid #f8f9fb; border-top-left-radius: 12px; border-bottom-left-radius: 12px; }
    .table-modern td:last-child { border-right: 1px solid #f8f9fb; border-top-right-radius: 12px; border-bottom-right-radius: 12px; }

    .row-hover-effect:hover td { background: #fcfcff; transform: scale(1.005); transition: var(--transition); }

    .book-cell { display: flex; align-items: center; gap: 12px; }
    .book-avatar { width: 40px; height: 40px; background: var(--v-purple); color: white; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 700; }
    .book-title { display: block; font-weight: 600; color: var(--text-dark); }
    .penerbit-tag { background: #f0f2f9; padding: 4px 12px; border-radius: 6px; font-size: 12px; color: #50555a; }

    /* STOCK BAR */
    .stock-progress-container { width: 100px; margin: 0 auto; }
    .progress-bar-mini { height: 6px; background: #eee; border-radius: 10px; margin-top: 5px; overflow: hidden; }
    .progress-fill { height: 100%; background: var(--v-green); border-radius: 10px; }
    .progress-fill.critical { background: var(--v-pink); }

    /* ACTION PILL */
    .action-pill { background: #f8f9fb; border-radius: 10px; display: flex; align-items: center; justify-content: space-around; padding: 5px; }
    .action-pill a { padding: 8px 12px; border-radius: 8px; transition: var(--transition); }
    .btn-edit { color: var(--v-purple); }
    .btn-edit:hover { background: var(--v-purple); color: white; }
    .btn-delete { color: var(--v-pink); }
    .btn-delete:hover { background: var(--v-pink); color: white; }
    .divider-v { width: 1px; height: 20px; background: #ebedf4; }

    /* ANIMATIONS */
    .animate-fade-in { animation: fadeIn 0.8s ease; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endsection