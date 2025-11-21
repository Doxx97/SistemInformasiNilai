@extends('layouts.dashboard')

@section('content')
<div class="max-w-4xl mx-auto">
    
    <a href="{{ route('dashboard.guru') }}" class="inline-flex items-center text-gray-600 hover:text-[#65825C] mb-4 text-sm font-medium">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Dashboard
    </a>

    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-[#65825C] p-6 text-white flex justify-between items-center">
            <div>
                <h2 class="text-xl font-bold">Input Nilai Siswa</h2>
                <p class="text-sm opacity-90">Mata Pelajaran: <b>{{ $mapel->nama_mapel }}</b></p>
            </div>
            <div class="bg-white/20 px-4 py-2 rounded-lg text-center">
                <span class="block text-xs uppercase tracking-wider">Kelas</span>
                <span class="text-2xl font-bold">{{ $kelas->nama_kelas }}</span>
            </div>
        </div>

        <div class="p-6">
            @if($siswas->isEmpty())
                <div class="text-center py-10 text-gray-500">
                    <p>Tidak ada siswa terdaftar di kelas ini.</p>
                    <p class="text-xs mt-1">Hubungi Admin untuk menambahkan data siswa.</p>
                </div>
            @else
                <form action="{{ route('guru.nilai.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
                    <input type="hidden" name="mapel_id" value="{{ $mapel->id }}">

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b-2 border-gray-100 text-gray-500 text-xs uppercase tracking-wider">
                                    <th class="pb-3 font-semibold">No</th>
                                    <th class="pb-3 font-semibold">Nama Siswa</th>
                                    <th class="pb-3 font-semibold">NISN</th>
                                    <th class="pb-3 font-semibold w-32 text-center">Nilai (0-100)</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700 text-sm">
                                @foreach($siswas as $index => $siswa)
                                @php
                                    // Ambil nilai yang sudah ada (jika ada)
                                    $nilaiAda = $siswa->nilais->first(); 
                                    $skor = $nilaiAda ? $nilaiAda->nilai : '';
                                @endphp
                                <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                                    <td class="py-4">{{ $index + 1 }}</td>
                                    <td class="py-4 font-medium text-gray-900">{{ $siswa->name }}</td>
                                    <td class="py-4 text-gray-500">{{ $siswa->username }}</td>
                                    <td class="py-4">
                                        <input type="number" 
                                               name="nilai[{{ $siswa->id }}]" 
                                               value="{{ $skor }}" 
                                               min="0" max="100"
                                               class="w-full text-center border border-gray-300 rounded-md py-2 px-3 focus:ring-2 focus:ring-[#65825C] focus:outline-none focus:border-[#65825C] transition font-bold text-gray-800"
                                               placeholder="0">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="bg-[#65825C] hover:bg-[#546e4b] text-white font-bold py-3 px-8 rounded-lg shadow-lg flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                            Simpan & Kirim ke Wali Kelas
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection