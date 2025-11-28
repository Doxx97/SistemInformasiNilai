<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SINILAI - Dashboard</title>
    <link rel="icon" href="{{ asset('images/title.png') }}" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    {{-- STYLE TAMBAHAN (SweetAlert Posisinya Agak Atas) --}}
    <style>
        body { font-family: 'Poppins', sans-serif; }
        div.swal2-container { padding-bottom: 150px !important; }
        
        /* Hide scrollbar for Chrome, Safari and Opera */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        /* Hide scrollbar for IE, Edge and Firefox */
        .no-scrollbar { -ms-overflow-style: none;  scrollbar-width: none; }
    </style>
</head>
<body class="bg-gray-100 text-gray-800">

    {{-- 1. PRELOADER (Animasi Loading) --}}
    <div id="preloader" class="fixed inset-0 z-[9999] bg-white flex flex-col items-center justify-center transition-opacity duration-500">
        <div class="relative flex justify-center items-center">
            <div class="absolute animate-ping w-24 h-24 rounded-full bg-green-200 opacity-75"></div>
            <div class="relative w-20 h-20 bg-white rounded-full border-4 border-yellow-400 shadow-lg flex items-center justify-center p-1 z-10">
                {{-- LOGO SEKOLAH --}}
                <img src="{{ asset('images/SD.png') }}" class="w-full h-full object-contain rounded-full animate-pulse">
            </div>
        </div>
        <p class="mt-4 text-[#65825C] font-bold text-sm tracking-widest animate-pulse">MEMUAT...</p>
    </div>

    <div class="flex h-screen overflow-hidden bg-gray-100">

        {{-- 2. SIDEBAR (MENU KIRI) --}}
        {{-- Logika: Hidden di Mobile (default), Block di MD (Laptop). Jika ada class 'mobile-menu-open', dia muncul di mobile --}}
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-[#65825C] text-white transition-transform duration-300 transform -translate-x-full md:translate-x-0 md:static md:inset-0 shadow-xl flex flex-col">
            
            <div class="flex items-center justify-between h-20 px-6 border-b border-white/10 bg-[#546e4b]">
                <div class="flex items-center">
                    <div class="w-12 h-12 mr-3 bg-white rounded-full border-2 border-yellow-400 overflow-hidden flex items-center justify-center shadow-sm">
                        <img src="{{ asset('images/SD.png') }}" alt="Logo" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <h1 class="text-lg font-bold tracking-wider">SINILAI</h1>
                        <p class="text-[10px] text-white/70">SDN Liga Nusantara </p>
                    </div>
                </div>
                <button onclick="toggleSidebar()" class="md:hidden text-white hover:text-yellow-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto no-scrollbar">
                @php $role = Auth::user()->role; @endphp

                <p class="px-4 text-xs font-semibold text-white/40 uppercase tracking-wider mb-2">Menu Utama</p>

                @if($role == 'admin')
                    <a href="{{ route('dashboard.admin') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-white/10 transition {{ Request::routeIs('dashboard.admin') ? 'bg-white/20' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        Dashboard Admin
                    </a>
                    <div class="px-4 py-2 text-xs font-semibold text-white/50 uppercase mt-2">Data Master</div>
                    <a href="{{ route('admin.guru.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-white/10 transition {{ Request::routeIs('admin.guru.*') ? 'bg-white/20' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Guru & Mapel
                    </a>
                    <a href="{{ route('admin.siswa.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-white/10 transition {{ Request::routeIs('admin.siswa.*') ? 'bg-white/20' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Data Siswa
                    </a>
                    <a href="{{ route('admin.mapel.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-white/10 transition {{ Request::routeIs('admin.mapel.*') ? 'bg-white/20' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        Mata Pelajaran
                    </a>
                    <a href="{{ route('admin.tahun.index') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-white/10 transition {{ Request::routeIs('admin.tahun.*') ? 'bg-white/20' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Tahun Pelajaran
                    </a>

                @elseif($role == 'guru')
                    <a href="{{ route('dashboard.guru') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-white/10 transition {{ Request::routeIs('dashboard.guru') ? 'bg-white/20' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        Jadwal & Nilai
                    </a>

                    {{-- MENU KHUSUS WALI KELAS --}}
                    @if(Auth::user()->kelasPerwalian)
                        <div class="px-4 py-2 text-xs font-semibold text-white/50 uppercase mt-2">Wali Kelas</div>
                        
                        <a href="{{ route('guru.walikelas.rekap') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-white/10 transition {{ Request::routeIs('guru.walikelas.rekap') ? 'bg-white/20' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            Rekap & Rapor
                        </a>

                        {{-- LOGIKA TOMBOL KENAIKAN KELAS --}}
                        @php
                            // Ambil data tahun aktif
                            $tahunAktif = \App\Models\TahunPelajaran::where('is_active', true)->first();
                        @endphp

                        {{-- HANYA MUNCUL JIKA SEMESTER GENAP --}}
                        @if($tahunAktif && $tahunAktif->semester == 'Genap')
                            <a href="{{ route('guru.walikelas.kenaikan') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-white/10 transition {{ Request::routeIs('guru.walikelas.kenaikan') ? 'bg-white/20' : '' }} text-yellow-300 font-bold">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                                Kenaikan Kelas
                            </a>
                        @endif
                        
                    @endif

                @elseif($role == 'walimurid')
                    <a href="{{ route('dashboard.walimurid') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-white/10 transition {{ Request::routeIs('dashboard.walimurid') ? 'bg-white/20' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Dashboard Siswa
                    </a>
                    <a href="{{ route('walimurid.profil') }}" class="flex items-center px-4 py-3 rounded-lg hover:bg-white/10 transition {{ Request::routeIs('walimurid.profil') ? 'bg-white/20' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Profil Lengkap
                    </a>
                @endif
            </nav>

            <div class="p-6 border-t border-white/10">
                <form id="form-logout" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="button" onclick="konfirmasiLogout()" class="flex items-center text-white/80 hover:text-white transition w-full text-left group">
                        <svg class="w-5 h-5 mr-3 group-hover:text-red-300 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Log Out
                    </button>
                </form>
            </div>
        </aside>

        {{-- 3. OVERLAY (LAYAR GELAP SAAT MENU BUKA DI HP) --}}
        <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden md:hidden transition-opacity"></div>

        {{-- 4. KONTEN UTAMA --}}
        <div class="flex-1 flex flex-col h-screen overflow-hidden">
            
            {{-- HEADER MOBILE (HANYA MUNCUL DI HP) --}}
            <header class="md:hidden flex items-center justify-between bg-white h-16 px-4 shadow-sm border-b border-gray-200 z-30">
                <button onclick="toggleSidebar()" class="text-gray-600 focus:outline-none p-2 rounded hover:bg-gray-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                
                <h1 class="font-bold text-[#65825C]">SINILAI</h1>

                <div class="w-8 h-8 bg-gray-200 rounded-full overflow-hidden">
                   @if(Auth::user()->foto)
                        <img src="{{ asset('storage/' . Auth::user()->foto) }}" class="w-full h-full object-cover">
                   @else
                        <svg class="w-full h-full text-gray-400 p-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                   @endif
                </div>
            </header>

            {{-- ISI KONTEN (SCROLLABLE) --}}
            <main class="flex-1 overflow-y-auto p-4 md:p-8 bg-gray-100">
                @yield('content')
            </main>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // 1. LOADING SCREEN
        window.addEventListener('load', function() {
            const preloader = document.getElementById('preloader');
            preloader.classList.add('opacity-0');
            setTimeout(() => { preloader.style.display = 'none'; }, 500);
        });

        // 2. TOGGLE SIDEBAR MOBILE
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            // Cek apakah sidebar sedang 'translate-x-full' (tersembunyi ke kiri)
            if (sidebar.classList.contains('-translate-x-full')) {
                // BUKA MENU
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            } else {
                // TUTUP MENU
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        }

        // 3. SUARA & SWEETALERT (KODE LAMA ANDA)
        function mainkanSuaraBandel() {
            let audio = new Audio("{{ asset('sounds/error.mp3') }}"); 
            audio.volume = 0.6;
            audio.play().catch(error => { console.log("Audio blocked:", error); });
        }

        @if(session('alert-bandel'))
            Swal.fire({
                icon: 'warning', title: 'Akses Ditolak!', text: "{{ session('alert-bandel') }}",
                confirmButtonColor: '#d33', confirmButtonText: 'Kembali', allowOutsideClick: false,
                didOpen: () => { mainkanSuaraBandel(); }
            });
        @endif

        @if(session('error'))
            Swal.fire({ icon: 'error', title: 'Gagal', text: "{{ session('error') }}", confirmButtonColor: '#65825C' });
        @endif

        @if(session('success'))
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", timer: 3000, showConfirmButton: false });
        @endif

        function konfirmasiLogout() {
            Swal.fire({
                title: 'Ingin Keluar?', text: "Sesi Anda akan diakhiri saat ini.", icon: 'question',
                showCancelButton: true, confirmButtonColor: '#d33', cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Keluar!', cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) { document.getElementById('form-logout').submit(); }
            })
        }
    </script>
</body>
</html>