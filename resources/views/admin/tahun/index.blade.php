@extends('layouts.dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    
    <div class="bg-white p-6 rounded-xl shadow-sm h-fit">
        <h3 class="font-bold mb-4">Tambah Tahun Ajaran</h3>
        <form action="{{ route('admin.tahun.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="text-xs font-bold text-gray-600">Tahun (Contoh: 2025/2026)</label>
                <input type="text" name="tahun" class="w-full border bg-gray-100 rounded p-2 mt-1" required placeholder="YYYY/YYYY">
            </div>
            <div>
                <label class="text-xs font-bold text-gray-600">Semester</label>
                <select name="semester" class="w-full border bg-gray-100 rounded p-2 mt-1">
                    <option value="Ganjil">Ganjil</option>
                    <option value="Genap">Genap</option>
                </select>
            </div>
            <button class="w-full bg-[#65825C] text-white py-2 rounded hover:bg-[#546e4b] font-bold text-sm">Simpan</button>
        </form>
    </div>

    <div class="md:col-span-2 bg-white p-6 rounded-xl shadow-sm">
        <h3 class="font-bold mb-4">Daftar Tahun Pelajaran</h3>
        
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-xs">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-xs">{{ session('error') }}</div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border">
                <thead class="bg-gray-100 font-bold text-gray-700">
                    <tr>
                        <th class="p-3 border">Tahun</th>
                        <th class="p-3 border">Semester</th>
                        <th class="p-3 border text-center">Status</th>
                        <th class="p-3 border text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tahuns as $t)
                    <tr class="border-b hover:bg-gray-50 {{ $t->is_active ? 'bg-green-50' : '' }}">
                        <td class="p-3 font-bold">{{ $t->tahun }}</td>
                        <td class="p-3">{{ $t->semester }}</td>
                        <td class="p-3 text-center">
                            @if($t->is_active)
                                <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-bold shadow-md">AKTIF</span>
                            @else
                                <span class="bg-gray-200 text-gray-500 px-3 py-1 rounded-full text-xs font-bold">Tidak Aktif</span>
                            @endif
                        </td>
                        <td class="p-3 text-center flex justify-center gap-2">
                            @if(!$t->is_active)
                                <form action="{{ route('admin.tahun.active', $t->id) }}" method="POST">
                                    @csrf
                                    <button class="text-blue-600 border border-blue-600 px-2 py-1 rounded text-xs hover:bg-blue-50 transition">
                                        Set Aktif
                                    </button>
                                </form>
                                <form id="delete-form-{{ $t->id }}" action="{{ route('admin.tahun.destroy', $t->id) }}" method="POST">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="button" onclick="hapusTahun({{ $t->id }}, '{{ $t->tahun }}')" class="text-red-600 border border-red-600 px-2 py-1 rounded text-xs hover:bg-red-50 transition">
                                        Hapus
                                    </button>
                                </form>
                            @else
                                <span class="text-xs text-gray-400 italic">Sedang Berjalan</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Tambahkan parameter 'namaTahun'
    function hapusTahun(id, namaTahun) {
        Swal.fire({
            title: 'Hapus Tahun ' + namaTahun + '?', // Judul jadi spesifik
            text: "Data jadwal dan nilai yang terkait dengan tahun " + namaTahun + " akan ikut terhapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>
@endsection