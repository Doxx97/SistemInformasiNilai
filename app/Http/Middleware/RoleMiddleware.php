<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Cek apakah sudah login?
        if (!Auth::check()) {
            return redirect('/');
        }

        // Cek apakah role user sesuai dengan yang diminta route?
        if (Auth::user()->role !== $role) {
            // Jika salah kamar, tendang ke dashboard yang benar
            return redirect('/dashboard/' . Auth::user()->role);
        }

        return $next($request);
    }
}