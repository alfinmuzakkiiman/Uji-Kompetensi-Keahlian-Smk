@extends('layouts.app')

@section('content')
<div class="main-content">
    <div class="page-header-wrapper">
        <div class="header-text">
            <h2 class="animate-fade-in">Manajemen Pengguna</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb-custom">
                    <li><a href="#"><i class="fas fa-home"></i></a></li>
                    <li><i class="fas fa-chevron-right separator"></i></li>
                    <li class="active">Data User</li>
                </ol>
            </nav>
        </div>
        <div class="header-action">
            <a href="{{ route('user.add') }}" class="btn-gradient-glow">
                <div class="btn-content">
                    <i class="fas fa-user-plus"></i>
                    <span>Tambah User Baru</span>
                </div>
            </a>
        </div>
    </div>

    <div class="stats-row">
        <div class="glass-card stat-item">
            <div class="stat-icon purple"><i class="fas fa-users"></i></div>
            <div class="stat-info">
                <span class="label">Total Pengguna</span>
                <span class="number">{{ $users->count() }}</span>
            </div>
        </div>
        <div class="glass-card stat-item">
            <div class="stat-icon blue"><i class="fas fa-user-shield"></i></div>
            <div class="stat-info">
                <span class="label">Administrator</span>
                <span class="number">{{ $users->where('role', 'admin')->count() }}</span>
            </div>
        </div>
        <div class="glass-card stat-item">
            <div class="stat-icon green"><i class="fas fa-user-tie"></i></div>
            <div class="stat-info">
                <span class="label">Petugas</span>
                <span class="number">{{ $users->where('role', 'petugas')->count() }}</span>
            </div>
        </div>
    </div>

    <div class="main-table-card">
        <div class="table-header-flex">
            <h3><i class="fas fa-id-card"></i> Daftar Anggota Tim</h3>
            <div class="table-tools">
                <div class="search-box-modern">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Cari nama atau email...">
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
                        <th width="60">No</th>
                        <th>User Profil</th>
                        <th>Email Address</th>
                        <th class="text-center">Role Akses</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="row-hover-effect">
                            <td class="text-id">#{{ $loop->iteration }}</td>
                            <td>
                                <div class="user-cell">
                                    <div class="user-avatar-circle">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <div class="user-meta">
                                        <span class="user-name">{{ $user->name }}</span>
                                        <small class="text-muted">UID: {{ 1000 + $user->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="email-wrapper">
                                    <i class="far fa-envelope"></i> {{ $user->email }}
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="role-badge {{ $user->role == 'admin' ? 'role-admin' : 'role-staff' }}">
                                    <i class="fas {{ $user->role == 'admin' ? 'fa-shield-alt' : 'fa-user' }}"></i>
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>
                                <div class="action-pill">
                                    <a href="{{ route('user.edit', $user->id) }}" class="btn-edit" title="Edit User">
                                        <i class="fas fa-user-edit"></i>
                                    </a>
                                    <div class="divider-v"></div>
                                    <a href="{{ route('user.delete', $user->id) }}" 
                                       onclick="return confirm('Hapus user ini secara permanen?')" 
                                       class="btn-delete" title="Hapus User">
                                        <i class="fas fa-user-times"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-state">
                                <i class="fas fa-users-slash" style="font-size: 40px; color: #cbd4e1;"></i>
                                <p>Tidak ada data user yang ditemukan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* CSS REUSE DARI BOOK INDEX DENGAN PENYESUAIAN USER */
    .user-cell { display: flex; align-items: center; gap: 15px; }
    
    .user-avatar-circle {
        width: 45px; height: 45px;
        background: linear-gradient(135deg, var(--v-purple), #9384d6);
        color: white; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 14px;
        box-shadow: 0 4px 10px rgba(112, 94, 200, 0.2);
    }

    .user-name { display: block; font-weight: 600; color: var(--text-dark); font-size: 15px; }
    
    .email-wrapper { color: var(--text-muted); font-size: 14px; display: flex; align-items: center; gap: 8px; }

    /* ROLE BADGES */
    .role-badge {
        padding: 6px 14px; border-radius: 20px; font-size: 11px; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.5px; display: inline-flex; align-items: center; gap: 6px;
    }
    .role-admin { background: #f0eeff; color: var(--v-purple); border: 1px solid #dcd7f9; }
    .role-staff { background: #e6f9f0; color: var(--v-green); border: 1px solid #c3f2db; }

    /* REUSE STYLES DARI HALAMAN BUKU SEBELUMNYA */
    :root {
        --v-purple: #705ec8;
        --v-blue: #01b8ff;
        --v-green: #2dce89;
        --v-pink: #fb1c52;
        --text-dark: #1c273c;
        --text-muted: #9ea9bd;
    }

    .page-header-wrapper { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
    .breadcrumb-custom { display: flex; list-style: none; gap: 10px; align-items: center; font-size: 13px; margin: 0; padding: 0;}
    .breadcrumb-custom .separator { font-size: 8px; color: #cbd4e1; }
    
    .btn-gradient-glow {
        background: linear-gradient(135deg, var(--v-purple), #9384d6);
        padding: 2px; border-radius: 12px; text-decoration: none; display: inline-block;
    }
    .btn-gradient-glow .btn-content {
        background: transparent; color: white; padding: 12px 25px; border-radius: 10px;
        display: flex; align-items: center; gap: 10px; font-weight: 600;
    }

    .stats-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px; }
    .glass-card { background: white; padding: 20px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.03); display: flex; align-items: center; gap: 15px; }
    .stat-icon { width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; }
    .stat-icon.purple { background: #f0eeff; color: var(--v-purple); }
    .stat-icon.blue { background: #e0f7ff; color: var(--v-blue); }
    .stat-icon.green { background: #e6f9f0; color: var(--v-green); }

    .main-table-card { background: white; border-radius: 20px; padding: 25px; box-shadow: 0 15px 35px rgba(168, 180, 208, 0.1); }
    .table-modern { width: 100%; border-collapse: separate; border-spacing: 0 8px; }
    .table-modern th { padding: 15px; color: var(--text-muted); font-size: 12px; text-transform: uppercase; border-bottom: 1px solid #f2f4f9; }
    .table-modern td { padding: 15px; background: white; border-top: 1px solid #f8f9fb; border-bottom: 1px solid #f8f9fb; }
    
    .action-pill { background: #f8f9fb; border-radius: 10px; display: flex; align-items: center; justify-content: space-around; padding: 5px; }
    .btn-edit { color: var(--v-purple); text-decoration: none; padding: 8px; }
    .btn-delete { color: var(--v-pink); text-decoration: none; padding: 8px; }
    .divider-v { width: 1px; height: 20px; background: #ebedf4; }

    .toast-custom.success {
        background: #e6f9f0; border-left: 4px solid var(--v-green);
        padding: 15px; color: #1e7e51; margin-bottom: 20px; border-radius: 4px;
        display: flex; align-items: center; gap: 10px;
    }
</style>
@endsection