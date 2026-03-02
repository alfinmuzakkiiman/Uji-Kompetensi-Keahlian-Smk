<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::all();

        return view("books.index", compact('books'));
    }

    public function add(Request $request)
    {
        return view("books.add");
    }

    public function delete(Request $request)
    {
        try {
            $book = Book::findOrFail($request->id);
            $book->delete();

            return redirect()->route("book.index")->with('success', 'Buku berhasil dihapus.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "Buku gagal dihapus.");
        }
    }

    public function store(Request $request)
    {
        try {
            Book::create([
                'judul' => $request->judul,
                'penerbit' => $request->penerbit,
                'tahun_terbit' => $request->tahun_terbit,
                'stok' => $request->stok,
            ]);
            
            return redirect()->route('book.index')->with('success','Buku berhasil ditambahkan.');
        } catch (\Throwable $th) {
            return redirect()->route('book.index')->with('error','Buku gagal ditambahkan.');
        }
    }

    public function update(Request $request){
        try {
            $book = Book::findOrFail($request->id);
            $book->update([
                'judul' => $request->judul,
                'penerbit' => $request->penerbit,
                'tahun_terbit' => $request->tahun_terbit,
                'stok' => $request->stok,
            ]);

            return redirect()->route('book.index')->with('success','Buku berhasil diupdate.');
        } catch (\Throwable $th) {
            return redirect()->route('book.index')->with('error','Buku gagal diupdate.');
        }
    }

    public function edit(Request $request)
    {
        try {
            $book = Book::findOrFail($request->id);

            return view("books.edit", compact('book'));
        } catch (\Throwable $th) {
            return redirect()->route('book.index')->with('error', 'Buku tidak ditemukan.');
        }
    }
}
