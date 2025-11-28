@extends('layouts.dashboard')

@section('content')
<div class="space-y-8">
    
    {{-- HEADER HALAMAN --}}
    <div class="flex flex-col md:flex-row justify-between items-center bg-white p-6 rounded-xl shadow-sm border-l-4 border-yellow-500">
        <div class="mb-4 md:mb-0">
            <h1 class="text-2xl font-bold text-gray-800">Leger & Rapor Siswa</h1>
            <p class="text-gray-600 flex items-center gap-2 mt-1">
                <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-2 py-1 rounded uppercase">Wali Kelas</span>
                <span class="font-bold text-lg">{{ $kelas->nama_kelas }}</span>
            </p>
        </div>
        <div class="text-right">
            <p class="text-sm text-gray-500 uppercase tracking-wider">Tahun Pelajaran</p>
            <p class="font-bold text-xl text-gray-800">{{ $tahunAktif->tahun ?? '-' }} <span class="text-sm font-normal text-gray-500">({{ $tahunAktif->semester ?? '' }})</span></p>
        </div>
    </div>

    {{-- PANEL STATUS PUBLISH --}}
    <div class="bg-white p-6 rounded-xl shadow-sm flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h3 class="font-bold text-gray-700 mb-1">Status Rapor</h3>
            @if($isPublished)
                <div class="flex items-center gap-2 text-green-700 font-bold text-sm uppercase">
                    <span class="w-3 h-3 bg-green-500 rounded-full"></span> Sudah Terbit
                </div>
            @else
                <div class="flex items-center gap-2 text-orange-700 font-bold text-sm uppercase">
                    <span class="w-3 h-3 bg-orange-500 rounded-full"></span> Masih Draft
                </div>
            @endif
        </div>
        <div>
            @if($isPublished)
                <form action="{{ route('guru.walikelas.unpublish') }}" method="POST" onsubmit="return confirm('Tarik kembali rapor?');">
                    @csrf <button type="submit" class="bg-gray-100 text-gray-600 px-4 py-2 rounded-lg text-sm font-bold hover:bg-red-50 hover:text-red-600 transition">Tarik Kembali</button>
                </form>
            @else
                <form action="{{ route('guru.walikelas.publish') }}" method="POST" onsubmit="return confirm('Terbitkan rapor sekarang?');">
                    @csrf <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg text-sm font-bold hover:bg-blue-700 transition">Terbitkan Rapor</button>
                </form>
            @endif
        </div>
    </div>

    {{-- ========================================================= --}}
    {{-- TABEL 1: LEGER NILAI AKADEMIK --}}
    {{-- ========================================================= --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-4 border-b bg-gray-50 flex justify-between items-center">
            <h3 class="font-bold text-gray-800 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                1. Daftar Nilai Akademik Siswa
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse border border-gray-200">
                <thead class="bg-gray-800 text-white font-bold text-xs uppercase text-center">
                    <tr>
                        <th class="p-3 border border-gray-600 w-10 sticky left-0 bg-gray-800">No</th>
                        <th class="p-3 border border-gray-600 w-48 text-left sticky left-10 bg-gray-800">Nama Siswa</th>
                        @foreach($mapels as $m)
                            <th class="p-2 border border-gray-600 w-24 text-[10px]">{{ $m->nama_mapel }}</th>
                        @endforeach
                        <th class="p-2 border border-gray-600 w-24 bg-gray-700">Rata-rata</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach($siswas as $index => $siswa)
                    <tr class="hover:bg-gray-50 border-b border-gray-200 transition">
                        <td class="p-2 text-center border border-gray-200 sticky left-0 bg-white">{{ $index + 1 }}</td>
                        <td class="p-2 font-bold border border-gray-200 sticky left-10 bg-white">{{ $siswa->name }}</td>
                        
                        @php $totalNilai = 0; $jmlMapel = 0; @endphp
                        @foreach($mapels as $m)
                            @php
                                $nilaiMapel = $siswa->nilais->where('mapel_id', $m->id)->first();
                                $angka = $nilaiMapel ? $nilaiMapel->nilai : 0;
                                if($nilaiMapel) { $totalNilai += $angka; $jmlMapel++; }
                            @endphp
                            <td class="p-2 text-center border border-gray-200 {{ $nilaiMapel ? 'font-bold' : 'text-gray-300' }}">
                                {{ $nilaiMapel ? $nilaiMapel->nilai : '-' }}
                            </td>
                        @endforeach
                        
                        <td class="p-2 text-center border border-gray-200 font-bold bg-gray-50">
                            {{ $jmlMapel > 0 ? round($totalNilai / $jmlMapel, 1) : '-' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- ========================================================= --}}
    {{-- TABEL 2: REKAPITULASI ABSENSI & CETAK (DIUPDATE) --}}
    {{-- ========================================================= --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden mt-6 border-t-4 border-purple-500">
        <div class="p-4 border-b bg-gray-50 flex justify-between items-center">
            <h3 class="font-bold text-gray-800 flex items-center">
                <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                2. Rekapitulasi Absensi & Catatan
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse border border-gray-200">
                <thead class="bg-gray-800 text-white font-bold text-xs uppercase text-center">
                    <tr>
                        <th class="p-3 border border-gray-600 w-10">No</th>
                        {{-- KOLOM NAMA DIPERLEBAR UNTUK TOMBOL CETAK --}}
                        <th class="p-3 border border-gray-600 w-64 text-left">Nama </th>
                        
                        <th class="p-3 border border-gray-600 w-16 bg-yellow-700">Sakit</th>
                        <th class="p-3 border border-gray-600 w-16 bg-blue-800">Izin</th>
                        <th class="p-3 border border-gray-600 w-16 bg-red-800">Alpha</th>
                        <th class="p-3 border border-gray-600 w-24 bg-gray-700">Mapel Masuk</th>

                        <th class="p-3 border border-gray-600">Catatan Wali Kelas</th>
                        {{-- KOLOM AKSI DIHAPUS KARENA SUDAH PINDAH --}}
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach($siswas as $index => $siswa)
                    <tr class="hover:bg-gray-50 border-b border-gray-200 transition">
                        <td class="p-3 text-center border border-gray-200 font-bold align-top">{{ $index + 1 }}</td>
                        
                        {{-- NAMA SISWA & TOMBOL CETAK DI BAWAHNYA --}}
                        <td class="p-3 border border-gray-200 align-top">
                            <div class="font-bold text-gray-800 text-base mb-2">{{ $siswa->name }}</div>
                            
                            {{-- TOMBOL CETAK PINDAH KESINI --}}
                            <a href="{{ route('guru.walikelas.rapor', $siswa->id) }}" target="_blank" class="inline-flex items-center bg-purple-100 hover:bg-purple-200 text-purple-700 px-3 py-1.5 rounded-lg text-xs font-bold transition border border-purple-200">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                Cetak Rapor
                            </a>
                        </td>
                        
                        {{-- DATA ABSENSI --}}
                        <td class="p-3 text-center border border-gray-200 font-bold text-yellow-700 bg-yellow-50 align-top">{{ $siswa->total_sakit }}</td>
                        <td class="p-3 text-center border border-gray-200 font-bold text-blue-700 bg-blue-50 align-top">{{ $siswa->total_izin }}</td>
                        <td class="p-3 text-center border border-gray-200 font-bold text-red-700 bg-red-50 align-top">{{ $siswa->total_alpha }}</td>
                        
                        <td class="p-3 text-center border border-gray-200 text-xs text-gray-500 align-top">
                            {{ $siswa->mapel_terkirim ?? 0 }} Mapel
                        </td>

                        {{-- INPUT CATATAN --}}
                        <td class="p-2 border border-gray-200 bg-yellow-50 align-top">
                            <form action="{{ route('guru.walikelas.update_catatan', $siswa->id) }}" method="POST" class="flex flex-col gap-2">
                                @csrf
                                <textarea name="catatan" rows="2" class="w-full text-xs p-2 rounded border border-yellow-300 focus:ring-2 focus:ring-yellow-500 outline-none resize-none" placeholder="Tulis catatan...">{{ $siswa->catatan_wali_kelas }}</textarea>
                                <div class="text-right">
                                    <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded shadow text-xs" title="Simpan">Simpan Catatan</button>
                                </div>
                            </form>
                        </td>

                        {{-- KOLOM AKSI PALING KANAN SUDAH DIHILANGKAN --}}
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection