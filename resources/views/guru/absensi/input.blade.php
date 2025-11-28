@extends('layouts.dashboard')

@section('content')
<div class="space-y-6">
    
    {{-- HEADER HALAMAN --}}
    <div class="bg-green-600 p-6 rounded-xl text-white shadow-lg flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold flex items-center gap-2">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                Input Absensi Semester
            </h1>
            <div class="mt-2 text-purple-100 text-sm">
                Mata Pelajaran: <span class="font-bold text-white">{{ $mapel->nama_mapel }}</span> | 
                Kelas: <span class="font-bold text-white">{{ $kelas->nama_kelas }}</span>
            </div>
        </div>
        <div>
            <a href="{{ route('dashboard.guru') }}" class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg text-sm font-bold transition flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Dashboard
            </a>
        </div>
    </div>

    {{-- FORM INPUT ABSENSI --}}
    <form action="{{ route('guru.absensi.store') }}" method="POST">
        @csrf
        <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
        <input type="hidden" name="mapel_id" value="{{ $mapel->id }}">
        <input type="hidden" name="tahun_pelajaran_id" value="{{ $tahunAktif->id }}">

        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
            
            {{-- LEGENDA / KETERANGAN --}}
            <div class="p-4 bg-gray-50 border-b flex flex-wrap gap-4 text-xs font-bold text-gray-600">
                <span class="flex items-center"><span class="w-3 h-3 bg-green-500 rounded-full mr-1"></span> H = Hadir</span>
                <span class="flex items-center"><span class="w-3 h-3 bg-blue-500 rounded-full mr-1"></span> I = Izin</span>
                <span class="flex items-center"><span class="w-3 h-3 bg-yellow-500 rounded-full mr-1"></span> S = Sakit</span>
                <span class="flex items-center"><span class="w-3 h-3 bg-red-500 rounded-full mr-1"></span> A = Alpha</span>
            </div>

            {{-- TABEL SCROLLABLE (GRID 1-16) --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left border-collapse min-w-[1500px]">
                    <thead class="bg-gray-800 text-white uppercase text-xs text-center sticky top-0 z-10">
                        <tr>
                            <th rowspan="2" class="p-3 border border-gray-600 w-10 sticky left-0 bg-gray-800 z-20">No</th>
                            <th rowspan="2" class="p-3 border border-gray-600 w-64 sticky left-10 bg-gray-800 z-20 text-left">Nama Siswa</th>
                            
                            {{-- HEADER PERTEMUAN --}}
                            <th colspan="16" class="p-2 border border-gray-600 bg-purple-900">Pertemuan Ke- (1 s/d 16)</th>
                            
                            {{-- HEADER REKAP --}}
                            <th colspan="4" class="p-2 border border-gray-600 bg-gray-700">Total (Rekap)</th>
                        </tr>
                        <tr>
                            {{-- KOLOM ANGKA 1-16 --}}
                            @for($i=1; $i<=16; $i++)
                                <th class="p-1 border border-gray-600 w-12 text-[10px]">{{ $i }}</th>
                            @endfor
                            <th class="p-1 border border-gray-600 w-10 bg-green-900" title="Hadir">H</th>
                            <th class="p-1 border border-gray-600 w-10 bg-blue-900" title="Izin">I</th>
                            <th class="p-1 border border-gray-600 w-10 bg-yellow-900" title="Sakit">S</th>
                            <th class="p-1 border border-gray-600 w-10 bg-red-900" title="Alpha">A</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @foreach($siswas as $index => $siswa)
                        @php
                            // Ambil data absensi siswa ini (jika ada)
                            $dataAbsen = \App\Models\Absensi::where('siswa_id', $siswa->id)
                                            ->where('mapel_id', $mapel->id)
                                            ->where('tahun_pelajaran_id', $tahunAktif->id)
                                            ->first();
                            // Ambil detail JSON-nya (Array)
                            $detail = $dataAbsen ? $dataAbsen->detail_absensi : [];
                        @endphp
                        
                        <tr class="hover:bg-purple-50 border-b group transition">
                            <td class="p-2 text-center border sticky left-0 bg-white group-hover:bg-purple-50 z-10 font-bold">{{ $index + 1 }}</td>
                            <td class="p-2 font-bold border sticky left-10 bg-white group-hover:bg-purple-50 z-10 shadow-sm text-gray-800">
                                {{ $siswa->name }}
                                <input type="hidden" name="siswa_id[]" value="{{ $siswa->id }}">
                            </td>

                            {{-- LOOP INPUT PERTEMUAN 1-16 --}}
                            @for($i=1; $i<=16; $i++)
                                <td class="p-1 border text-center">
                                    {{-- DROPDOWN STATUS --}}
                                    <select name="absensi[{{ $siswa->id }}][{{ $i }}]" 
                                            class="absen-input w-full p-1 text-xs text-center border-none focus:ring-2 focus:ring-purple-500 rounded bg-transparent font-bold cursor-pointer appearance-none
                                            {{ ($detail[$i] ?? '') == 'H' ? 'text-green-600' : '' }}
                                            {{ ($detail[$i] ?? '') == 'I' ? 'text-blue-600' : '' }}
                                            {{ ($detail[$i] ?? '') == 'S' ? 'text-yellow-600' : '' }}
                                            {{ ($detail[$i] ?? '') == 'A' ? 'text-red-600' : '' }}"
                                            onchange="updateWarna(this); cekKelengkapan();">
                                        <option value="" class="text-gray-300">-</option>
                                        <option value="H" {{ ($detail[$i] ?? '') == 'H' ? 'selected' : '' }} class="text-green-600 font-bold">H</option>
                                        <option value="I" {{ ($detail[$i] ?? '') == 'I' ? 'selected' : '' }} class="text-blue-600 font-bold">I</option>
                                        <option value="S" {{ ($detail[$i] ?? '') == 'S' ? 'selected' : '' }} class="text-yellow-600 font-bold">S</option>
                                        <option value="A" {{ ($detail[$i] ?? '') == 'A' ? 'selected' : '' }} class="text-red-600 font-bold">A</option>
                                    </select>
                                </td>
                            @endfor

                            {{-- HASIL REKAP (Tampil Saja) --}}
                            <td class="p-1 border text-center font-bold text-green-700 bg-green-50">{{ $dataAbsen->hadir ?? 0 }}</td>
                            <td class="p-1 border text-center font-bold text-blue-700 bg-blue-50">{{ $dataAbsen->izin ?? 0 }}</td>
                            <td class="p-1 border text-center font-bold text-yellow-700 bg-yellow-50">{{ $dataAbsen->sakit ?? 0 }}</td>
                            <td class="p-1 border text-center font-bold text-red-700 bg-red-50">{{ $dataAbsen->alpha ?? 0 }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- FOOTER & TOMBOL --}}
            <div class="p-6 bg-gray-50 border-t flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="text-xs text-gray-500 italic max-w-lg">
                    <p class="font-bold text-gray-700 mb-1">Catatan:</p>
                    <ul class="list-disc pl-4 space-y-1">
                        <li>Pilih status kehadiran untuk setiap pertemuan (1-16).</li>
                        <li><b>Tombol "Kirim ke Wali Kelas"</b> hanya akan muncul jika Anda sudah mengisi absensi untuk <b>SEMUA</b> pertemuan siswa secara lengkap.</li>
                        <li>Jika belum lengkap, silakan gunakan tombol <b>"Simpan Sementara"</b>.</li>
                    </ul>
                </div>
                
                <div class="flex gap-3">
                    {{-- TOMBOL SIMPAN DRAFT --}}
                    <button type="submit" name="aksi" value="simpan_draft" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-xl font-bold shadow-md flex items-center transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                        Simpan Sementara
                    </button>

                    {{-- TOMBOL KIRIM (HIDDEN BY DEFAULT) --}}
                    <button type="submit" id="btnKirim" name="aksi" value="kirim_wali" class="hidden bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-xl font-bold shadow-md flex items-center transition animate-bounce" onclick="return confirm('Yakin kirim data absensi final ke Wali Kelas? Data tidak bisa diubah lagi setelah dikirim.');">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        Kirim ke Wali Kelas
                    </button>
                </div>
            </div>

        </div>
    </form>
</div>

{{-- SCRIPT: Validasi & Pewarnaan Otomatis --}}
<script>
    // 1. Fungsi Ubah Warna Text saat dropdown dipilih
    function updateWarna(select) {
        // Hapus kelas warna lama
        select.classList.remove('text-green-600', 'text-blue-600', 'text-yellow-600', 'text-red-600', 'text-gray-300');
        
        // Tambah kelas warna baru sesuai value
        if(select.value === 'H') select.classList.add('text-green-600');
        else if(select.value === 'I') select.classList.add('text-blue-600');
        else if(select.value === 'S') select.classList.add('text-yellow-600');
        else if(select.value === 'A') select.classList.add('text-red-600');
        else select.classList.add('text-gray-300'); // Jika kosong
    }

    // 2. Fungsi Cek Kelengkapan (Show/Hide Tombol Kirim)
    function cekKelengkapan() {
        const semuaSelect = document.querySelectorAll('.absen-input');
        const btnKirim = document.getElementById('btnKirim');
        let lengkap = true;

        // Loop semua kotak select
        semuaSelect.forEach(sel => {
            if (sel.value === "" || sel.value === null) {
                lengkap = false;
            }
        });

        // Tampilkan tombol jika lengkap & ada siswanya
        if (lengkap && semuaSelect.length > 0) {
            btnKirim.classList.remove('hidden');
            btnKirim.classList.add('flex');
        } else {
            btnKirim.classList.add('hidden');
            btnKirim.classList.remove('flex');
        }
    }

    // Jalankan sekali saat halaman dimuat (biar warna & tombol sesuai kondisi awal)
    document.addEventListener('DOMContentLoaded', cekKelengkapan);
</script>
@endsection