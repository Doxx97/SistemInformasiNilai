@extends('layouts.dashboard')

@section('content')
<div class="space-y-6">
    
    <div class="flex flex-col md:flex-row justify-between items-center bg-white p-6 rounded-xl shadow-sm border-l-4 border-[#65825C]">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Mata Pelajaran</h1>
            <p class="text-gray-500 text-sm">Daftar mata pelajaran kurikulum sekolah</p>
        </div>
        <div class="mt-4 md:mt-0">
            <span class="bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded-full">
                Total: {{ $mapels->count() }} Mapel
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <h3 class="font-bold text-lg mb-4 border-b pb-2 flex items-center text-gray-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    Tambah Mapel
                </h3>
                
                <form action="{{ route('admin.mapel.store') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1 uppercase">Nama Mata Pelajaran</label>
                        <input type="text" name="nama_mapel" class="w-full bg-gray-50 border border-gray-200 rounded p-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#546e4b]" required placeholder="Contoh: Matematika">
                    </div>

                    {{-- Jika ada kolom KKM di database, bisa diaktifkan --}}
                    {{-- 
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1 uppercase">KKM (Minimal Nilai)</label>
                        <input type="number" name="kkm" class="w-full bg-gray-50 border border-gray-200 rounded p-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500" placeholder="75">
                    </div> 
                    --}}

                    <button type="submit" class="w-full bg-[#65825C] hover:bg-[#546e4b] text-white font-bold py-2.5 rounded shadow-md transition text-sm">
                        Simpan Mapel
                    </button>
                </form>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                
                <div class="p-4 border-b bg-gray-50">
                    <h3 class="font-bold text-gray-700">Daftar Mata Pelajaran</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left min-w-[500px]">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                            <tr>
                                <th class="p-4 text-center w-10">No</th>
                                <th class="p-4">Nama Mapel</th>
                                <th class="p-4 text-center">Guru Pengampu</th>
                                <th class="p-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($mapels as $index => $m)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 text-center text-gray-500 font-medium">
                                    {{ $index + 1 }}
                                </td>
                                <td class="p-4 font-bold text-gray-800">
                                    {{ $m->nama_mapel }}
                                </td>
                                <td class="p-4 text-center">
                                    {{-- Menghitung berapa guru yang mengajar mapel ini --}}
                                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full font-bold">
                                        {{ $m->gurus->count() }} Guru
                                    </span>
                                </td>
                                <td class="p-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        {{-- Tombol Edit (Biarkan) --}}
                                        <a href="{{ route('admin.mapel.edit', $m->id) }}" class="text-yellow-600 border border-yellow-600 px-2 py-1 rounded text-xs hover:bg-yellow-50 font-bold transition">
                                            Edit
                                        </a>
                                        
                                        {{-- Tombol Hapus dengan SweetAlert --}}
                                        <form id="delete-form-{{ $m->id }}" action="{{ route('admin.mapel.destroy', $m->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="konfirmasiHapus({{ $m->id }})" class="text-red-600 border border-red-600 px-2 py-1 rounded text-xs hover:bg-red-50 font-bold transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="p-8 text-center text-gray-400 italic">
                                    Belum ada data mata pelajaran.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Script SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function konfirmasiHapus(id) {
        Swal.fire({
            title: 'Yakin hapus Mapel ini?',
            text: "Hati-hati! Data nilai siswa yang terkait dengan mapel ini mungkin akan ikut terhapus.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Cari form berdasarkan ID lalu submit secara manual
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>
@endsection