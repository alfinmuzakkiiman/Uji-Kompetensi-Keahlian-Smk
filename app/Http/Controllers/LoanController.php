<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::all();
        return view("loans.admin.index", compact('loans'));
    }
    
    public function add(Request $request)
    {
        $books = Book::where('stok', '>', 0)->get();
        $users = User::where('role', 'user')->get();
        return view("loans.admin.add", compact('books', 'users'));
    }

    public function edit(Request $request)
    {
        try {
            $loan = Loan::findOrFail($request->id);
            $users = User::where('role', 'user')->get();
            $books = Book::all();

            return view("loans.admin.edit", compact('loan', 'users', 'books'));
        } catch (\Throwable $th) {
            return redirect()->route('loan.index')->with('error', 'Data peminjam tidak ditemukan.');
        }
    }

    public function store(Request $request)
    {
        try {
            Loan::create([
                'user_id' => $request->peminjam,
                'book_id' => $request->buku,
                'tanggal_pinjam' => $request->tanggal_pinjam,
            ]);
            // Kurangi stok buku
            $book = Book::findOrFail($request->buku);
            if ($book && $book->stok > 0) {
                $book->stok -= 1;
                $book->save();
            }
            return redirect()->route('loan.index')->with('success', 'Peminjaman berhasil ditambahkan.');
        } catch (\Throwable $th) {
            return redirect()->route('loan.index')->with('error', 'Gagal menambahkan peminjaman.');
        }
    }

    public function return_book(Request $request)
    {
        try {
            $loan = Loan::findOrFail($request->id);

            if($loan->status == 'dikembalikan'){
                return redirect()->route('loan.index')->with('error', 'Buku sudah dikembalikan sebelumnya.');
            }

            $loan->status = 'dikembalikan';
            $loan->tanggal_kembali = date('Y-m-d');
            $loan->save();

            // Kembalikan stok buku
            $book = Book::findOrFail($loan->book_id);
            $book->stok += 1;
            $book->save();

            return redirect()->route('loan.index')->with('success', 'Buku berhasil dikembalikan.');
        } catch (\Throwable $th) {
            return redirect()->route('loan.index')->with('error', 'Gagal mengembalikan buku.');
        }
    }

     public function update(Request $request)
    {
        try {
            $loan = Loan::findOrFail($request->id);

            if($loan->book_id == $request->buku){
                Loan::where('id', $request->id)->update([
                    'user_id' => $request->peminjam,
                    'tanggal_pinjam' => $request->tanggal_pinjam,
                ]);
            }else{
                Loan::where('id', $request->id)->update([
                    'user_id' => $request->peminjam,
                    'book_id' => $request->buku,
                    'tanggal_pinjam' => $request->tanggal_pinjam,
                ]);

                Book::where('id', $loan->book_id)->increment('stok', 1);
                Book::where('id', $request->buku)->decrement('stok', 1);
            }
            return redirect()->route('loan.index')->with('success', 'Data peminjam berhasil diupdate.');
        } catch (\Throwable $th) {
            return redirect()->route('loan.index')->with('error', 'Gagal mengupdate data peminjam. ' . $th->getMessage());
        }
    }

     public function delete(Request $request)
    {
        try {
            $loan = Loan::findOrFail($request->id);
            $loan->delete();

            // Kembalikan stok buku
            if($loan->status != 'dikembalikan'){
                $book = Book::findOrFail($loan->book_id);
                $book->stok += 1;
                $book->save();
            }

            return redirect()->route('loan.index')->with('success', 'Data peminjam berhasil dihapus.');
        } catch (\Throwable $th) {
            return redirect()->route('loan.index')->with('error', 'Gagal menghapus data peminjam.');
        }
    }
}
