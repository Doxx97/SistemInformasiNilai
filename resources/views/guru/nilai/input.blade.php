@extends('layouts.dashboard')

@section('content')
<div class="space-y-6">
    
    {{-- Header --}}
    <div class="bg-[#65825C] p-6 rounded-xl text-white shadow-lg flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold">Input Nilai Lengkap</h1>
            <p class="opacity-90">Mata Pelajaran: <span class="font-bold text-yellow-300">{{ $mapel->nama_mapel }}</span></p>
            <p class="text-sm opacity-75">Kelas: {{ $kelas->nama_kelas }}</p>
        </div>
        <div class="text-right">
             <a href="{{ route('dashboard.guru') }}" class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-lg text-sm transition">Kembali</a>
        </div>
    </div>

    {{-- Form Input --}}
    <form action="{{ route('guru.nilai.store') }}" method="POST" id="formNilai">
        @csrf
        <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
        <input type="hidden" name="mapel_id" value="{{ $mapel->id }}">
        <input type="hidden" name="tahun_pelajaran_id" value="{{ $tahunAktif->id ?? '' }}">

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            
            {{-- TABEL SCROLLABLE --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left border-collapse min-w-[1200px]"> 
                    <thead class="bg-gray-800 text-white uppercase text-xs text-center sticky top-0 z-10">
                        <tr>
                            <th rowspan="2" class="p-3 border border-gray-600 w-10 sticky left-0 bg-gray-800 z-20">No</th>
                            <th rowspan="2" class="p-3 border border-gray-600 w-64 sticky left-10 bg-gray-800 z-20">Nama Siswa</th>
                            
                            <th colspan="10" class="p-2 border border-gray-600 bg-blue-900">Nilai Harian</th>
                            
                            <th rowspan="2" class="p-2 border border-gray-600 bg-yellow-700 w-20">UTS</th>
                            <th rowspan="2" class="p-2 border border-gray-600 bg-yellow-700 w-20">UAS</th>
                            <th rowspan="2" class="p-2 border border-gray-600 bg-green-800 w-20">Akhir</th>
                            {{-- KOLOM RESET SUDAH DIHAPUS --}}
                        </tr>
                        <tr>
                            @for($i=1; $i<=10; $i++)
                                <th class="p-2 border border-gray-600 w-16">P{{ $i }}</th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @foreach($siswas as $index => $siswa)
                        @php
                            $dataNilai = \App\Models\Nilai::where('siswa_id', $siswa->id)
                                            ->where('mapel_id', $mapel->id)
                                            ->where('tahun_pelajaran_id', $tahunAktif->id ?? 0)
                                            ->first();
                            $harian = $dataNilai ? $dataNilai->detail_harian : [];
                        @endphp
                        
                        <tr class="hover:bg-gray-50 border-b transition group">
                            <td class="p-3 text-center border sticky left-0 bg-white group-hover:bg-gray-50 z-10">{{ $index + 1 }}</td>
                            <td class="p-3 font-bold border sticky left-10 bg-white group-hover:bg-gray-50 z-10 shadow-sm">
                                {{ $siswa->name }}
                                <input type="hidden" name="siswa_id[]" value="{{ $siswa->id }}">
                            </td>

                            {{-- Harian --}}
                            @for($i=1; $i<=10; $i++)
                                <td class="p-1 border">
                                    <input type="number" name="harian[{{ $siswa->id }}][{{ $i }}]" value="{{ $harian[$i] ?? '' }}" class="w-full text-center p-1.5 rounded border-gray-300 focus:ring-2 focus:ring-blue-500 outline-none input-nilai" min="0" max="100" placeholder="-">
                                </td>
                            @endfor

                            {{-- UTS --}}
                            <td class="p-1 border bg-yellow-50">
                                <input type="number" name="uts[{{ $siswa->id }}]" value="{{ $dataNilai ? ($dataNilai->uts == 0 ? '' : $dataNilai->uts) : '' }}" class="w-full text-center p-1.5 rounded border-yellow-300 focus:ring-2 focus:ring-yellow-500 outline-none font-bold input-ujian" min="0" max="100">
                            </td>

                            {{-- UAS --}}
                            <td class="p-1 border bg-yellow-50">
                                <input type="number" name="uas[{{ $siswa->id }}]" value="{{ $dataNilai ? ($dataNilai->uas == 0 ? '' : $dataNilai->uas) : '' }}" class="w-full text-center p-1.5 rounded border-yellow-300 focus:ring-2 focus:ring-yellow-500 outline-none font-bold input-ujian" min="0" max="100">
                            </td>

                            {{-- Nilai Akhir --}}
                            <td class="p-2 text-center font-bold text-lg text-green-700 border bg-green-50">
                                {{ $dataNilai->nilai ?? '-' }}
                            </td>

                            {{-- TOMBOL HAPUS SUDAH DIHILANGKAN --}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- FOOTER --}}
            <div class="p-6 bg-gray-50 border-t flex justify-between items-center">
                <div class="text-xs text-gray-500 italic">
                    * Nilai Akhir = (50% Rata-rata Harian) + (25% UTS) + (25% UAS).
                </div>
                <div class="flex gap-3">
                    <button type="submit" name="aksi" value="simpan_draft" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2.5 rounded-lg font-bold shadow-md flex items-center transition">Simpan Draft</button>
                    <button type="submit" id="btnKirim" name="aksi" value="kirim_wali" class="hidden bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-lg font-bold shadow-md flex items-center transition animate-bounce">Kirim ke Wali Kelas</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputsUjian = document.querySelectorAll('.input-ujian');
        const btnKirim = document.getElementById('btnKirim');

        function cekKelengkapan() {
            let lengkap = true;
            let jumlahDiisi = 0;
            inputsUjian.forEach(input => {
                if (input.value.trim() !== '') { jumlahDiisi++; } else { lengkap = false; }
            });
            if (lengkap && inputsUjian.length > 0) {
                btnKirim.classList.remove('hidden');
                btnKirim.classList.add('flex');
            } else {
                btnKirim.classList.add('hidden');
                btnKirim.classList.remove('flex');
            }
        }
        inputsUjian.forEach(input => { input.addEventListener('input', cekKelengkapan); });
        cekKelengkapan();
    });
</script>
@endsection