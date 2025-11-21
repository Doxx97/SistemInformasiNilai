<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SINILAI - Aldenaire</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        /* Background Image Blur Effect */
        .bg-school {
            background-image: url('https://images.unsplash.com/photo-1580582932707-520aed937b7b?q=80&w=2000&auto=format&fit=crop'); /* Gambar sekolah dummy */
            background-size: cover;
            background-position: center;
        }
        .glass-overlay {
            background-color: rgba(101, 130, 92, 0.6); /* Warna hijau transparan overlay */
            backdrop-filter: blur(4px);
        }
    </style>
</head>
<body class="bg-school min-h-screen flex items-center justify-center">
    <div id="preloader" class="fixed inset-0 z-[9999] bg-white flex flex-col items-center justify-center transition-opacity duration-500">
        <div class="relative flex justify-center items-center">
            <div class="absolute animate-ping w-24 h-24 rounded-full bg-green-200 opacity-75"></div>
            <div class="relative w-20 h-20 bg-white rounded-full border-4 border-yellow-400 shadow-lg flex items-center justify-center p-1 z-10">
                {{-- GANTI DENGAN LOGO ANDA --}}
                <img src="{{ asset('images/SD.png') }}" class="w-full h-full object-contain rounded-full animate-pulse">
            </div>
        </div>
        <p class="mt-4 text-[#65825C] font-bold text-sm tracking-widest animate-pulse">MEMUAT...</p>
    </div>
    <div class="glass-overlay absolute inset-0 z-0"></div>
    
    <div class="relative z-10 w-full max-w-4xl px-4">
        @yield('content')
    </div>

    <script>
        // Script sederhana untuk interaksi
        @yield('scripts')
        window.addEventListener('load', function() {
            const preloader = document.getElementById('preloader');
            preloader.classList.add('opacity-0'); // Efek Fade Out
            
            setTimeout(() => {
                preloader.style.display = 'none'; // Hilangkan elemen
            }, 500); // Tunggu 0.5 detik sesuai durasi transisi
        });
    </script>
</body>
</html>