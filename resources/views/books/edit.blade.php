@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1>Edit Buku</h1>
        <div class="d-flex justify-content-between">
            <p>Form untuk mengedit data buku.</p>
            <a href="{{ route('book.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
        <form action="{{ route('book.update', $book->id) }}" method="post">
            @csrf
            <div class="mb-3">
                <label for="judul" class="form-label">Judul Buku</label>
                <input type="text" class="form-control" id="judul" name="judul" value="{{ $book->judul }}" required>
            </div>
            <div class="mb-3">
                <label for="penerbit" class="form-label">Penerbit</label>
                <input type="text" class="form-control" id="penerbit" name="penerbit" value="{{ $book->penerbit }}" required>
            </div>
            <div class="mb-3">
                <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                <input type="number" class="form-control" id="tahun_terbit" name="tahun_terbit" value="{{ $book->tahun_terbit }}" required>
            </div>
            <div class="mb-3">
                <label for="stok" class="form-label">Stok</label>
                <input type="number" class="form-control" id="stok" name="stok" value="{{ $book->stok }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>F
@endsection