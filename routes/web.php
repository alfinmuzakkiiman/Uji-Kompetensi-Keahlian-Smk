<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layouts.app');
});

//Route untuk page

Route::group(['middleware' => ['guest']], function () {
    Route::get('/login', [App\Http\Controllers\PageController::class, 'login'])->name('login');
    Route::post('/authenticate', [App\Http\Controllers\PageController::class, 'authenticate'])->name('authenticate');
});

Route::group(['middleware'=> ['auth']], function () {
    Route::get('/dashboard', [App\Http\Controllers\PageController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [App\Http\Controllers\PageController::class, 'logout'])->name('logout');
});

Route::group(['middleware' => ['auth','roles:admin']], function () {
    //Route untuk user
    Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
    Route::get('/users/add', [App\Http\Controllers\UserController::class, 'add'])->name('user.add');
    Route::post('/users/store', [App\Http\Controllers\UserController::class, 'store'])->name('user.store');
    Route::get('/users/edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');
    Route::post('/users/update/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');
    Route::get('/users/delete/{id}', [App\Http\Controllers\UserController::class, 'delete'])->name('user.delete');

    //Route untuk buku
    Route::get('/books', [App\Http\Controllers\BookController::class, 'index'])->name('book.index');
    Route::get('/books/add', [App\Http\Controllers\BookController::class, 'add'])->name('book.add');
    Route::post('/books/store', [App\Http\Controllers\BookController::class, 'store'])->name('book.store');
    Route::get('/books/edit/{id}', [App\Http\Controllers\BookController::class, 'edit'])->name('book.edit');
    Route::post('/books/update/{id}', [App\Http\Controllers\BookController::class, 'update'])->name('book.update');
    Route::get('/books/delete/{id}', [App\Http\Controllers\BookController::class, 'delete'])->name('book.delete');

    //Route untuk peminjaman
    Route::get('/loans', [App\Http\Controllers\LoanController::class, 'index'])->name('loan.index');
    Route::get('/loans/add', [App\Http\Controllers\LoanController::class, 'add'])->name('loan.add');
    Route::post('/loans/store', [App\Http\Controllers\LoanController::class, 'store'])->name('loan.store');
    Route::get('/loans/edit/{id}', [App\Http\Controllers\LoanController::class, 'edit'])->name('loan.edit');
    Route::post('/loans/update/{id}', [App\Http\Controllers\LoanController::class, 'update'])->name('loan.update');
    Route::get('/loans/delete/{id}', [App\Http\Controllers\LoanController::class, 'delete'])->name('loan.delete');
    Route::get('/loans/return/{id}', [App\Http\Controllers\LoanController::class, 'return_book'])->name('loan.return_book');
});

Route::group(['middleware' => ['auth','roles:user']], function () {
    Route::get('/peminjaman', [App\Http\Controllers\PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/pinjam/{id}', [App\Http\Controllers\PeminjamanController::class, 'pinjam'])->name('peminjaman.pinjam');
    Route::post('/peminjaman/store', [App\Http\Controllers\PeminjamanController::class, 'store'])->name('peminjaman.store');

    Route::get('/daftar_peminjaman', [App\Http\Controllers\PeminjamanController::class, 'daftar_peminjaman'])->name('daftar_peminjaman.index');
    Route::get('/daftar_peminjaman/return/{id}', [App\Http\Controllers\PeminjamanController::class, 'return_book'])->name('daftar_peminjaman.return_book');
});