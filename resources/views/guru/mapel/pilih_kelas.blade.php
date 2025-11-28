@extends('layouts.dashboard')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Penilaian Siswa</h1>
            <p class="text-gray-500">Mata Pelajaran: <span class="font-bold text-[#65825C]">{{ $mapel->nama_mapel }}</span></p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        @forelse($kelasList as $kelas)
            @php
                // Cek status apakah sudah terkirim
                $cekStatus = \App\Models\StatusNilai::where('kelas_id', $kelas->id)
                            ->where('mapel_id', $mapel->id)
                            ->first();
                $isTerkirim = $cekStatus && $cekStatus->status == 'terkirim';
            @endphp

            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
                <div class="flex justify-between items-start mb-4">
                    <div class="bg-green-50 p-3 rounded-lg">
                        {{-- Panggil nama kelas dari database --}}
                        <span class="text-xl font-bold text-[#65825C]">Kelas {{ $kelas->nama_kelas }}</span>
                    </div>
                    @if($isTerkirim)
                        <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full font-bold">Terkirim</span>
                    @else
                        <span class="bg-gray-100 text-gray-500 text-xs px-2 py-1 rounded-full font-bold">Belum</span>
                    @endif
                </div>
                
                <p class="text-sm text-gray-500 mb-6">Kelola nilai siswa untuk kelas {{ $kelas->nama_kelas }}.</p>
                
                <a href="{{ route('guru.nilai.create', ['kelas_id' => $kelas->id, 'mapel_id' => $mapel->id]) }}" 
                   class="block w-full text-center py-2 rounded-lg font-semibold transition duration-300 {{ $isTerkirim ? 'bg-gray-100 text-gray-600 hover:bg-gray-200' : 'bg-[#65825C] text-white hover:bg-[#546e4b]' }}">
                   {{ $isTerkirim ? 'Edit Nilai' : 'Input Nilai' }}
                </a>
            </div>

        @empty
            <div class="col-span-3 text-center py-12 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-gray-500 font-medium">Anda tidak memiliki jadwal mengajar mata pelajaran ini di tahun ajaran aktif.</p>
                <p class="text-xs text-gray-400 mt-1">Silakan hubungi Admin jika ini kesalahan.</p>
            </div>
        @endforelse
        
    </div>
</div>
@endsection