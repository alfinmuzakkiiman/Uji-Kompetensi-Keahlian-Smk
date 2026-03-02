@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1>Daftar Peminjaman Buku</h1>
        <p>Daftar lengkap buku yang kamu pinjam di perpustakaan.</p>
        @if (session('success'))
            <div class="alert alert-success mt-2">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger mt-2">
                {{ session('error') }}
            </div>
        @endif
        <table class="table table-striped table-hover table-bordered mt-3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Peminjam</th>
                    <th>Buku Dipinjam</th>
                    <th>Status</th>
                    <th>Tanggal Peminjaman</th>
                    <th>Tanggal Kembali</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($loans->isEmpty())
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data peminjam buku.</td>
                    </tr>
                @else
                    @foreach ($loans as $loan)
                        <tr>
                            <td>{{ $loop->iteration }}.</td>
                            <td>{{ $loan->user->name }}</td>
                            <td>{{ $loan->book->judul }}</td>
                            <td>{{ ucfirst($loan->status) }}</td>
                            <td>{{ $loan->tanggal_pinjam }}</td>
                            <td>{{ $loan->tanggal_kembali ?? 'Belum Kembali' }}</td>
                            <td>
                                <a href="{{ route('daftar_peminjaman.return_book', $loan->id) }}"
                                    onclick="return confirm('Apakah Anda yakin ingin mengembalikan buku ini?')"
                                    class="btn btn-sm btn-success">Kembalikan</a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
@endsection