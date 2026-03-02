@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1>Edit User</h1>
        <div class="d-flex justify-content-between">
            <p>Form untuk mengedit data user.</p>
            <a href="{{ route('user.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
        <form action="{{ route('user.update', $user->id) }}" method="post">
            @csrf
           <div class="mb-3">
                <label for="name" class="form-label">Nama User</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
                <small>Biarkan kosong jika tidak ingin mengubah password</small>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select class="form-select" id="role" name="role" required>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
@endsection