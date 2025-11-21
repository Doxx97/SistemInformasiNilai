@extends('layouts.dashboard')

@section('content')
<div class="max-w-4xl mx-auto">

    <a href="{{ route('dashboard.walimurid') }}" class="inline-flex items-center text-gray-600 hover:text-[#65825C] mb-6 font-medium transition">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Dashboard
    </a>

        <div class="bg-[#65825C] p-8 text-center relative">
            <div class="w-32 h-32 mx-auto bg-white p-1 rounded-full shadow-xl mb-4 relative z-10 flex items-center justify-center">
                <div class="w-full h-full bg-gray-100 rounded-full overflow-hidden flex items-center justify-center text-gray-400">
                    @if($siswa->foto)
                        <img src="{{ asset('storage/' . $siswa->foto) }}" alt="Profil Siswa" class="w-full h-full object-cover">
                    @else
                        <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                    @endif
                </div>
            </div>
            <h1 class="text-2xl font-bold text-white">{{ $siswa->name }}</h1>
            <p class="text-green-100 text-sm mt-1">Peserta Didik SD Aldenaire</p>

            <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-10">
                <div class="absolute -top-10 -left-10 w-40 h-40 bg-white rounded-full blur-3xl"></div>
                <div class="absolute top-10 right-10 w-20 h-20 bg-yellow-300 rounded-full blur-2xl"></div>
            </div>
        </div>

        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                
                <div>
                    <h3 class="font-bold text-gray-800 text-lg mb-4 flex items-center border-b pb-2">
                        <svg class="w-5 h-5 mr-2 text-[#65825C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        Data Akademik
                    </h3>
                    <div class="space-y-4">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-xs text-gray-500 uppercase tracking-wider">Nomor Induk Siswa Nasional</p>
                            <p class="font-bold text-gray-800 text-lg">{{ $siswa->username }}</p>
                        </div>
                        <div class="flex gap-4">
                            <div class="bg-gray-50 p-4 rounded-lg w-full">
                                <p class="text-xs text-gray-500 uppercase tracking-wider">Kelas</p>
                                <p class="font-bold text-gray-800 text-lg">{{ $siswa->kelas->nama_kelas ?? '-' }}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg w-full">
                                <p class="text-xs text-gray-500 uppercase tracking-wider">Tahun Masuk</p>
                                <p class="font-bold text-gray-800 text-lg">{{ $siswa->tahun_masuk ?? '2024' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="font-bold text-gray-800 text-lg mb-4 flex items-center border-b pb-2">
                        <svg class="w-5 h-5 mr-2 text-[#65825C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Wali Kelas
                    </h3>
                    @if($siswa->kelas && $siswa->kelas->waliKelas)
                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                            <div class="flex items-center gap-4">
                                
                                {{-- === BAGIAN FOTO/INISIAL === --}}
                                <div class="w-14 h-14 rounded-full overflow-hidden border-2 border-white shadow-md bg-gray-200 flex items-center justify-center">
                                    @if($siswa->kelas->waliKelas->foto)
                                        <img src="{{ asset('storage/' . $siswa->kelas->waliKelas->foto) }}" alt="Wali Kelas" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-blue-600 font-bold text-xl">
                                            {{ substr($siswa->kelas->waliKelas->name, 0, 1) }}
                                        </span>
                                    @endif
                                </div>
                                {{-- ============================ --}}

                                <div>
                                    <p class="font-bold text-gray-800">{{ $siswa->kelas->waliKelas->name }}</p>
                                    <p class="text-xs text-gray-500">NIP: {{ $siswa->kelas->waliKelas->username }}</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="bg-gray-50 p-4 rounded-lg text-gray-400 italic text-sm">
                            Data Wali Kelas belum tersedia.
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-6">
                <h3 class="font-bold text-gray-800 text-lg mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Catatan Dari Wali Kelas
                </h3>
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-r-lg relative">
                    <svg class="absolute top-4 right-4 w-8 h-8 text-yellow-200" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21L14.017 18C14.017 16.8954 13.1216 16 12.017 16H9.01712C7.91255 16 7.01712 16.8954 7.01712 18V21H14.017ZM12.017 2C17.5399 2 22.0171 6.47715 22.0171 12C22.0171 13.5823 21.6486 15.0746 20.9915 16.4139C20.3728 15.5354 19.3661 15 18.0171 15C17.9689 15 17.9211 15.0007 17.8734 15.0021C17.5145 12.2026 15.1173 10 12.0171 10C8.91695 10 6.51971 12.2026 6.16086 15.0021C6.11318 15.0007 6.06537 15 6.01712 15C4.66815 15 3.66142 15.5354 3.04277 16.4139C2.38564 15.0746 2.01712 13.5823 2.01712 12C2.01712 6.47715 6.49428 2 12.017 2Z"></path></svg>
                    
                    @if($siswa->catatan_wali_kelas)
                        <p class="text-gray-700 italic text-lg font-serif leading-relaxed">
                            "{{ $siswa->catatan_wali_kelas }}"
                        </p>
                    @else
                        <p class="text-gray-400 italic">
                            Belum ada catatan khusus dari Wali Kelas.
                        </p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection