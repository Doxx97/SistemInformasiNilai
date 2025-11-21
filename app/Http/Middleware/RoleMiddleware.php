<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // 1. Cek apakah user login?
        if (!Auth::check()) {
            return redirect()->route('landing')->with('error', 'Silakan login terlebih dahulu.');
        }

        // 2. Cek apakah role user SESUAI dengan yang diminta route?
        if (Auth::user()->role !== $role) {
            
            // --- LOGIKA "USER BANDEL" ---
            
            // Tentukan pesan peringatan
            $pesan = "Eits! Anda mencoba masuk ke area terlarang.";
            if($role == 'admin') {
                $pesan = "Anda bukan Admin! Akses ditolak.";
            } elseif($role == 'guru') {
                $pesan = "Halaman ini khusus Guru.";
            }

            // Kembalikan user ke Dashboard-nya masing-masing
            // Asumsi nama route dashboard kita: 'dashboard.admin', 'dashboard.guru', 'dashboard.walimurid'
            return redirect()->route('dashboard.' . Auth::user()->role)
                             ->with('alert-bandel', $pesan);
        }

        return $next($request);
    }
}