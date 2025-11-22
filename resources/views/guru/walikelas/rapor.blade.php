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
            font-size: 12pt;
            color: #000;
        }
        
        /* Table Border */
        .table-bordered {
            border-collapse: collapse;
            width: 100%;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid black !important;
            padding: 6px 8px;
        }
        .header-table td {
            padding: 4px;
            vertical-align: top;
        }
        
        /* --- PENGATURAN CETAK (PRINT) AGAR BERSIH --- */
        @media print {
            /* 1. Hilangkan Header/Footer Browser (Tanggal, URL, Judul) */
            @page {
                size: A4;
                margin: 0; /* PENTING: Margin 0 mematikan header/footer browser */
            }

            /* 2. Sembunyikan tombol cetak */
            .no-print {
                display: none !important;
            }

            /* 3. Reset Body */
            body {
                background-color: white !important;
                margin: 0 !important;
                padding: 0 !important;
                -webkit-print-color-adjust: exact; 
            }

            /* 4. Buat Margin Manual (Pengganti margin browser yang kita nol-kan) */
            .rapor-print-container {
                padding: 2cm !important; /* Margin kertas 2cm di semua sisi */
                margin: 0 !important;
                width: 100% !important;
                box-shadow: none !important;
            }

            /* 5. Anti Potong (Break Inside) */
            .no-break-inside {
                page-break-inside: avoid;
                break-inside: avoid;
            }

            /* Tabel tidak boleh putus sembarangan */
            tr { page-break-inside: avoid; }
        }
    </style>
</head>
<body class="bg-gray-100 p-8 print:bg-white print:p-0">

    {{-- TOMBOL CETAK (Akan hilang saat diprint) --}}
    <div class="no-print fixed top-6 right-6 z-50">
        <button onclick="window.print()" class="flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-full shadow-lg font-bold hover:bg-blue-700 transition transform hover:scale-105">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Cetak Rapor (PDF)
        </button>
    </div>

    {{-- KONTAINER UTAMA HALAMAN RAPOR --}}
    <div class="rapor-print-container max-w-[210mm] mx-auto bg-white p-10 shadow-xl min-h-[297mm] relative box-border">

        {{-- 1. KOP SURAT SEKOLAH --}}
        <div class="text-center border-b-4 border-double border-black pb-6 mb-8 relative">
            {{-- Logo --}}
            <img src="{{ asset('images/SD.png') }}" alt="Logo" class="h-28 w-auto absolute left-4 top-2 object-contain">
            
            <h3 class="text-lg font-bold uppercase tracking-wide leading-tight">Pemerintah Kabupaten/Kota<br>Dinas Pendidikan</h3>
            <h1 class="text-4xl font-extrabold uppercase mt-2 tracking-wider">SD LIGA NUSANTARA</h1>
            <p class="text-sm mt-3 font-medium">Alamat: Jl. Pendidikan No. 123, Kota Belajar. Telp: (021) 1234567</p>
            <p class="text-sm italic">Website: www.sd-liganusantara.sch.id | Email: info@sdliganusantara.sch.id</p>
        </div>

        <div class="text-center mb-8">
            <h2 class="font-bold text-2xl underline uppercase tracking-wider">Laporan Hasil Belajar (Rapor)</h2>
        </div>

        {{-- 2. DATA SISWA --}}
        <table class="w-full mb-8 header-table font-medium text-base">
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
        <table class="table-bordered mb-8">
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
                        // Ambil nilai sesuai tahun aktif
                        $nilai = \App\Models\Nilai::where('siswa_id', $siswa->id)
                                    ->where('mapel_id', $mapel->id)
                                    ->where('tahun_pelajaran_id', $tahunAktif->id ?? 0) 
                                    ->first();
                        
                        $skor = $nilai ? $nilai->nilai : 0;
                        
                        // Logika Predikat
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
                        <td class="text-sm italic align-middle px-4">{{ $nilai ? $deskripsi : 'Belum ada penilaian.' }}</td>
                    </tr>
                @endforeach
                
                {{-- Baris Rata-rata --}}
                <tr class="bg-gray-100 font-bold">
                    <td colspan="2" class="text-center uppercase">Rata-rata Seluruh Mapel</td>
                    <td class="text-center text-lg">
                        @php
                            $avg = \App\Models\Nilai::where('siswa_id', $siswa->id)
                                    ->where('tahun_pelajaran_id', $tahunAktif->id ?? 0)
                                    ->avg('nilai');
                        @endphp
                        {{ $avg ? number_format($avg, 1) : '-' }}
                    </td>
                    <td colspan="2" class="bg-gray-100"></td>
                </tr>
            </tbody>
        </table>
        
        <div class="no-break">
            
            {{-- 4. CATATAN WALI KELAS --}}
            <div class="mb-6 border-2 border-black p-6 rounded-lg">
                <h3 class="font-bold text-lg underline mb-3">Catatan Wali Kelas:</h3>
                <p class="italic text-base leading-relaxed">
                    "{{ $siswa->catatan_wali_kelas ?? 'Teruslah belajar dengan giat dan kembangkan potensimu. Jangan takut untuk mencoba hal baru!' }}"
                </p>
            </div>

            {{-- 5. KOTAK KENAIKAN KELAS (Hanya Semester Genap) --}}
            @if($tahunAktif && $tahunAktif->semester == 'Genap')
                <div class="mb-10 border-4 border-double border-black p-6 text-center bg-gray-50 print:bg-transparent">
                    <h4 class="font-bold text-base uppercase tracking-wider mb-4">Keputusan Rapat Dewan Guru:</h4>
                    <p class="text-base mb-4">Berdasarkan hasil pencapaian kompetensi peserta didik, ditetapkan bahwa:</p>
                    
                    @if($siswa->status_kenaikan)
                        <h3 class="text-2xl font-extrabold uppercase tracking-[0.2em] underline decoration-4 underline-offset-8">
                            {{ $siswa->status_kenaikan }}
                        </h3>
                    @else
                        <p class="text-red-500 italic font-bold border-2 border-red-500 p-2 inline-block">
                            (Status Kenaikan Belum Diputuskan)
                        </p>
                    @endif
                </div>
            @endif

            {{-- 6. TANDA TANGAN --}}
            <div class="flex justify-between mt-12 px-8 font-medium">
                {{-- Kolom Orang Tua --}}
                <div class="text-center">
                    <p class="mb-24">Mengetahui,<br>Orang Tua/Wali Peserta Didik</p>
                    <p class="font-bold underline text-lg">( ................................................. )</p>
                </div>

                {{-- Kolom Wali Kelas --}}
                <div class="text-center">
                    <p class="mb-4">Kota Belajar, {{ date('d F Y') }}</p>
                    <p class="mb-20">Wali Kelas</p>
                    <p class="font-bold underline text-lg mb-1">{{ $waliKelas->name ?? '.................................................' }}</p>
                    <p>NIP. {{ $waliKelas->username ?? '-' }}</p>
                </div>
            </div>
            
            {{-- Tanda Tangan Kepala Sekolah --}}
            <div class="text-center mt-16 font-medium">
                <p class="mb-24">Mengetahui,<br>Kepala Sekolah Dasar Liga Nusantara</p>
                <p class="font-bold underline text-lg mb-1">Dr. BUDI SANTOSO, M.Pd</p>
                <p>NIP. 19750101 200001 1 001</p>
            </div>

        </div> {{-- Akhir dari Wrapper Anti-Potong --}}

    </div>

</body>
</html>