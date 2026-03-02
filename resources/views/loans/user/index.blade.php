@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1>Peminjaman Buku</h1>
        <p>Daftar buku perpustakaan.</p>
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
        <div class="row">
            @foreach ($books as $book)
                <div class="col-md-3 mb-3">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body bg-light">
                            <h5 class="card-title">{{ $book->judul }}</h5>
                            <h6 class="card-subtitle mb-2 text-body-secondary">{{ $book->penerbit }}</h6>
                            <p class="card-text">
                                Tahun Terbit: {{ $book->tahun_terbit }}<br>
                                Stok: {{ $book->stok }}
                            </p>
                            @if ($book->stok > 0)
                            <a href="{{ route('peminjaman.pinjam', $book->id) }}" class="btn btn-sm btn-primary">Pinjam Buku</a>
                            @else
                            <button class="btn btn-sm btn-secondary" disabled>Stok Habis</button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection