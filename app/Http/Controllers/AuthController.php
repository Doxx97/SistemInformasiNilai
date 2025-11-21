<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    public function landing()
    {
        return view('auth.landing');
    }

    public function loginForm($role)
    {
        if (!in_array($role, ['admin', 'guru', 'walimurid'])) {
            abort(404);
        }
        
        $config = [
            'admin' => [
                'title' => 'Login Admin',
                'fields' => ['id_admin' => 'No ID Admin', 'password' => 'Password'],
            ],
            'guru' => [
                'title' => 'Login Guru',
                'fields' => ['username' => 'NPSN', 'password' => 'Password'],
            ],
            'walimurid' => [
                'title' => 'Login Wali Murid',
                'fields' => ['name' => 'Nama', 'nisn' => 'NISN', ],
            ],
        ];
        return view('auth.login', [
            'role' => $role,
            'data' => $config[$role],
        ]);
    }
    
    public function authenticate(Request $request, $role)
    {
        // ---------------------------------------------------------
        // SKENARIO 1: LOGIN WALI MURID (Input Cuma NISN)
        // ---------------------------------------------------------
        if ($role === 'walimurid') {
            // 1. Validasi: Pastikan NISN diisi
            $request->validate([
                'nisn' => ['required', 'string'],
            ]);

            // 2. Manipulasi: Set Username & Password sama persis dengan NISN
            $credentials = [
                'username' => $request->nisn,  // Mencocokkan kolom username di DB
                'password' => $request->nisn   // Mencocokkan password (kita anggap passwordnya adalah NISN)
            ];
        }
        
        // ---------------------------------------------------------
        // SKENARIO 2: LOGIN ADMIN & GURU (Wajib Input Password)
        // ---------------------------------------------------------
        else {
            // Tentukan field login (id_admin atau username)
            $loginField = ($role === 'admin') ? 'id_admin' : 'username';

            // Validasi harus ada password
            $reqData = $request->validate([
                $loginField => ['required', 'string'],
                'password'  => ['required', 'string'],
            ]);

            $credentials = [
                'username' => $reqData[$loginField],
                'password' => $reqData['password']
            ];
        }

        // ---------------------------------------------------------
        // EKSEKUSI LOGIN (SAMA UNTUK SEMUA)
        // ---------------------------------------------------------
        // Auth::attempt akan otomatis menghash password inputan dan mencocokkan dengan DB
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Cek apakah dia login di pintu yang benar?
            if ($user->role !== $role) {
                Auth::logout();
                return back()->withErrors(['login_error' => 'Akun Anda tidak terdaftar sebagai ' . $role]);
            }

            return redirect()->route('dashboard.' . $user->role);
        }

        // Jika Gagal
        return back()->withErrors([
            'login_error' => 'Login Gagal! Cek NISN atau Data Anda.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
