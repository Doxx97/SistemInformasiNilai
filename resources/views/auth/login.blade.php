@extends('layouts.app')

@section('content')
<div class="bg-white rounded-xl shadow-2xl overflow-hidden flex flex-col md:flex-row w-full max-w-4xl mx-auto min-h-[500px]">
    
    <div class="w-full md:w-5/12 bg-[#65825C] hidden md:block">
        </div>

    <div class="w-full md:w-7/12 bg-white p-10 flex flex-col justify-center">
        
        <h1 class="text-2xl font-bold text-black mb-2">Selamat Datang di SINILAI</h1>
        <p class="text-gray-500 text-sm mb-6">Silahkan login menggunakan akun Anda</p>

        <form action="{{ route('login.process', $role) }}" method="POST" class="space-y-5">
            @csrf
            
            {{-- LOGIKA TAMPILAN FIELD BERDASARKAN ROLE --}}
            
            {{-- 1. LOGIN WALI MURID (Nama & NISN) --}}
            @if($role == 'walimurid')
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1 uppercase">Nama</label>
                    <input type="text" name="name" class="w-full bg-gray-200 border-none rounded-md px-4 py-3 focus:ring-2 focus:ring-[#65825C] focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1 uppercase">NISN</label>
                    {{-- Pastikan name="nisn" --}}
                    <input type="text" name="nisn" class="w-full bg-gray-200 border-none rounded-md px-4 py-3 focus:ring-2 focus:ring-[#65825C] focus:outline-none">
                    <div class="text-right mt-1">
                        <a href="#" class="text-xs text-blue-600 font-semibold hover:underline">Lupa NISN ?</a>
                    </div>
                </div>
                <div class="text-right mt-1">
                    <a href="{{ route('landing') }}" class="hover:underline text-sm">Kembali ke halaman utama</a>
                </div>
                

            {{-- 2. LOGIN ADMIN (No ID Admin & Password) --}}
            @elseif($role == 'admin')
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1 uppercase">No ID Admin</label>
                    <input type="text" name="id_admin" class="w-full bg-gray-200 border-none rounded-md px-4 py-3 focus:ring-2 focus:ring-[#65825C] focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1 uppercase">Password</label>
                    <input type="password" name="password" class="w-full bg-gray-200 border-none rounded-md px-4 py-3 focus:ring-2 focus:ring-[#65825C] focus:outline-none">
                    <div class="text-right mt-1">
                        <a href="#" class="text-xs text-blue-600 font-semibold hover:underline">Lupa Password ?</a>
                    </div>
                </div>
                <div class="text-right mt-1">
                    <a href="{{ route('landing') }}" class="hover:underline text-sm">Kembali ke halaman utama</a>
                </div>

            {{-- 3. LOGIN GURU (Nama/NPSN & Password) --}}
            @elseif($role == 'guru')
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1 uppercase">Nama atau NPSN</label>
                    <input type="text" name="username" class="w-full bg-gray-200 border-none rounded-md px-4 py-3 focus:ring-2 focus:ring-[#65825C] focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1 uppercase">Password</label>
                    <input type="password" name="password" class="w-full bg-gray-200 border-none rounded-md px-4 py-3 focus:ring-2 focus:ring-[#65825C] focus:outline-none">
                    <div class="text-right mt-1">
                        <a href="#" class="text-xs text-blue-600 font-semibold hover:underline">Lupa Password ?</a>
                    </div>
                </div>
                <div class="text-right mt-1">
                    <a href="{{ route('landing') }}" class="hover:underline text-sm">Kembali ke halaman utama</a>
                </div>
            @endif

            <div class="pt-4 transition duration-300 hover:scale-105">
                <button type="submit" class="bg-[#a3c966] hover:bg-[#8eb355] text-gray-800 font-bold py-2 px-8 rounded-full shadow-md transition duration-300 flex items-center gap-2 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                    LOGIN
                </button>
            </div>
        </form>
    </div>
</div>
@endsection