<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {

    // ── Tampilkan halaman login ──
    public function showLogin() {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    // ── Fungsi untuk melakukan login ──
    public function login(Request $request) {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required',
        ]);

        // Cari user berdasarkan kolom 'name'
        $user = \App\Models\User::where('name', $request->username)->first();

        if ($user && \Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->withInput();
    }

    // ── Fungsi untuk melakukan logout ──
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}