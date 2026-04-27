<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthC extends Controller
{
  public function login(Request $request)
  {
    // validasi
    $request->validate([
      'email' => 'required|email',
      'password' => 'required'
    ]);

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
      $request->session()->regenerate();

      $role = Auth::user()->role;

      if ($role == 'admin') {
        return redirect()->route('dashboard.admin');
      } elseif ($role == 'employee') {
        return redirect()->route('dashboard.petugas');
      } elseif ($role == 'user') { 
        return redirect()->route('dashboard.peminjam');
      }

      // fallback (kalau role aneh)
      Auth::logout();
      return redirect()->route('login')->withErrors('Role tidak dikenali');
    }

    return back()->withErrors([
      'email' => 'Email atau password salah!',
    ])->onlyInput('email');
  }

  public function logout(Request $request)
  {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
  }
}
