<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthC extends Controller
{
  public function login(Request $request)
  {
    // validasi input
    $request->validate([
      'email' => 'required|email',
      'password' => 'required'
    ]);

    // ambil credential
    $credentials = $request->only('email', 'password');

    // cek login
    if (Auth::attempt($credentials)) {
      $request->session()->regenerate();

      $role = Auth::user()->role;

      if ($role == 'admin') {
        return redirect('/admin');
      } elseif ($role == 'petugas') {
        return redirect('/dashboard/petugas');
      } else {
        return redirect('/dashboard/peminjam');
      }
    }

    // jika gagal
    return back()->withErrors([
      'email' => 'Email atau password salah!',
    ])->onlyInput('email');
  }

  // 🔥 Logout
  public function logout(Request $request)
  {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
  }
}
