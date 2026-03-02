<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;
use App\Models\Loan;
use Carbon\Carbon;

class PageController extends Controller
{
    public function login()
    {
        return view("auth.login");
    }

    public function authenticate(Request $request)
    {
        if (Auth::attempt($request->only("email","password"))) {
            $request->session()->regenerate();
            return redirect()->intended("dashboard");
        } else {
            return redirect()->route('login');
        }
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        return redirect()->route('login');
    }

    public function dashboard()
    {
        // ADMIN
        if (auth()->user()->role == 'admin') {

            $totalBuku = Book::count();
            $totalUser = User::count();
            $peminjamanHariIni = Loan::whereDate('created_at', Carbon::today())->count();

            return view("dashboard", compact(
                'totalBuku',
                'totalUser',
                'peminjamanHariIni'
            ));
        } 
        // USER / SISWA
        else {

            $totalBuku = Book::count();

           $dipinjam = Loan::where('user_id', auth()->id())
                ->where('status', 'dipinjam')
                ->count();


            $riwayat = Loan::where('user_id', auth()->id())->count();

            return view("dashboard", compact(
                'totalBuku',
                'dipinjam',
                'riwayat'
            ));
        }
    }
}
