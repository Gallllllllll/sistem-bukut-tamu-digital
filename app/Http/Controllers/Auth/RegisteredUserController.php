<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisteredUserController extends Controller
{
    public function index() {
        return view('tamus.register');
    }
    // Menampilkan form registrasi
   public function store(Request $request)
{
    $request->validate([
        'username' => 'required|unique:users',
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|confirmed',
    ]);

    // Create the user
    $user = User::create([
        'username' => $request->username,
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
    ]);

    // Redirect to a different page (e.g., homepage)
    return redirect()->route('home')->with('success', 'Registration successful!');
}
}