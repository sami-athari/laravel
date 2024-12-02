<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Show Login Form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle Login
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'identifier' => 'required',  // identifier bisa berupa email atau nama
            'password' => 'required|min:6',
        ]);

        // Tentukan apakah identifier yang diberikan adalah email atau nama
        $field = filter_var($request->identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        // Cek kredensial dan login
        if (Auth::attempt([$field => $request->identifier, 'password' => $request->password])) {
            $user = Auth::user();

            // Redirect berdasarkan peran pengguna
            if ($user->role === 'admin') {
                return redirect()->route('admin.index'); // Redirect ke halaman admin
            }

            return redirect()->route('user.dashboard'); // Redirect ke halaman user biasa
        }

        return back()->withErrors(['identifier' => 'Invalid credentials']);
    }

    // Show Register Form
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Handle Register
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        // Buat pengguna baru
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }

    // Handle Logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
