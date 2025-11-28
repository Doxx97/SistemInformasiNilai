@extends('layouts.dashboard')

@section('content')
<div class="space-y-6">
    
    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-[#65825C] flex justify-between items-center">
        <div>
            <h1 class="text-xl font-bold text-gray-800">Selamat Datang,</h1>
            <p class="text-gray-600">Wali Murid dari <span class="font-bold text-[#65825C] uppercase">{{ $siswa->name }}</span></p>
        </div>
        <div class="text-right hidden md:block">
            <p class="text-xs text-gray-500">Tahun Pelajaran</p>
            {{-- Ambil tahun aktif dari helper/model --}}
            @php
                $tahunAktif = \App\Models\TahunPelajaran::where('is_active', true)->first();
            @endphp
            <p class="font-bold text-gray-700">{{ $tahunAktif->tahun ?? '-' }} {{ $tahunAktif->semester ?? '' }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-1 bg-white rounded-xl shadow-sm p-6 flex flex-col items-center text-center h-fit">
            <div class="w-32 h-32 bg-blue-100 rounded-full overflow-hidden mb-4 border-4 border-white shadow-md flex items-center justify-center text-blue-500">
                @if(Auth::user()->foto)
                    <img src="{{ asset('storage/' . Auth::user()->foto) }}" alt="Profil" class="w-full h-full object-cover">
                @else
                    <svg class="w-16 h-16 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                @endif
            </div>
            
            {{-- NAMA SISWA DINAMIS --}}
            <h2 class="font-bold text-lg text-gray-800">{{ $siswa->name }}</h2>
            <p class="text-sm text-gray-500">Siswa SD Aldenaire</p>
            
            {{-- NISN DINAMIS --}}
            <p class="text-xs text-gray-400 mb-6">NISN: {{ $siswa->username }}</p>

            <div class="w-full text-left space-y-3 text-sm mt-4 border-t pt-4">
                <div class="flex justify-between">
                    <span class="text-gray-500 font-medium">Kelas</span>
                    {{-- KELAS DINAMIS (Pakai tanda tanya ?? untuk jaga-jaga kalau belum punya kelas) --}}
                    <span class="font-bold text-gray-800 bg-green-100 text-green-800 px-2 rounded text-xs py-0.5">
                        {{ $siswa->kelas->nama_kelas ?? 'Belum ditentukan' }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500 font-medium">NISN</span>
                    <span class="font-bold text-gray-800">{{ $siswa->username }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500 font-medium">Status</span>
                    <span class="font-bold text-green-600">Aktif</span>
                </div>
            </div>

            <div class="mt-6 w-full">
                {{-- Link ke Route Profil --}}
                <a href="{{ route('walimurid.profil') }}" class="block w-full text-center border border-[#65825C] text-[#65825C] text-xs px-4 py-2 rounded-lg hover:bg-[#65825C] hover:text-white transition font-bold">
                    Lihat Profil Lengkap
                </a>
            </div>
        </div>

        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-[#65825C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                Laporan Hasil Belajar
            </h3>

            {{-- LOGIKA PENAMPILAN NILAI --}}
            @if(!$isPublished)
                <div class="flex flex-col items-center justify-center py-16 bg-yellow-50 rounded-lg border border-yellow-200 text-center px-4">
                    <div class="bg-yellow-100 p-4 rounded-full mb-3">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <h4 class="font-bold text-yellow-800 text-lg">Rapor Belum Diterbitkan</h4>
                    <p class="text-yellow-700 text-sm mt-1 max-w-md">
                        Wali Kelas sedang melakukan rekapitulasi nilai. <br>
                        Hasil belajar akan muncul di sini setelah Wali Kelas menerbitkan rapor secara resmi.
                    </p>
                </div>

            @elseif($nilais->isEmpty())
                <div class="text-center py-10 text-gray-400">
                    <p>Data nilai tidak ditemukan.</p>
                </div>

            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left border-collapse">
                        <thead class="bg-gray-100 text-gray-700 font-bold uppercase text-xs">
                            <tr>
                                <th class="p-3 border border-gray-200 text-center w-10">No</th>
                                <th class="p-3 border border-gray-200">Mata Pelajaran</th>
                                <th class="p-3 border border-gray-200 text-center w-20">Nilai</th>
                                <th class="p-3 border border-gray-200 text-center w-20">Predikat</th>
                                <th class="p-3 border border-gray-200 text-center">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @foreach($nilais as $index => $data)
                            @php
                                $n = $data->nilai;
                                $predikat = $n >= 90 ? 'A' : ($n >= 80 ? 'B' : ($n >= 70 ? 'C' : 'D'));
                                $warna = $n >= 70 ? 'text-green-600' : 'text-red-500';
                                $ket = $n >= 70 ? 'Tuntas' : 'Remidi';
                                $bgKet = $n >= 70 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
                            @endphp
                            <tr class="hover:bg-gray-50 border-b border-gray-100">
                                <td class="p-3 border border-gray-200 text-center">{{ $index + 1 }}</td>
                                <td class="p-3 border border-gray-200 font-medium">{{ $data->mapel->nama_mapel }}</td>
                                <td class="p-3 border border-gray-200 text-center font-bold {{ $warna }}">{{ $n }}</td>
                                <td class="p-3 border border-gray-200 text-center font-bold">{{ $predikat }}</td>
                                <td class="p-3 border border-gray-200 text-center">
                                    <span class="px-2 py-1 rounded text-[10px] font-bold uppercase {{ $bgKet }}">
                                        {{ $ket }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection