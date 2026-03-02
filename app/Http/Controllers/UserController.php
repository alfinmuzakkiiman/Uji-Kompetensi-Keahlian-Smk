<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view("users.index", compact('users'));
    }

    public function add()
    {
        return view("users.add");
    }

    public function delete(Request $request)
    {
        try {
            $user = User::findOrFail($request->id);
            $user->delete();

            return redirect()->route('user.index')->with('success','User berhasil dihapus!');
        } catch (\Throwable $th) {
            return redirect()->route('user.index')->with('error', "User gagal dihapus!");
        }
    }

    public function edit(Request $request)
    {
        try {
            $user = User::findOrFail($request->id);

            return view('users.edit', compact('user'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "User tidak ditemukan!");
        }

    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->password) {
                $user->password = bcrypt($request->password);
            }
            $user->role = $request->role;
            $user->save();

            return redirect()->route('user.index')->with('success','User berhasil diupdate!');
        } catch (\Throwable $th) {
            return redirect()->route('user.index')->with('error', "User gagal diupdate!");
        }
    }

    public function store(Request $request)
    {
        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => $request->role,
            ]);

            return redirect()->route('user.index')->with('success','User berhasil ditambahkan!');
        } catch (\Throwable $th) {
            return redirect()->route('user.index')->with('error', "User gagal ditambahkan!");
        }
    }
}
