<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    // Menampilkan form login
    public function create()
    {
        return view('tamus.loginuser');
    }

    // Menyimpan session setelah login
    public function store(Request $request)
    {
        // Validasi login
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Autentikasi pengguna
        if (Auth::attempt($request->only('email', 'password'))) {
            // Redirect ke halaman create setelah berhasil login
            return redirect()->route('tamus.create');
        }

        // Jika login gagal, kembali ke form login dengan pesan error
        return back()->withErrors([
            'email' => 'The provided credentials are incorrect.',
        ]);
    }

    // Logout pengguna
    public function destroy(Request $request)
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        // Redirect ke halaman login setelah logout
        return redirect('/');
    }
}