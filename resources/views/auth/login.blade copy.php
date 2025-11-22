

@section('content')
<div class="bg-white rounded-xl shadow-2xl overflow-hidden flex flex-col md:flex-row w-full max-w-4xl mx-auto min-h-[550px]">
    
    {{-- ============================================================ --}}
    {{-- BAGIAN KIRI (HIJAU) - SEKARANG ADA LOGONYA --}}
    {{-- ============================================================ --}}
    <div class="w-full md:w-5/12 bg-[#65825C] hidden md:flex flex-col items-center justify-center p-12 relative overflow-hidden text-white">
        
        {{-- Hiasan Background (Lingkaran samar agar estetik) --}}
        <div class="absolute -top-10 -left-10 w-40 h-40 bg-white opacity-10 rounded-full blur-2xl"></div>
        <div class="absolute bottom-10 right-10 w-20 h-20 bg-yellow-400 opacity-20 rounded-full blur-xl"></div>

        {{-- LOGO UTAMA (Besar) --}}
        <div class="w-40 h-40 bg-white rounded-full border-4 border-yellow-400 shadow-2xl flex items-center justify-center overflow-hidden p-2 relative z-10 mb-6">
            <img src="{{ asset('images/SD.png') }}" alt="Logo Sekolah" class="w-full h-full object-contain rounded-full">
        </div>

        {{-- Teks Sekolah --}}
        <h2 class="text-3xl font-bold text-center relative z-10">SD ALDENAIRE</h2>
        <p class="text-green-100 text-center text-sm mt-2 relative z-10 opacity-90">
            Sistem Informasi Nilai & Akademik
        </p>
    </div>


    {{-- ============================================================ --}}
    {{-- BAGIAN KANAN (PUTIH) - FORM LOGIN --}}
    {{-- ============================================================ --}}
    <div class="w-full md:w-7/12 bg-white p-10 flex flex-col justify-center">
        
        {{-- LOGO VERSI HP (Hanya muncul di Mobile/Layar Kecil) --}}
        <div class="flex justify-center mb-6 md:hidden">
            <div class="w-20 h-20 bg-white rounded-full border-4 border-yellow-400 shadow-lg flex items-center justify-center overflow-hidden p-1">
                <img src="{{ asset('images/SD.png') }}" alt="Logo Sekolah" class="w-full h-full object-contain rounded-full">
            </div>
        </div>
        
        <h1 class="text-2xl font-bold text-black mb-2 text-center">Selamat Datang!</h1>
        <p class="text-gray-500 text-sm mb-8 text-center">Silahkan login untuk melanjutkan akses.</p>

        <form id="loginForm" action="{{ route('login.process', $role) }}" method="POST" class="space-y-5">
            @csrf
            
            {{-- 1. LOGIN WALI MURID --}}
            @if($role == 'walimurid')
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1 uppercase">Nama</label>
                    <input type="text" name="name" class="w-full bg-gray-100 border border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-[#65825C] focus:border-transparent focus:outline-none transition" placeholder="Masukkan Nama Siswa">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1 uppercase">NISN</label>
                    <input type="text" name="nisn" class="w-full bg-gray-100 border border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-[#65825C] focus:border-transparent focus:outline-none transition" placeholder="Nomor Induk Siswa Nasional">
                    <div class="text-right mt-1">
                        <a href="#" class="text-xs text-[#65825C] font-semibold hover:underline">Lupa NISN?</a>
                    </div>
                </div>

            {{-- 2. LOGIN ADMIN --}}
            @elseif($role == 'admin')
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1 uppercase">Username Admin</label>
                    <input type="text" name="id_admin" class="w-full bg-gray-100 border border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-[#65825C] focus:border-transparent focus:outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1 uppercase">Password</label>
                    <input type="password" name="password" class="w-full bg-gray-100 border border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-[#65825C] focus:border-transparent focus:outline-none transition">
                </div>

            {{-- 3. LOGIN GURU --}}
            @elseif($role == 'guru')
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1 uppercase">NIP / Username</label>
                    <input type="text" name="username" class="w-full bg-gray-100 border border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-[#65825C] focus:border-transparent focus:outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1 uppercase">Password</label>
                    <input type="password" name="password" class="w-full bg-gray-100 border border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-[#65825C] focus:border-transparent focus:outline-none transition">
                </div>
            @endif

            <div class="pt-2">
                <button type="submit" class="w-full bg-[#65825C] hover:bg-[#546e4b] text-white font-bold py-3 px-8 rounded-lg shadow-lg transition duration-300 flex items-center justify-center gap-2 text-sm transform hover:-translate-y-1">
                    LOGIN SEKARANG
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>
            
            <div class="text-center mt-4 border-t pt-4">
                <a href="{{ route('landing') }}" class="text-xs text-gray-400 hover:text-[#65825C] transition flex items-center justify-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Halaman Utama
                </a>
            </div>

        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Tangkap event submit form
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        // Tampilkan Loading SweetAlert
        Swal.fire({
            title: 'Mohon Tunggu...',
            text: 'Sedang memverifikasi akun Anda',
            allowOutsideClick: false, // User gabisa tutup paksa
            allowEscapeKey: false,
            showConfirmButton: false, // Hilangkan tombol OK
            didOpen: () => {
                Swal.showLoading(); // Munculkan animasi putar-putar
            }
        });
    });

    // -- Cek jika ada error validasi dari Laravel (Login Gagal)
   // @if (session('error'))
     //   Swal.fire({
       //     title: 'Login Gagal',
         //   text: '{{ session('error') }}',
           // icon: 'error',
           // confirmButtonText: 'OK'
      //  });
   // @endif
 
</script>
@endsection