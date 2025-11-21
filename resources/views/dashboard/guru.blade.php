@extends('layouts.dashboard')

@section('content')
<div class="space-y-6">
    
    <div class="bg-white rounded-xl shadow-sm p-6 flex flex-col md:flex-row justify-between items-center border-l-4 border-[#65825C]">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Dashboard Pengajar</h1>
            <p class="text-gray-500 text-sm">Selamat datang, <span class="font-bold text-[#65825C]">{{ Auth::user()->name }}</span></p>
        </div>
        
        <div class="mt-4 md:mt-0 flex items-center bg-gray-50 px-4 py-2 rounded-lg border border-gray-200">
            <span class="text-xs font-bold text-gray-500 mr-3 uppercase tracking-wider">Tahun Ajaran:</span>
            <form action="{{ route('guru.ganti.tahun') }}" method="POST">
                @csrf
                <select name="tahun_id" onchange="this.form.submit()" class="bg-transparent font-bold text-gray-700 text-sm focus:outline-none cursor-pointer">
                    @foreach($listTahun as $t)
                        <option value="{{ $t->id }}" {{ $selectedTahun->id == $t->id ? 'selected' : '' }}>
                            {{ $t->tahun }} - {{ $t->semester }} {{ $t->is_active ? '(Aktif)' : '' }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                <div class="w-28 h-28 mx-auto bg-gradient-to-br from-[#65825C] to-[#a3c966] rounded-full p-1 mb-4 shadow-lg">
                    <div class="w-full h-full bg-white rounded-full overflow-hidden flex items-center justify-center relative">
                        
                        @if(Auth::user()->foto)
                        <img src="{{ asset('storage/' . Auth::user()->foto) }}" alt="Profil" class="w-full h-full object-cover">
                        @else
                        {{-- Icon Default --}}
                        <svg class="w-16 h-16 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                        @endif

                    </div>
                </div>
                
                <h2 class="font-bold text-xl text-gray-800">{{ Auth::user()->name }}</h2>
                <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full font-bold uppercase tracking-wide mt-2 inline-block">Guru Pengajar</span>
                
                <div class="mt-6 text-left space-y-3 border-t pt-4">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">NIP/NUPTK</span>
                        <span class="font-semibold text-gray-700">{{ Auth::user()->username }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Status</span>
                        <span class="font-semibold text-green-600">Aktif</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Total Kelas</span>
                        <span class="font-semibold text-gray-700">{{ $groupedJadwal->flatten()->count() }} Kelas</span>
                    </div>
                </div>
            </div>

            @if(Auth::user()->kelasPerwalian)
            <div class="bg-green-600 bg-to-r from-green-500 to-yellow-500 rounded-xl shadow-md p-6 text-white relative overflow-hidden">
                <div class="absolute right-0 top-0 opacity-10 transform translate-x-2 -translate-y-2">
                    <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path></svg>
                </div>
                <h3 class="text-lg font-bold mb-1">Tugas Tambahan</h3>
                <p class="text-white/90 text-sm mb-4">Anda menjabat sebagai:</p>
                <div class="bg-white/20 rounded-lg p-3 text-center backdrop-blur-sm border border-white/30">
                    <span class="text-xl font-bold">Wali Kelas {{ Auth::user()->kelasPerwalian->nama_kelas }}</span>
                </div>
                <a href="{{ route('guru.walikelas.rekap') }}" class="block mt-4 text-center bg-white text-orange-600 text-sm font-bold py-2 rounded hover:bg-orange-50 transition">
                    Buka Menu Wali Kelas
                </a>
            </div>
            @endif
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h3 class="font-bold text-gray-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#65825C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Jadwal Mengajar & Status Nilai
                    </h3>
                    <span class="bg-[#65825C] text-white text-xs px-2 py-1 rounded">{{ $selectedTahun->tahun }}</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-100 text-gray-600 uppercase text-xs font-bold tracking-wider">
                            <tr>
                                <th class="px-6 py-4 border-b">Mata Pelajaran</th>
                                <th class="px-6 py-4 border-b">Kelas</th>
                                <th class="px-6 py-4 border-b text-center">Status Nilai</th>
                                <th class="px-6 py-4 border-b text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($groupedJadwal as $namaMapel => $items)
                                @foreach($items as $item)
                                    @php
                                        $status = \App\Models\StatusNilai::where('kelas_id', $item->kelas_id)
                                                    ->where('mapel_id', $item->mapel_id)
                                                    ->first();
                                        $isTerkirim = $status && $status->status == 'terkirim';
                                    @endphp
                                    <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                        <td class="px-6 py-4 font-medium text-gray-800">
                                            <div class="flex items-center">
                                                <div class="w-2 h-8 bg-[#65825C] rounded-full mr-3"></div>
                                                {{ $namaMapel }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-md font-semibold text-xs border border-gray-200">
                                                Kelas {{ $item->nama_kelas }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if($isTerkirim)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                                    Terkirim
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                                                    Belum Dikirim
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <a href="{{ route('guru.nilai.create', ['kelas_id' => $item->kelas_id, 'mapel_id' => $item->mapel_id]) }}" class="text-[#65825C] hover:text-[#4a6143] font-semibold text-xs hover:underline">
                                                {{ $isTerkirim ? 'Edit Nilai' : 'Input Nilai' }} &rarr;
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-gray-400">
                                        <svg class="w-12 h-12 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                        <p>Tidak ada jadwal mengajar pada tahun ajaran ini.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="mt-4 bg-blue-50 border border-blue-100 rounded-lg p-4 flex items-start gap-3">
                <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div class="text-sm text-blue-800">
                    <p class="font-bold mb-1">Catatan Guru:</p>
                    <p class="opacity-80">Pastikan Anda memilih tahun ajaran yang benar di bagian atas sebelum menginput nilai. Jika status "Terkirim", Anda masih dapat mengedit nilai selama akses belum ditutup oleh Admin.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection