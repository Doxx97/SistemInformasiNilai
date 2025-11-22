<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SINILAI</title>
    <link rel="icon" href="{{ asset('images/title.png') }}" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        /* Efek Kaca Frosted Glass */
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
    </style>
</head>
<body>

    <div id="preloader" class="fixed inset-0 z-[9999] bg-white flex flex-col items-center justify-center transition-opacity duration-500">
        <div class="relative flex justify-center items-center">
            <div class="absolute animate-ping w-24 h-24 rounded-full bg-green-200 opacity-75"></div>
            <div class="relative w-20 h-20 bg-white rounded-full border-4 border-yellow-400 shadow-lg flex items-center justify-center p-1 z-10">
                <img src="{{ asset('images/SD.png') }}" class="w-full h-full object-contain rounded-full animate-pulse">
            </div>
        </div>
        <p class="mt-4 text-[#65825C] font-bold text-sm tracking-widest animate-pulse">MEMUAT...</p>
    </div>

    <div class="min-h-screen w-full flex items-center justify-center relative px-4 py-10 overflow-hidden">
        
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1580582932707-520aed937b7b?q=80&w=2064&auto=format&fit=crop')] bg-cover bg-center scale-105"></div>
        
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-[3px]"></div>

        <div class="relative z-10 w-full max-w-lg glass-card rounded-3xl shadow-2xl p-8 md:p-10 animate-fade-in-up">
            
            <div class="text-center mb-8">
                <div class="w-20 h-20 mx-auto bg-white rounded-full border-4 border-yellow-400 shadow-lg flex items-center justify-center p-1 mb-4">
                    <img src="{{ asset('images/SD.png') }}" alt="Logo" class="w-full h-full object-contain rounded-full">
                </div>
                
                <h2 class="text-gray-500 text-xs font-bold tracking-widest uppercase mb-1">Selamat Datang</h2>
                <h1 class="text-2xl font-extrabold text-gray-800">
                    Login 
                    @if($role == 'walimurid') <span class="text-green-600">Wali Murid</span>
                    @elseif($role == 'guru') <span class="text-blue-600">Guru</span>
                    @elseif($role == 'admin') <span class="text-yellow-600">Admin</span>
                    @endif
                </h1>
                <p class="text-gray-500 text-sm mt-1">Masukkan akun Anda untuk melanjutkan.</p>
            </div>

            <form id="loginForm" action="{{ route('login.process', $role) }}" method="POST" class="space-y-5">
                @csrf

                {{-- VARIABEL WARNA TOMBOL (Biar Keren) --}}
                @php
                    $btnColor = 'bg-gray-800 hover:bg-gray-900'; // Default
                    if($role == 'walimurid') $btnColor = 'bg-green-600 hover:bg-green-700';
                    if($role == 'guru') $btnColor = 'bg-blue-600 hover:bg-blue-700';
                    if($role == 'admin') $btnColor = 'bg-yellow-500 hover:bg-yellow-600 text-white';
                @endphp

                {{-- 1. INPUT WALI MURID --}}
                @if($role == 'walimurid')
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1 uppercase ml-1">Nama Siswa</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg></span>
                            <input type="text" name="name" class="w-full bg-white/50 border border-gray-300 rounded-xl pl-10 pr-4 py-3 focus:bg-white focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition" placeholder="Nama Lengkap Siswa">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1 uppercase ml-1">NISN</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0c0 .884-.5 2-2 2h4c-1.5 0-2-1.116-2-2z"></path></svg></span>
                            <input type="number" name="nisn" class="w-full bg-white/50 border border-gray-300 rounded-xl pl-10 pr-4 py-3 focus:bg-white focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition" placeholder="Nomor Induk Siswa">
                        </div>
                    </div>

                {{-- 2. INPUT GURU --}}
                @elseif($role == 'guru')
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1 uppercase ml-1">NIP / Username</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg></span>
                            <input type="text" name="username" class="w-full bg-white/50 border border-gray-300 rounded-xl pl-10 pr-4 py-3 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition" placeholder="Username Guru">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1 uppercase ml-1">Password</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg></span>
                            <input type="password" name="password" class="w-full bg-white/50 border border-gray-300 rounded-xl pl-10 pr-4 py-3 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition" placeholder="********">
                        </div>
                    </div>

                {{-- 3. INPUT ADMIN --}}
                @elseif($role == 'admin')
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1 uppercase ml-1">ID Admin</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></span>
                            <input type="text" name="id_admin" class="w-full bg-white/50 border border-gray-300 rounded-xl pl-10 pr-4 py-3 focus:bg-white focus:ring-2 focus:ring-yellow-500 focus:border-transparent outline-none transition" placeholder="Admin Username">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1 uppercase ml-1">Password</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg></span>
                            <input type="password" name="password" class="w-full bg-white/50 border border-gray-300 rounded-xl pl-10 pr-4 py-3 focus:bg-white focus:ring-2 focus:ring-yellow-500 focus:border-transparent outline-none transition" placeholder="********">
                        </div>
                    </div>
                @endif

                <div class="pt-2">
                    <button type="submit" class="w-full {{ $btnColor }} text-white font-bold py-3.5 rounded-xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                        MASUK SEKARANG
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>

                <div class="text-center mt-6">
                    <a href="{{ route('landing') }}" class="text-xs text-gray-500 hover:text-gray-800 font-medium flex items-center justify-center gap-1 transition">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali ke Halaman Utama
                    </a>
                </div>

            </form>
        </div>

        <div class="absolute bottom-4 text-center w-full text-white/40 text-[10px] tracking-wider">
            &copy; {{ date('Y') }} SD Aldenaire. Powered by SINILAI.<br> Support by Hostinger.
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // 1. Preloader Hilang
        window.addEventListener('load', function() {
            const preloader = document.getElementById('preloader');
            preloader.classList.add('opacity-0');
            setTimeout(() => { preloader.style.display = 'none'; }, 500);
        });

        // 2. Loading saat Submit
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            Swal.fire({
                title: 'Memproses...',
                html: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => { Swal.showLoading(); }
            });
        });

        // 3. Notifikasi Error (Dari Laravel)
        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Login Gagal!',
                text: '{{ $errors->first() }}',
                confirmButtonColor: '#d33'
            });
        @endif

        // 4. Notifikasi Error Session
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: "{{ session('error') }}",
                confirmButtonColor: '#d33'
            });
        @endif
    </script>

</body>
</html>