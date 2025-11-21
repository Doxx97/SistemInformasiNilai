@extends('layouts.app')

@section('content')
<div class="bg-white rounded-xl shadow-2xl overflow-hidden flex flex-col md:flex-row w-full max-w-3xl mx-auto h-[450px]">
    
    <div class="w-full md:w-1/2 bg-[#65825C] flex items-center justify-center p-8 relative">
        <div class="absolute w-48 h-48 bg-white/10 rounded-full blur-2xl"></div>
        
        <div class="text-center relative z-10">
            <div class="w-32 h-32 bg-blue-900 rounded-full border-4 border-yellow-400 flex items-center justify-center mx-auto mb-4 shadow-lg">
                <img src="{{ asset('images/SD.png') }}" 
                         alt="Logo Sekolah" 
                         class="w-full h-full object-contain rounded-full">
            </div>
            <h2 class="text-white font-bold text-xl tracking-widest">ALDENAIRE</h2>
            <p class="text-white/80 text-sm">SEKOLAH DASAR</p>
        </div>
    </div>

    <div class="w-full md:w-1/2 bg-white p-10 flex flex-col justify-center">
        <h1 class="text-2xl font-bold text-black mb-2">Selamat Datang di SINILAI</h1>
        <p class="text-gray-500 text-sm mb-8">Silahkan pilih Anda login sebagai apa</p>

        <div class="space-y-4">
            <div class="relative">
                <select id="roleSelect" class="w-full bg-gray-200 text-gray-700 border-none rounded-md px-4 py-3 focus:ring-2 focus:ring-[#65825C] focus:outline-none appearance-none cursor-pointer">
                    <option value="" disabled selected>Pilih Peran</option>
                    <option value="guru">Guru</option>
                    <option value="admin">Admin</option>
                    <option value="walimurid">Wali Murid</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>

            <button onclick="goToLogin()" class="bg-[#6BCB58] hover:bg-[#5ab34a] text-white font-semibold py-2 px-6 rounded-md transition duration-300 w-auto inline-block shadow-md">
                Konfirmasi
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
function goToLogin() {
    const role = document.getElementById('roleSelect').value;
    if (role) {
        // Redirect ke route login form
        window.location.href = "/login/" + role;
    } else {
        alert("Silahkan pilih peran terlebih dahulu!");
    }
}
@endsection