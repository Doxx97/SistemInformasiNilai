<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rapor - {{ $siswa->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body class="bg-gray-100 p-10 print:bg-white print:p-0">

    <div class="max-w-3xl mx-auto bg-white p-8 shadow-lg print:shadow-none">
        <div class="text-center border-b-2 border-gray-800 pb-4 mb-6">
            <h1 class="text-xl font-bold uppercase">Laporan Hasil Belajar Siswa</h1>
            <h2 class="text-lg font-bold">SD ALDENAIRE</h2>
            <p class="text-sm">Tahun Pelajaran 2024/2025</p>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
            <div>
                <p>Nama Siswa : <b>{{ $siswa->name }}</b></p>
                <p>NISN : <b>{{ $siswa->username }}</b></p>
            </div>
            <div class="text-right">
                <p>Kelas : <b>{{ $guru->kelasPerwalian->nama_kelas }}</b></p>
                <p>Semester : <b>Ganjil</b></p>
            </div>
        </div>

        <table class="w-full border-collapse border border-gray-400 text-sm mb-8">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-400 p-2 w-10">No</th>
                    <th class="border border-gray-400 p-2 text-left">Mata Pelajaran</th>
                    <th class="border border-gray-400 p-2 w-20">Nilai</th>
                    <th class="border border-gray-400 p-2 w-20">Predikat</th>
                    <th class="border border-gray-400 p-2">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($nilais as $index => $nilai)
                @php
                    $n = $nilai->nilai;
                    $predikat = $n >= 90 ? 'A' : ($n >= 80 ? 'B' : ($n >= 70 ? 'C' : 'D'));
                    $ket = $n >= 70 ? 'Tuntas' : 'Perlu Bimbingan';
                @endphp
                <tr>
                    <td class="border border-gray-400 p-2 text-center">{{ $index + 1 }}</td>
                    <td class="border border-gray-400 p-2">{{ $nilai->mapel->nama_mapel }}</td>
                    <td class="border border-gray-400 p-2 text-center font-bold">{{ $n }}</td>
                    <td class="border border-gray-400 p-2 text-center">{{ $predikat }}</td>
                    <td class="border border-gray-400 p-2">{{ $ket }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="flex justify-between mt-16 text-sm">
            <div class="text-center">
                <p>Mengetahui,</p>
                <p>Orang Tua / Wali</p>
                <br><br><br>
                <p class="border-t border-gray-400 px-4 mt-4">( ....................... )</p>
            </div>
            <div class="text-center">
                <p>Malang, {{ date('d F Y') }}</p>
                <p>Wali Kelas</p>
                <br><br><br>
                <p class="font-bold border-t border-gray-400 px-4 mt-4">{{ $guru->name }}</p>
                <p>NIP. {{ $guru->username }}</p>
            </div>
        </div>

        <div class="mt-8 text-center no-print">
            <button onclick="window.print()" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 font-bold">
                Cetak Rapor
            </button>
            <button onclick="window.close()" class="ml-2 text-gray-600 hover:underline">
                Tutup
            </button>
        </div>
    </div>
</body>
</html>