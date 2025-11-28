<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SINILAI - Sistem Informasi Nilai SD Aldenaire</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    {{-- 1. PRELOADER (Sama seperti dashboard) --}}
    <div id="preloader" class="fixed inset-0 z-[9999] bg-white flex flex-col items-center justify-center transition-opacity duration-500">
        <div class="relative flex justify-center items-center">
            <div class="absolute animate-ping w-24 h-24 rounded-full bg-green-200 opacity-75"></div>
            <div class="relative w-20 h-20 bg-white rounded-full border-4 border-yellow-400 shadow-lg flex items-center justify-center p-1 z-10">
                <img src="{{ asset('images/logo-sekolah.jpg') }}" class="w-full h-full object-contain rounded-full animate-pulse">
            </div>
        </div>
        <p class="mt-4 text-[#65825C] font-bold text-sm tracking-widest animate-pulse">MEMUAT...</p>
    </div>

    {{-- CONTAINER UTAMA --}}
    <div class="min-h-screen flex flex-col relative overflow-hidden">
        
        {{-- Background Hiasan --}}
        <div class="absolute top-0 left-0 w-full h-96 bg-[#65825C] rounded-b-[50px] md:rounded-b-[100px] z-0"></div>
        <div class="absolute top-10 left-10 w-40 h-40 bg-white opacity-10 rounded-full blur-3xl"></div>
        <div class="absolute top-20 right-20 w-60 h-60 bg-yellow-400 opacity-10 rounded-full blur-3xl"></div>

        {{-- KONTEN --}}
        <div class="relative z-10 container mx-auto px-4 md:px-10 flex-1 flex flex-col justify-center py-10">
            
            {{-- HEADER: Logo & Judul --}}
            <div class="text-center mb-12">
                <div class="w-28 h-28 mx-auto bg-white rounded-full border-4 border-yellow-400 shadow-xl flex items-center justify-center p-2 mb-6 transform hover:scale-105 transition duration-500">
                    <img src="{{ asset('images/SD.png') }}" alt="Logo Sekolah" class="w-28 h-28 object-contain rounded-full">
                </div>
                <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-2 tracking-tight drop-shadow-md">
                    SINILAI
                </h1>
                <p class="text-green-100 text-sm md:text-lg font-light">
                    Sistem Informasi Nilai & Akademik <br> <span class="font-semibold text-yellow-300">SD Aldenaire</span>
                </p>
            </div>

            {{-- PILIHAN LOGIN (RESPONSIF GRID) --}}
            <div class="max-w-5xl mx-auto w-full">
                <p class="text-center text-white/80 mb-6 text-sm uppercase tracking-wider font-semibold">Silakan Pilih Akses Masuk:</p>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    {{-- CARD 1: WALI MURID --}}
                    <a href="{{ route('login.form', 'walimurid') }}" class="group bg-white rounded-2xl shadow-lg p-8 text-center hover:shadow-2xl transition transform hover:-translate-y-2 border-b-4 border-green-500 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-20 h-20 bg-green-100 rounded-bl-full -mr-10 -mt-10 transition group-hover:scale-150"></div>
                        
                        <div class="w-16 h-16 mx-auto bg-green-100 text-green-600 rounded-full flex items-center justify-center mb-4 relative z-10 group-hover:bg-green-600 group-hover:text-white transition">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Wali Murid</h3>
                        <p class="text-xs text-gray-500 mb-6">Cek nilai dan perkembangan siswa.</p>
                        <span class="inline-block bg-green-50 text-green-700 px-4 py-2 rounded-full text-xs font-bold group-hover:bg-green-600 group-hover:text-white transition">Masuk Sekarang &rarr;</span>
                    </a>

                    {{-- CARD 2: GURU --}}
                    <a href="{{ route('login.form', 'guru') }}" class="group bg-white rounded-2xl shadow-lg p-8 text-center hover:shadow-2xl transition transform hover:-translate-y-2 border-b-4 border-blue-500 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-20 h-20 bg-blue-100 rounded-bl-full -mr-10 -mt-10 transition group-hover:scale-150"></div>
                        
                        <div class="w-16 h-16 mx-auto bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mb-4 relative z-10 group-hover:bg-blue-600 group-hover:text-white transition">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Guru</h3>
                        <p class="text-xs text-gray-500 mb-6">Input nilai dan kelola kelas.</p>
                        <span class="inline-block bg-blue-50 text-blue-700 px-4 py-2 rounded-full text-xs font-bold group-hover:bg-blue-600 group-hover:text-white transition">Masuk Sekarang &rarr;</span>
                    </a>

                    {{-- CARD 3: ADMIN --}}
                    <a href="{{ route('login.form', 'admin') }}" class="group bg-white rounded-2xl shadow-lg p-8 text-center hover:shadow-2xl transition transform hover:-translate-y-2 border-b-4 border-yellow-500 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-20 h-20 bg-yellow-100 rounded-bl-full -mr-10 -mt-10 transition group-hover:scale-150"></div>
                        
                        <div class="w-16 h-16 mx-auto bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center mb-4 relative z-10 group-hover:bg-yellow-500 group-hover:text-white transition">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Administrator</h3>
                        <p class="text-xs text-gray-500 mb-6">Pengaturan sistem sekolah.</p>
                        <span class="inline-block bg-yellow-50 text-yellow-700 px-4 py-2 rounded-full text-xs font-bold group-hover:bg-yellow-500 group-hover:text-white transition">Masuk Sekarang &rarr;</span>
                    </a>

                </div>
            </div>
        </div>

        {{-- FOOTER --}}
        <footer class="relative z-10 py-6 text-center text-gray-500 text-xs">
            &copy; {{ date('Y') }} SD Aldenaire. All rights reserved.
        </footer>

    </div>

    {{-- SCRIPT PRELOADER --}}
    <script>
        window.addEventListener('load', function() {
            const preloader = document.getElementById('preloader');
            preloader.classList.add('opacity-0');
            setTimeout(() => {
                preloader.style.display = 'none';
            }, 500);
        });
    </script>
</body>
</html>