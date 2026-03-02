@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1>Input Peminjaman Buku</h1>
        <div class="d-flex justify-content-between">
            <p>Form peminjaman buku baru.</p>
            <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">Kembali</a>
        </div>

        <form action="{{ route('peminjaman.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="book_id" class="form-label">Judul Buku</label>
                <input type="text" class="form-control" id="book_id" name="book_id" value="{{ $book->judul }}" readonly>
                <input type="hidden" name="book_id" value="{{ $book->id }}">
            </div> 
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Peminjam</label>
                <input type="text" class="form-control" id="nama" name="nama" value="{{ auth()->user()->name }}" readonly>
            </div>
            <div class="mb-3">
                <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam" required>
            </div>
            <button type="submit" class="btn btn-primary">Pinjam</button>
        </form>
    </div>
@endsection