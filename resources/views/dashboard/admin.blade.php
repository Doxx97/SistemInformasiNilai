@extends('layouts.dashboard')

@section('content')
<div class="bg-white rounded-2xl shadow-md p-8 min-h-[500px]">
    
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Selamat Datang, Admin !</h1>
        <div class="flex items-center gap-4">
            
            <div class="flex items-center gap-2">
                <span class="text-gray-600 font-medium">Tahun Pelajaran :</span>
                <select class="bg-white border border-gray-300 text-gray-700 py-1 px-3 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-[#65825C]">
                    <option>2025/2026</option>
                    <option>2024/2025</option>
                </select>
            </div>

            <div class="flex items-center gap-2">
                <span class="text-gray-600 font-medium">Pilih Kelas :</span>
                <form action="{{ route('dashboard.admin') }}" method="GET" id="formFilterKelas">
                    <select name="kelas_id" onchange="document.getElementById('formFilterKelas').submit()" class="bg-white border border-gray-300 text-gray-700 py-1 px-3 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-[#65825C] cursor-pointer">
                        @foreach($daftarKelas as $k)
                            <option value="{{ $k->id }}" {{ $selectedKelasId == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-[#94cd88] rounded-lg p-4 text-center text-white shadow-md">
            <p class="text-xs font-medium opacity-90 mb-1">Jumlah Guru :</p>
            <h3 class="text-2xl font-bold">{{ $guruCount }} Guru</h3>
        </div>
        <div class="bg-[#8fb6d9] rounded-lg p-4 text-center text-white shadow-md">
            <p class="text-xs font-medium opacity-90 mb-1">Jumlah Siswa :</p>
            <h3 class="text-2xl font-bold">{{ $siswaCount }} Siswa</h3>
        </div>
        <div class="bg-[#dccb2e] rounded-lg p-4 text-center text-white shadow-md">
            <p class="text-xs font-medium opacity-90 mb-1">Jumlah Mapel :</p>
            <h3 class="text-2xl font-bold">{{ $mapelCount }} Mapel</h3>
        </div>
        <div class="bg-[#d92e2e] rounded-lg p-4 text-center text-white shadow-md">
            <p class="text-xs font-medium opacity-90 mb-1">Jumlah Kelas :</p>
            <h3 class="text-2xl font-bold">{{ $kelasCount }} Kelas</h3>
        </div>
    </div>

    <h3 class="font-bold text-gray-800 mb-4">Status Nilai (Kelas {{ $selectedKelasId }})</h3>
    
    @if($statusNilai->isEmpty())
        <div class="p-4 bg-gray-100 text-gray-500 text-center rounded-md">
            Belum ada data status nilai untuk kelas ini.
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-center border-collapse border border-gray-300">
                <thead class="bg-gray-100 text-gray-800 font-bold">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 w-12">NO</th>
                        <th class="border border-gray-300 px-4 py-2">Mata Pelajaran</th>
                        <th class="border border-gray-300 px-4 py-2">Guru Pengampu</th>
                        <th class="border border-gray-300 px-4 py-2">Status Nilai</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach($statusNilai as $index => $data)
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-300 px-4 py-2">{{ $index + 1 }}.</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $data->mapel->nama_mapel }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $data->guru->name }}</td>
                        <td class="border border-gray-300 px-4 py-1">
                            @if($data->status == 'terkirim')
                                <div class="w-full py-1 bg-[#00FF00] text-black text-xs font-medium rounded border border-gray-200">
                                    Terkirim
                                </div>
                            @else
                                <div class="w-full py-1 bg-[#FF3333] text-white text-xs font-medium rounded border border-gray-200">
                                    Belum Dikirim
                                </div>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection