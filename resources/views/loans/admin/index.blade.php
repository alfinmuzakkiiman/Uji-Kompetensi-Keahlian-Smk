@extends('layouts.app')

@section('content')
<div class="main-content">
    <div class="page-header-wrapper">
        <div class="header-text">
            <h2 class="animate-fade-in">Transaksi Peminjaman</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb-custom">
                    <li><a href="#"><i class="fas fa-home"></i></a></li>
                    <li><i class="fas fa-chevron-right separator"></i></li>
                    <li class="active">Peminjaman</li>
                </ol>
            </nav>
        </div>
        <div class="header-action">
            <a href="{{ route('loan.add') }}" class="btn-gradient-glow">
                <div class="btn-content">
                    <i class="fas fa-hand-holding"></i>
                    <span>Tambah Peminjaman</span>
                </div>
            </a>
        </div>
    </div>

    <div class="stats-row">
        <div class="glass-card stat-item">
            <div class="stat-icon purple"><i class="fas fa-exchange-alt"></i></div>
            <div class="stat-info">
                <span class="label">Total Transaksi</span>
                <span class="number">{{ $loans->count() }}</span>
            </div>
        </div>
        <div class="glass-card stat-item">
            <div class="stat-icon pink"><i class="fas fa-clock"></i></div>
            <div class="stat-info">
                <span class="label">Sedang Dipinjam</span>
                <span class="number">{{ $loans->where('status', 'dipinjam')->count() }}</span>
            </div>
        </div>
        <div class="glass-card stat-item">
            <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
            <div class="stat-info">
                <span class="label">Sudah Kembali</span>
                <span class="number">{{ $loans->where('status', 'kembali')->count() }}</span>
            </div>
        </div>
    </div>

    <div class="main-table-card">
        <div class="table-header-flex">
            <h3><i class="fas fa-history"></i> Log Peminjaman Buku</h3>
            <div class="table-tools">
                <div class="search-box-modern">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Cari nama peminjam atau buku...">
                </div>
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
                        <th width="50">#</th>
                        <th>Peminjam & Buku</th>
                        <th class="text-center">Status</th>
                        <th>Waktu Pinjam</th>
                        <th>Estimasi Kembali</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($loans as $loan)
                        <tr class="row-hover-effect">
                            <td><span class="text-id">{{ $loop->iteration }}</span></td>
                            <td>
                                <div class="loan-info">
                                    <div class="borrower-name">{{ $loan->user->name }}</div>
                                    <div class="book-title-sub"><i class="fas fa-book-reader"></i> {{ $loan->book->judul }}</div>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge-status {{ $loan->status == 'dipinjam' ? 'st-borrowed' : 'st-returned' }}">
                                    {{ ucfirst($loan->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="date-cell">
                                    <i class="far fa-calendar-alt text-purple"></i>
                                    <span>{{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d M Y') }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="date-cell">
                                    @if($loan->tanggal_kembali)
                                        <i class="far fa-calendar-check text-green"></i>
                                        <span>{{ \Carbon\Carbon::parse($loan->tanggal_kembali)->format('d M Y') }}</span>
                                    @else
                                        <span class="text-muted italic">Belum Kembali</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="action-pill">
                                    @if($loan->status == 'dipinjam')
                                    <a href="{{ route('loan.return_book', $loan->id) }}" 
                                       onclick="return confirm('Proses pengembalian buku ini?')" 
                                       class="btn-return" title="Kembalikan">
                                        <i class="fas fa-undo"></i>
                                    </a>
                                    <div class="divider-v"></div>
                                    @endif
                                    <a href="{{ route('loan.edit', $loan->id) }}" class="btn-edit" title="Edit Transaksi">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <div class="divider-v"></div>
                                    <a href="{{ route('loan.delete', $loan->id) }}" 
                                       onclick="return confirm('Hapus data ini?')" 
                                       class="btn-delete" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-state text-center py-5">
                                <i class="fas fa-folder-open fa-3x mb-3" style="color: #cbd4e1;"></i>
                                <p class="text-muted">Tidak ada riwayat peminjaman.</p>
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
        --v-green: #2dce89;
        --v-pink: #fb1c52;
        --text-dark: #1c273c;
        --text-muted: #9ea9bd;
    }

    .main-content { padding: 25px; }

    /* HEADER & BREADCRUMB */
    .page-header-wrapper { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
    .breadcrumb-custom { display: flex; list-style: none; gap: 10px; font-size: 13px; padding: 0; margin: 0; }
    .breadcrumb-custom a { color: var(--v-purple); text-decoration: none; }
    .separator { font-size: 10px; color: #cbd4e1; }

    /* BUTTONS */
    .btn-gradient-glow { 
        background: linear-gradient(135deg, var(--v-purple), #9384d6); 
        border-radius: 12px; padding: 2px; text-decoration: none; display: inline-block;
        box-shadow: 0 4px 15px rgba(112, 94, 200, 0.3);
    }
    .btn-content { color: white; padding: 10px 20px; display: flex; align-items: center; gap: 10px; font-weight: 600; }

    /* STATS CARDS */
    .stats-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
    .glass-card { background: white; padding: 20px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.03); display: flex; align-items: center; gap: 15px; border: 1px solid #f0f2f5; }
    .stat-icon { width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; }
    .stat-icon.purple { background: #f0eeff; color: var(--v-purple); }
    .stat-icon.pink { background: #fff0f4; color: var(--v-pink); }
    .stat-icon.green { background: #e6f9f0; color: var(--v-green); }
    .stat-info .label { display: block; font-size: 12px; color: var(--text-muted); font-weight: 600; }
    .stat-info .number { font-size: 20px; font-weight: 800; color: var(--text-dark); }

    /* TABLE STYLES */
    .main-table-card { background: white; border-radius: 20px; padding: 25px; box-shadow: 0 15px 35px rgba(0,0,0,0.05); }
    .table-header-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .search-box-modern { position: relative; }
    .search-box-modern i { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted); }
    .search-box-modern input { padding: 10px 15px 10px 40px; border-radius: 10px; border: 1px solid #ebedf4; background: #f8f9fb; width: 250px; outline: none; }

    .table-modern { width: 100%; border-collapse: separate; border-spacing: 0 10px; }
    .table-modern th { color: var(--text-muted); font-size: 12px; text-transform: uppercase; padding: 10px; border-bottom: 1px solid #eee; font-weight: 700; }
    .table-modern td { padding: 15px; background: white; border-top: 1px solid #f8f9fb; border-bottom: 1px solid #f8f9fb; vertical-align: middle; }
    
    .borrower-name { font-weight: 700; color: var(--text-dark); font-size: 14px; }
    .book-title-sub { font-size: 12px; color: var(--v-purple); margin-top: 3px; font-weight: 500; }
    
    .badge-status { padding: 5px 12px; border-radius: 6px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
    .st-borrowed { background: #fff0f4; color: var(--v-pink); border: 1px solid #ffd1dc; }
    .st-returned { background: #e6f9f0; color: var(--v-green); border: 1px solid #c3f2db; }

    .date-cell { display: flex; align-items: center; gap: 8px; font-size: 13px; color: #50555a; }
    .text-purple { color: var(--v-purple); }
    .text-green { color: var(--v-green); }
    .italic { font-style: italic; font-size: 12px; }

    /* ACTIONS */
    .action-pill { background: #f8f9fb; border-radius: 10px; display: flex; align-items: center; padding: 5px; gap: 5px; justify-content: center; }
    .divider-v { width: 1px; height: 15px; background: #ddd; }
    .btn-edit, .btn-delete, .btn-return { text-decoration: none; padding: 8px; transition: 0.3s; display: flex; align-items: center; }
    .btn-return { color: var(--v-green); }
    .btn-return:hover { background: var(--v-green); color: white; border-radius: 8px; }
    .btn-edit { color: var(--v-purple); }
    .btn-delete { color: var(--v-pink); }

    /* TOAST */
    .toast-custom.success { background: #e6f9f0; border-left: 4px solid var(--v-green); padding: 15px; color: #1e7e51; margin-bottom: 20px; border-radius: 4px; display: flex; align-items: center; gap: 10px; }
</style>
@endsection