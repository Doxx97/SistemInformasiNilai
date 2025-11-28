@extends('layouts.dashboard')

@section('content')
<div class="space-y-8">

    {{-- 1. LOGIKA PENGHITUNG (PHP) --}}
    @php
        $guruCount = \App\Models\User::where('role', 'guru')->count();
        $siswaCount = \App\Models\User::where('role', 'walimurid')->count();
        $mapelCount = \App\Models\Mapel::count();
        $thn = \App\Models\TahunPelajaran::where('is_active', true)->first();

        // Menghitung Siswa Per Tingkat (Menggunakan LIKE agar '1A', '1B' tetap masuk ke '1')
        // Asumsi nama kelas diawali angka tingkatnya (1..., 2..., dst)
        $kls1 = \App\Models\User::where('role', 'walimurid')->whereHas('kelas', fn($q) => $q->where('nama_kelas', 'like', '1%'))->count();
        $kls2 = \App\Models\User::where('role', 'walimurid')->whereHas('kelas', fn($q) => $q->where('nama_kelas', 'like', '2%'))->count();
        $kls3 = \App\Models\User::where('role', 'walimurid')->whereHas('kelas', fn($q) => $q->where('nama_kelas', 'like', '3%'))->count();
        $kls4 = \App\Models\User::where('role', 'walimurid')->whereHas('kelas', fn($q) => $q->where('nama_kelas', 'like', '4%'))->count();
        $kls5 = \App\Models\User::where('role', 'walimurid')->whereHas('kelas', fn($q) => $q->where('nama_kelas', 'like', '5%'))->count();
        $kls6 = \App\Models\User::where('role', 'walimurid')->whereHas('kelas', fn($q) => $q->where('nama_kelas', 'like', '6%'))->count();
    @endphp
    
    <div class="bg-[#65825C] rounded-2xl p-6 md:p-10 text-white shadow-lg relative overflow-hidden">
        <div class="relative z-10">
            <h1 class="text-2xl md:text-3xl font-bold mb-2">Selamat Datang, Admin!</h1>
            <p class="opacity-90 text-sm md:text-base">
                Sistem Informasi Akademik SD Aldenaire.
                <br>Tahun Ajaran Aktif: <span class="font-bold text-yellow-300">{{ $thn ? $thn->tahun . ' (' . $thn->semester . ')' : 'Belum diset' }}</span>
            </p>
        </div>
        <div class="absolute right-0 top-0 w-40 h-40 bg-white opacity-10 rounded-full blur-3xl -mr-10 -mt-10"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-blue-500 flex items-center justify-between hover:shadow-md transition transform hover:-translate-y-1">
            <div>
                <p class="text-gray-500 text-xs font-bold uppercase tracking-wider">Total Guru</p>
                <p class="text-4xl font-bold text-gray-800 mt-1">{{ $guruCount }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-green-500 flex items-center justify-between hover:shadow-md transition transform hover:-translate-y-1">
            <div>
                <p class="text-gray-500 text-xs font-bold uppercase tracking-wider">Total Seluruh Siswa</p>
                <p class="text-4xl font-bold text-gray-800 mt-1">{{ $siswaCount }}</p>
                <p class="text-[10px] text-green-600 mt-1 font-semibold">Aktif & Terdaftar</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-purple-500 flex items-center justify-between hover:shadow-md transition transform hover:-translate-y-1">
            <div>
                <p class="text-gray-500 text-xs font-bold uppercase tracking-wider">Mata Pelajaran</p>
                <p class="text-4xl font-bold text-gray-800 mt-1">{{ $mapelCount }}</p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center text-purple-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            </div>
        </div>
    </div>

    <div>
        <h3 class="font-bold text-gray-700 text-lg mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-[#65825C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 0116 0v-6a2 2 0 00-2-2h-2a2 2 0 00-2 2v6"></path></svg>
            Rincian Siswa Per Tingkat
        </h3>
        
        <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
            
            {{-- KELAS 1 --}}
            <div class="bg-white p-4 rounded-xl shadow-sm border-b-4 border-red-400 flex flex-col items-center justify-center text-center transition hover:shadow-md">
                <span class="bg-red-100 text-red-600 text-[10px] font-bold px-2 py-1 rounded-full uppercase mb-2">Kelas 1</span>
                <p class="text-3xl font-bold text-gray-800">{{ $kls1 }}</p>
                <p class="text-xs text-gray-400">Siswa</p>
            </div>

            {{-- KELAS 2 --}}
            <div class="bg-white p-4 rounded-xl shadow-sm border-b-4 border-orange-400 flex flex-col items-center justify-center text-center transition hover:shadow-md">
                <span class="bg-orange-100 text-orange-600 text-[10px] font-bold px-2 py-1 rounded-full uppercase mb-2">Kelas 2</span>
                <p class="text-3xl font-bold text-gray-800">{{ $kls2 }}</p>
                <p class="text-xs text-gray-400">Siswa</p>
            </div>

            {{-- KELAS 3 --}}
            <div class="bg-white p-4 rounded-xl shadow-sm border-b-4 border-yellow-400 flex flex-col items-center justify-center text-center transition hover:shadow-md">
                <span class="bg-yellow-100 text-yellow-600 text-[10px] font-bold px-2 py-1 rounded-full uppercase mb-2">Kelas 3</span>
                <p class="text-3xl font-bold text-gray-800">{{ $kls3 }}</p>
                <p class="text-xs text-gray-400">Siswa</p>
            </div>

            {{-- KELAS 4 --}}
            <div class="bg-white p-4 rounded-xl shadow-sm border-b-4 border-green-400 flex flex-col items-center justify-center text-center transition hover:shadow-md">
                <span class="bg-green-100 text-green-600 text-[10px] font-bold px-2 py-1 rounded-full uppercase mb-2">Kelas 4</span>
                <p class="text-3xl font-bold text-gray-800">{{ $kls4 }}</p>
                <p class="text-xs text-gray-400">Siswa</p>
            </div>

            {{-- KELAS 5 --}}
            <div class="bg-white p-4 rounded-xl shadow-sm border-b-4 border-blue-400 flex flex-col items-center justify-center text-center transition hover:shadow-md">
                <span class="bg-blue-100 text-blue-600 text-[10px] font-bold px-2 py-1 rounded-full uppercase mb-2">Kelas 5</span>
                <p class="text-3xl font-bold text-gray-800">{{ $kls5 }}</p>
                <p class="text-xs text-gray-400">Siswa</p>
            </div>

            {{-- KELAS 6 --}}
            <div class="bg-white p-4 rounded-xl shadow-sm border-b-4 border-purple-400 flex flex-col items-center justify-center text-center transition hover:shadow-md">
                <span class="bg-purple-100 text-purple-600 text-[10px] font-bold px-2 py-1 rounded-full uppercase mb-2">Kelas 6</span>
                <p class="text-3xl font-bold text-gray-800">{{ $kls6 }}</p>
                <p class="text-xs text-gray-400">Siswa</p>
            </div>

        </div>
    </div>

    <div class="mt-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="{{ route('admin.tahun.index') }}" class="bg-[#65825C] hover:bg-[#546e4b] text-white p-4 rounded-xl flex items-center justify-between transition group">
                <span class="font-bold text-sm">Kelola Tahun Pelajaran</span>
                <svg class="w-5 h-5 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
            </a>
            <a href="{{ route('admin.siswa.index') }}" class="bg-[#65825C] hover:bg-[#546e4b] text-white p-4 rounded-xl flex items-center justify-between transition group">
                <span class="font-bold text-sm">Kelola Data Siswa</span>
                <svg class="w-5 h-5 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </a>
        </div>
    </div>

</div>
@endsection