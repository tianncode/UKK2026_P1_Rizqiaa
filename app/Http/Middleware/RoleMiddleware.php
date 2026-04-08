<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // cek sudah login atau belum
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // ambil role user
        $userRole = auth()->user()->role;

        // cek apakah role diizinkan
        if (!in_array($userRole, $roles)) {
            abort(403, 'Akses ditolak!');
        }

        return $next($request);
    }
}
