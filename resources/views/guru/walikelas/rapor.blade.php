<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapor - {{ $siswa->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Font Resmi */
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            color: #000;
            line-height: 1.3;
        }
        
        /* Table Border */
        .table-bordered {
            border-collapse: collapse;
            width: 100%;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid black !important;
            padding: 4px 6px;
        }
        .header-table td {
            padding: 2px;
            vertical-align: top;
        }
        
        /* --- PENGATURAN CETAK (PRINT) --- */
        @media print {
            @page {
                size: A4;
                margin: 0; 
            }
            .no-print {
                display: none !important;
            }
            body {
                background-color: white !important;
                margin: 0 !important;
                padding: 0 !important;
                -webkit-print-color-adjust: exact; 
            }
            .rapor-print-container {
                padding: 1.5cm !important; 
                margin: 0 !important;
                width: 100% !important;
                box-shadow: none !important;
            }
            
            /* CLASS PENTING UNTUK MEMOTONG HALAMAN */
            .page-break {
                page-break-before: always;
                break-before: page;
                display: block;
                height: 0;
                margin: 0;
            }

            /* --- UBAH DISINI: SPACER DIPERBESAR AGAR HALAMAN 2 TURUN --- */
            .page-spacer {
                height: 50px; /* Jarak diperbesar jadi 50px */
                display: block;
                width: 100%;
            }

            .no-break-inside {
                page-break-inside: avoid;
                break-inside: avoid;
            }
            tr { page-break-inside: avoid; }
        }
    </style>
</head>
<body class="bg-gray-100 p-8 print:bg-white print:p-0">

    {{-- TOMBOL CETAK --}}
    <div class="no-print fixed top-6 right-6 z-50">
        <button onclick="window.print()" class="flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-full shadow-lg font-bold hover:bg-blue-700 transition transform hover:scale-105">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Cetak Rapor (PDF)
        </button>
    </div>

    {{-- KONTAINER UTAMA --}}
    <div class="rapor-print-container max-w-[210mm] mx-auto bg-white p-10 shadow-xl min-h-[297mm] relative box-border">

        {{-- ================= HALAMAN 1 ================= --}}

        {{-- 1. KOP SURAT --}}
        <div class="text-center border-b-4 border-double border-black pb-4 mb-6 relative">
            <img src="{{ asset('images/SD.png') }}" alt="Logo" class="h-24 w-auto absolute left-2 top-0 object-contain">
            <h3 class="text-lg font-bold uppercase tracking-wide leading-tight">Pemerintah Kabupaten/Kota<br>Dinas Pendidikan</h3>
            <h1 class="text-3xl font-extrabold uppercase mt-1 tracking-wider">SD LIGA NUSANTARA</h1>
            <p class="text-sm mt-2 font-medium">Alamat: Jl. Pendidikan No. 123, Kota Belajar. Telp: (021) 1234567</p>
            <p class="text-sm italic">Website: www.sd-liganusantara.sch.id | Email: info@sdliganusantara.sch.id</p>
        </div>

        <div class="text-center mb-6">
            <h2 class="font-bold text-xl underline uppercase tracking-wider">Laporan Hasil Belajar (Rapor)</h2>
        </div>

        {{-- 2. DATA SISWA --}}
        <table class="w-full mb-6 header-table font-medium text-base">
            <tr>
                <td width="22%">Nama Peserta Didik</td>
                <td width="2%">:</td>
                <td width="35%" class="uppercase font-bold">{{ $siswa->name }}</td>
                <td width="15%">Kelas</td>
                <td width="2%">:</td>
                <td class="font-bold">{{ $kelas->nama_kelas }}</td>
            </tr>
            <tr>
                <td>NISN / NIS</td>
                <td>:</td>
                <td>{{ $siswa->username }}</td>
                <td>Semester</td>
                <td>:</td>
                <td class="uppercase">{{ $tahunAktif->semester ?? '-' }}</td>
            </tr>
            <tr>
                <td>Nama Sekolah</td>
                <td>:</td>
                <td>SD LIGA NUSANTARA</td>
                <td>Tahun Ajaran</td>
                <td>:</td>
                <td>{{ $tahunAktif->tahun ?? '-' }}</td>
            </tr>
        </table>

        {{-- 3. TABEL NILAI --}}
        <h3 class="font-bold text-base mb-2">A. NILAI AKADEMIK</h3>
        <table class="table-bordered mb-4">
            <thead>
                <tr class="bg-gray-200 text-center font-bold">
                    <th width="5%">No</th>
                    <th width="30%">Mata Pelajaran</th>
                    <th width="10%">Nilai</th>
                    <th width="10%">Predikat</th>
                    <th width="45%">Deskripsi Kemajuan Belajar</th>
                </tr>
            </thead>
            <tbody>
                @foreach($mapels as $index => $mapel)
                    @php
                        $nilai = \App\Models\Nilai::where('siswa_id', $siswa->id)
                                    ->where('mapel_id', $mapel->id)
                                    ->where('tahun_pelajaran_id', $tahunAktif->id ?? 0) 
                                    ->first();
                        $skor = $nilai ? $nilai->nilai : 0;
                        if($skor >= 90) { $predikat = 'A'; $deskripsi = 'Sangat Baik dalam memahami materi.'; }
                        elseif($skor >= 80) { $predikat = 'B'; $deskripsi = 'Baik dalam memahami materi.'; }
                        elseif($skor >= 70) { $predikat = 'C'; $deskripsi = 'Cukup memahami materi, perlu ditingkatkan.'; }
                        else { $predikat = 'D'; $deskripsi = 'Perlu bimbingan khusus dari guru dan orang tua.'; }
                    @endphp
                    <tr>
                        <td class="text-center align-middle">{{ $index + 1 }}</td>
                        <td class="align-middle">{{ $mapel->nama_mapel }}</td>
                        <td class="text-center font-bold text-lg align-middle">{{ $nilai ? $skor : '-' }}</td>
                        <td class="text-center font-bold align-middle">{{ $nilai ? $predikat : '-' }}</td>
                        <td class="text-sm italic align-middle px-2">{{ $nilai ? $deskripsi : 'Belum ada penilaian.' }}</td>
                    </tr>
                @endforeach
                
                {{-- Rata-rata --}}
                <tr class="bg-gray-100 font-bold">
                    <td colspan="2" class="text-center uppercase">Rata-rata</td>
                    <td class="text-center text-lg">
                        @php
                            $avg = \App\Models\Nilai::where('siswa_id', $siswa->id)
                                            ->where('tahun_pelajaran_id', $tahunAktif->id ?? 0)
                                            ->avg('nilai');
                        @endphp
                        {{ $avg ? number_format($avg, 1) : '-' }}
                    </td>
                    <td class="text-center text-lg">
                        @php
                            $predikatRata = '-';
                            if($avg) {
                                if($avg >= 90) $predikatRata = 'A';
                                elseif($avg >= 80) $predikatRata = 'B';
                                elseif($avg >= 70) $predikatRata = 'C';
                                else $predikatRata = 'D';
                            }
                        @endphp
                        {{ $predikatRata }}
                    </td>
                    <td class="bg-gray-100"></td>
                </tr>
            </tbody>
        </table>

        {{-- KETERANGAN PREDIKAT --}}
        <div class="mb-4 text-xs font-medium text-gray-700">
            <span class="font-bold mr-2">Keterangan Predikat:</span><br>
            <span class="mr-4"><b>A:</b> 90 - 100</span>
            <span class="mr-4"><b>B:</b> 80 - 89</span>
            <span class="mr-4"><b>C:</b> 70 - 79</span>
            <span class="mr-4"><b>D:</b> < 70</span>
        </div>

        {{-- ========== PEMISAH HALAMAN ========== --}}
        <div class="page-break"></div>
        <div class="page-spacer"></div> 
        
        {{-- Header Kecil Halaman 2 --}}
        <div class="mb-4  pb-1 text-xs text-right italic">
        </div>

        {{-- ================= HALAMAN 2 ================= --}}

        {{-- B. TABEL ABSENSI --}}
        <h3 class="font-bold text-base mb-2">B. KETIDAKHADIRAN</h3>
        <div class="mb-4 w-1/2"> 
            <table class="table-bordered">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="text-left pl-4">Keterangan</th>
                        <th class="text-center" width="30%">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td class="pl-4">Sakit</td><td class="text-center font-bold">{{ $absensi['sakit'] ?? 0 }} Hari</td></tr>
                    <tr><td class="pl-4">Izin</td><td class="text-center font-bold">{{ $absensi['izin'] ?? 0 }} Hari</td></tr>
                    <tr><td class="pl-4">Tanpa Keterangan (Alpha)</td><td class="text-center font-bold">{{ $absensi['alpha'] ?? 0 }} Hari</td></tr>
                </tbody>
            </table>
        </div>
        
        <div class="no-break-inside">
            
            {{-- C. CATATAN WALI KELAS --}}
            <h3 class="font-bold text-base mb-2">C. CATATAN WALI KELAS</h3>
            <div class="mb-4 border-2 border-black p-4 rounded-lg min-h-[60px]">
                <p class="italic text-base leading-relaxed">
                    "{{ $siswa->catatan_wali_kelas ?? 'Teruslah belajar dengan giat dan kembangkan potensimu.' }}"
                </p>
            </div>

            {{-- D. CATATAN WALI MURID --}}
            <h3 class="font-bold text-base mb-2">D. TANGGAPAN ORANG TUA / WALI</h3>
            <div class="mb-4 border-2 border-black p-4 rounded-lg min-h-[60px]"></div>

            {{-- E. KOTAK KENAIKAN KELAS --}}
            @if($tahunAktif && $tahunAktif->semester == 'Genap')
                <div class="mb-6 border-4 border-double border-black p-4 text-center bg-gray-50 print:bg-transparent">
                    <h4 class="font-bold text-sm uppercase tracking-wider mb-2">Keputusan Rapat Dewan Guru:</h4>
                    <p class="text-sm mb-2">Berdasarkan hasil pencapaian kompetensi peserta didik, ditetapkan bahwa:</p>
                    @if($siswa->status_kenaikan)
                        <h3 class="text-xl font-extrabold uppercase tracking-[0.2em] underline decoration-4 underline-offset-4">
                            {{ $siswa->status_kenaikan }}
                        </h3>
                    @else
                        <p class="text-red-500 italic font-bold">(Status Belum Diputuskan)</p>
                    @endif
                </div>
            @endif

            {{-- F. TANDA TANGAN --}}
            <div class="flex justify-between mt-8 px-8 font-medium text-sm">
                <div class="text-center">
                    <p class="mb-2">Kota Belajar, {{ date('d F Y') }}</p>
                    <p class="mb-1">Wali Kelas</p>
                    <div class="h-20"></div> 
                    <p class="font-bold underline text-base mb-1">{{ $waliKelas->name ?? '.....................................' }}</p>
                    <p>NIP. {{ $waliKelas->username ?? '-' }}</p>
                </div>

                <div class="text-center">
                    <p class="mb-1">Mengetahui,<br>Orang Tua/Wali</p>
                    <div class="h-20"></div>
                    <p class="font-bold underline text-base">( ........................................ )</p>
                </div>
            </div>
            
            <div class="text-center mt-8 font-medium text-sm">
                <p class="mb-1">Mengetahui,<br>Kepala Sekolah Dasar Liga Nusantara</p>
                <div class="h-20"></div>
                <p class="font-bold underline text-base mb-1">Dr. BUDI SANTOSO, M.Pd</p>
                <p>NIP. 19750101 200001 1 001</p>
            </div>

        </div> 

    </div>

</body>
</html>