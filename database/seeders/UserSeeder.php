<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin
        User::create([
            'name' => 'Admin Utama',
            'username' => 'admin123', // Ini ID Admin
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Akun Guru
        User::create([
            'name' => 'Indi Rahma Angely',
            'username' => '123456', // Ini NIP atau NPSN
            'password' => Hash::make('password'),
            'role' => 'guru',
        ]);

        // 3. Akun Wali Murid
        User::create([
            'name' => 'Bapak Ali',
            'username' => '35050664', // Username adalah NISN
            // PASSWORD DIBUAT SAMA DENGAN NISN
            'password' => Hash::make('35050664'), 
            'role' => 'walimurid',
        ]);
    }
}