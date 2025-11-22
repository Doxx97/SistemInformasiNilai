<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SINILAI - Selamat Datang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body>

    <div class="min-h-screen w-full flex items-center justify-center bg-[url('https://images.unsplash.com/photo-1580582932707-520aed937b7b?q=80&w=2000&auto=format&fit=crop')]">
        
        <div class="absolute inset-0 bg-white/30 backdrop-blur-md"></div>

        <div class="relative z-10 w-full max-w-4xl bg-white rounded-2xl shadow-2xl overflow-hidden flex flex-col md:flex-row min-h-[500px]">
            
            <div class="w-full md:w-5/12 bg-[#65825C] flex flex-col items-center justify-center p-10 text-center text-white">
                
                <div class="w-32 h-32 bg-white rounded-full border-4 border-yellow-400 flex items-center justify-center p-2 mb-4 shadow-lg">
                    <img src="{{ asset('images/SD.png') }}" alt="Logo" class="w-full h-full object-contain rounded-full">
                </div>

                <h2 class="text-2xl font-bold tracking-wider">ALDENAIRE</h2>
                <p class="text-sm opacity-90 tracking-widest">SEKOLAH DASAR</p>
            </div>

            <div class="w-full md:w-7/12 bg-white p-8 md:p-12 flex flex-col justify-center">
                
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Selamat Datang di SINILAI</h1>
                <p class="text-gray-500 text-sm mb-8">Silahkan pilih Anda login sebagai apa</p>

                <div class="space-y-4">
                    
                    <div class="relative">
                        <select id="roleSelect" class="w-full bg-gray-100 text-gray-700 border border-gray-200 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#65825C] appearance-none cursor-pointer font-medium">
                            <option value="" disabled selected>Pilih Peran</option>
                            <option value="walimurid">Wali Murid</option>
                            <option value="guru">Guru / Pengajar</option>
                            <option value="admin">Administrator</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>

                    <button onclick="goToLogin()" class="w-full md:w-auto bg-[#6ed165] hover:bg-[#5db554] text-white font-bold py-3 px-8 rounded-lg shadow-md transition transform hover:-translate-y-1">
                        Konfirmasi
                    </button>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function goToLogin() {
            const role = document.getElementById('roleSelect').value;
            
            if (role) {
                // Redirect ke halaman login sesuai role
                // URL harus sesuai route di web.php: /login/{role}
                window.location.href = "/login/" + role;
            } else {
                // Peringatan jika belum pilih
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilih Peran Dulu',
                    text: 'Silakan pilih peran Anda (Wali Murid, Guru, atau Admin).',
                    confirmButtonColor: '#65825C'
                });
            }
        }
    </script>

</body>
</html>