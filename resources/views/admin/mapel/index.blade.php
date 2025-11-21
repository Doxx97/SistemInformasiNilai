@extends('layouts.dashboard')
@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white p-6 rounded-xl shadow-sm h-fit">
        <h3 class="font-bold mb-4">Tambah Mata Pelajaran</h3>
        <form action="{{ route('admin.mapel.store') }}" method="POST">
            @csrf
            <label class="text-xs font-bold text-gray-600">Nama Mapel</label>
            <input type="text" name="nama_mapel" class="w-full border bg-gray-100 rounded p-2 mb-4 mt-1">
            <button class="w-full bg-[#65825C] text-white py-2 rounded hover:bg-[#546e4b]">Simpan</button>
        </form>
    </div>

    <div class="md:col-span-2 bg-white p-6 rounded-xl shadow-sm">
        <h3 class="font-bold mb-4">Daftar Mata Pelajaran</h3>
        <table class="w-full text-sm text-left border">
            <thead class="bg-gray-100 font-bold text-gray-700">
                <tr>
                    <th class="p-3 border">No</th>
                    <th class="p-3 border">Nama Mapel</th>
                    <th class="p-3 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($mapels as $index => $m)
                <tr class="border-b">
                    <td class="p-3">{{ $index+1 }}</td>
                    <td class="p-3">{{ $m->nama_mapel }}</td>
                    <td class="p-3">
                        <form id="delete-form-{{ $m->id }}" action="{{ route('admin.mapel.destroy', $m->id) }}" method="POST">
                        @csrf 
                        @method('DELETE')
                            <button type="button" onclick="hapusMapel({{ $m->id }}, '{{ $m->mapel }}')" class="text-red-600 border border-red-600 px-2 py-1 rounded text-xs hover:bg-red-50 transition">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function hapusMapel(id, namaMapel) {
        Swal.fire({
            title: 'Hapus Mata Pelajaran ' + namaMapel + '?',
            text: "Hati-hati! Jika mapel ini dihapus, semua Jadwal Guru dan Nilai Siswa yang terkait dengan mapel ini mungkin ikut terhapus atau error.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Cari form berdasarkan ID unik, lalu submit
                document.getElementById('delete-mapel-' + id).submit();
            }
        })
    }
</script>
@endsection