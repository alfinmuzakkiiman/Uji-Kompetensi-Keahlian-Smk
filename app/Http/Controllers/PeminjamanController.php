<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use Illuminate\Cache\RedisStore;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    //FUNCTIONS UNTUK PEMINJAMAN BUKU
    public function index()
    {
        $books = Book::all();
        return view("loans.user.index", compact('books'));
    }

    public function pinjam(Request $request)
    {
        try {
            $book = Book::findOrFail($request->id);

            return view('loans.user.pinjam', compact('book'));
        } catch (\Throwable $th) {
            return redirect()->route('peminjaman.index')->with('error', $th->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $book = Book::findOrFail($request->book_id);
            $user = auth()->user();

            Loan::create([
                'book_id' => $book->id,
                'user_id' => $user->id,
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'status' => 'dipinjam',
            ]);

            $book->decrement('stok', 1);

            return redirect()->route('peminjaman.index')->with('success', 'Buku berhasil dipinjam.');
        } catch (\Throwable $th) {
            return redirect()->route('peminjaman.index')->with('error',  "Buku gagal dipinjam.");
        }
    }

    //FUNCTIONS UNTUK DAFTAR PEMINJAMAN BUKU

    public function daftar_peminjaman()
    {
        $user = auth()->user();
        $loans = Loan::where('user_id', $user->id)->with('book')->get();
        return view('loans.user.daftar_peminjaman', compact('loans'));
    }

    public function return_book(Request $request)
    {
        try {
            $loan = Loan::findOrFail($request->id);

            if($loan->status == 'dikembalikan'){
                return redirect()->route('daftar_peminjaman.index')->with('error', 'Buku sudah dikembalikan sebelumnya.');
            }

            $loan->status = 'dikembalikan';
            $loan->tanggal_kembali = date('Y-m-d');
            $loan->save();

            // Kembalikan stok buku
            $book = Book::findOrFail($loan->book_id);
            $book->stok += 1;
            $book->save();

            return redirect()->route('daftar_peminjaman.index')->with('success', 'Buku berhasil dikembalikan.');
        } catch (\Throwable $th) {
            return redirect()->route('daftar_peminjaman.index')->with('error', 'Gagal mengembalikan buku.');
        }
    }
}
