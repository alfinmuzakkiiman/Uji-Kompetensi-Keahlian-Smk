@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1>Edit Peminjam Buku</h1>
        <div class="d-flex justify-content-between">
            <p>Edit data peminjam buku.</p>
            <a href="{{ route('loan.index') }}" class="btn btn-secondary">Kembali</a>
        </div>

        <form action="{{ route('loan.update', $loan->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="peminjam" class="form-label">Peminjam</label>
                <select name="peminjam" id="peminjam" class="form-control" required>
                    <option value="" disabled selected>-- Pilih Peminjam --</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $loan->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="buku" class="form-label">Buku</label>
                <select name="buku" id="buku" class="form-control" required>
                    <option value="" disabled selected>-- Pilih Buku --</option>
                    @foreach ($books as $book)
                        <option value="{{ $book->id }}" {{ $loan->book_id == $book->id ? 'selected' : '' }}>{{ $book->judul . " | " . $book->penerbit  . " | Stok: " . $book->stok}}</option>
                    @endforeach 
                </select>
            </div>
            <div class="mb-3">
                <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam" value="{{ $loan->tanggal_pinjam }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
@endsection