<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SINILAI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #c1c1c1; border-radius: 4px; }
    </style>
</head>
<body class="bg-gray-100">

<div class="flex h-screen overflow-hidden">
    
    <aside class="w-64 bg-[#65825C] text-white flex flex-col shadow-xl relative z-20">
        <div class="h-20 flex items-center px-6 border-b border-white/10">
            <div class="w-10 h-10 rounded-full bg-blue-900 border-2 border-yellow-400 flex items-center justify-center mr-3">
                <span class="text-[8px] font-bold text-center leading-tight">LOGO<br>SD</span>
            </div>
            <div>
                <h1 class="text-xl font-bold">SINILAI</h1>
                <p class="text-xs opacity-80">SD Aldenaire</p>
            </div>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            @if(Request::is('admin*') || Request::is('dashboard/admin*'))
                <a href="{{ route('dashboard.admin') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-white/10 transition {{ Request::routeIs('dashboard.admin') ? 'bg-white/20' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.guru.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-white/10 transition {{ Request::routeIs('admin.guru.*') ? 'bg-white/20' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Guru Mata Pelajaran
                </a>
                <a href="{{ route('admin.siswa.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-white/10 transition {{ Request::routeIs('admin.siswa.*') ? 'bg-white/20' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Siswa
                </a>
                <a href="{{ route('admin.mapel.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-white/10 transition {{ Request::routeIs('admin.mapel.*') ? 'bg-white/20' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    Mata Pelajaran
                </a>
                <div class="px-4 py-2 text-xs font-semibold text-white/50 uppercase mt-2">Pengaturan</div>
                <a href="{{ route('admin.tahun.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-white/10 transition {{ Request::routeIs('admin.tahun.*') ? 'bg-white/20' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Tahun Pelajaran
                </a>
            @endif

            @if(Request::is('dashboard/guru*') || Request::is('guru/*'))
                <a href="{{ route('dashboard.guru') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-white/10 transition {{ Request::routeIs('dashboard.guru') ? 'bg-white/20' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dashboard
                </a>

                <div class="px-4 py-2 text-xs font-semibold text-white/50 uppercase mt-2">Mata Pelajaran</div>
                
                @foreach(Auth::user()->mapels as $m)
                <a href="{{ route('guru.pilih.kelas', $m->id) }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-white/10 transition {{ Request::is('guru/mapel/'.$m->id) || Request::is('guru/nilai/*/'.$m->id) ? 'bg-white/20' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    {{ $m->nama_mapel }}
                </a>
                @endforeach
            @endif

            @if(Auth::user()->kelasPerwalian)
                <div class="px-4 py-2 text-xs font-semibold text-white/50 uppercase mt-6 border-t border-white/10 pt-4">
                    Wali Kelas {{ Auth::user()->kelasPerwalian->nama_kelas }}
                </div>

                <a href="{{ route('guru.walikelas.rekap') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-white/10 transition {{ Request::routeIs('guru.walikelas.*') ? 'bg-white/20' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Rekap Nilai & Rapor
                </a>
            @endif

            @if(Request::is('dashboard/walimurid*'))
                <a href="{{ route('dashboard.walimurid') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-white/10 transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    Nilai
                </a>
            @endif

        </nav>

        <div class="p-6 border-t border-white/10">
            <form action="{{ route('logout') }}" method="POST">
            @csrf
                <button type="submit" class="flex items-center text-white/80 hover:text-white transition w-full text-left">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Log Out
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-hidden bg-gray-50">
        <header class="h-16 bg-[#65825C] text-white flex items-center justify-between px-6 shadow-md">
            <div class="flex items-center">
                <button class="mr-4 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <nav class="text-sm font-medium">
                    <span class="opacity-70">Home</span> / <span>Dashboard</span>
                </nav>
            </div>
            
            <div class="relative">
                <button class="flex items-center bg-white/20 px-3 py-1.5 rounded-md text-sm hover:bg-white/30 transition">
                    @if(Auth::user()->role == 'admin')
                        Admin
                    @elseif(Auth::user()->role == 'guru')
                        Guru
                    @elseif(Auth::user()->role == 'walimurid')
                        Wali Murid
                    @endif
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-8">
            @yield('content')
        </div>
    </main>
</div>

</body>
</html>