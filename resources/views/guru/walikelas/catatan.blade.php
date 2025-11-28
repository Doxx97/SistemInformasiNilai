@extends('layouts.dashboard')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-[#65825C] p-6 text-white">
            <h2 class="text-xl font-bold">Catatan Wali Kelas</h2>
            <p class="text-sm opacity-90">Berikan motivasi atau catatan perkembangan untuk siswa.</p>
        </div>
        
        <div class="p-8">
            <div class="mb-6 bg-gray-50 p-4 rounded-lg border border-gray-200">
                <table class="w-full text-sm">
                    <tr>
                        <td class="text-gray-500 py-1 w-24">Nama Siswa</td>
                        <td class="font-bold text-gray-800">: {{ $siswa->name }}</td>
                    </tr>
                    <tr>
                        <td class="text-gray-500 py-1">NISN</td>
                        <td class="font-bold text-gray-800">: {{ $siswa->username }}</td>
                    </tr>
                    <tr>
                        <td class="text-gray-500 py-1">Kelas</td>
                        <td class="font-bold text-gray-800">: {{ $siswa->kelas->nama_kelas }}</td>
                    </tr>
                </table>
            </div>

            <form action="{{ route('guru.walikelas.update_catatan', $siswa->id) }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Isi Catatan:</label>
                    <textarea name="catatan" rows="6" class="w-full border border-gray-300 rounded-lg p-4 focus:ring-2 focus:ring-[#65825C] focus:outline-none" placeholder="Tuliskan catatan perkembangan, motivasi, atau evaluasi untuk siswa ini...">{{ $siswa->catatan_wali_kelas }}</textarea>
                    <p class="text-xs text-gray-400 mt-2">*Catatan ini akan tampil di halaman profil Wali Murid.</p>
                </div>

                <div class="flex justify-between items-center">
                    <a href="{{ route('guru.walikelas.rekap') }}" class="text-gray-500 hover:text-gray-700 text-sm font-medium">Batal</a>
                    <button class="bg-[#65825C] hover:bg-[#546e4b] text-white font-bold py-2 px-6 rounded-lg shadow transition">
                        Simpan Catatan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection