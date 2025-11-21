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
    <div class="glass-overlay absolute inset-0 z-0"></div>
    
    <div class="relative z-10 w-full max-w-4xl px-4">
        @yield('content')
    </div>

    <script>
        // Script sederhana untuk interaksi
        @yield('scripts')
    </script>
</body>
</html>