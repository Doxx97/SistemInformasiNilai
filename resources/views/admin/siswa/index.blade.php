@extends('layouts.dashboard')
@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white p-6 rounded-xl shadow-sm h-fit">
        <h3 class="font-bold mb-4">Tambah Siswa</h3>
        <form action="{{ route('admin.siswa.store') }}" method="POST" class="space-y-3" enctype="multipart/form-data">
            @csrf
            <div>
                <label class="text-xs font-bold text-gray-600">Nama Siswa</label>
                <input type="text" name="name" class="w-full border bg-gray-100 rounded p-2 mt-1" required>
            </div>
            <div>
                <label class="text-xs font-bold text-gray-600">NISN</label>
                <input type="number" name="username" class="w-full border bg-gray-100 rounded p-2 mt-1" required>
            </div>
            <div>
                <label class="text-xs font-bold text-gray-600">Foto Profil</label>
                <input type="file" name="foto" class="w-full text-xs bg-gray-100 rounded border p-2 mt-1">
                <p class="text-[10px] text-gray-400">*Format: JPG, PNG. Maks: 2MB.</p>
            </div>
            <div>
                <label class="text-xs font-bold text-gray-600">Kelas</label>
                <select name="kelas_id" class="w-full border bg-gray-100 rounded p-2 mt-1">
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>
            <button class="w-full bg-[#65825C] text-white py-2 rounded hover:bg-[#546e4b]">Simpan Siswa</button>
        </form>
    </div>

    <div class="md:col-span-2 bg-white p-6 rounded-xl shadow-sm">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold">Data Siswa</h3>
            <form method="GET">
                <select name="kelas_id" onchange="this.form.submit()" class="border rounded px-2 py-1 text-sm">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id }}" {{ $kelasId == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </form>
        </div>

        <div class="overflow-x-auto h-[500px]">
            <table class="w-full text-sm text-left border">
                <thead class="bg-gray-100 font-bold text-gray-700 sticky top-0">
                    <tr>
                        <th class="p-3 border">Nama</th>
                        <th class="p-3 border">NISN</th>
                        <th class="p-3 border">Kelas</th>
                        <th class="p-3 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($siswas as $s)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3 font-semibold">{{ $s->name }}</td>
                        <td class="p-3">{{ $s->username }}</td>
                        <td class="p-3">{{ $s->kelas->nama_kelas ?? '-' }}</td>
                        <td class="p-3 flex gap-2">
                            <a href="{{ route('admin.siswa.edit', $s->id) }}" class="text-yellow-600 hover:text-yellow-800 font-bold text-xs border border-yellow-600 px-2 py-1 rounded">
                                Edit
                            </a>
                            <form id="delete-siswa-{{ $s->id }}" action="{{ route('admin.siswa.destroy', $s->id) }}" method="POST">
                            @csrf 
                            @method('DELETE')
                                <button type="button" onclick="hapusSiswa({{ $s->id }}, '{{ $s->name }}')" class="text-red-600 border border-red-600 px-2 py-1 rounded text-xs hover:bg-red-50 transition">
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
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function hapusSiswa(id, nama) {
        Swal.fire({
            title: 'Hapus data siswa ' + nama + '?',
            text: "Data siswa beserta nilai dan riwayatnya akan terhapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Cari form dengan ID 'delete-siswa-ID' lalu submit
                document.getElementById('delete-siswa-' + id).submit();
            }
        })
    }

    function cekUkuranFoto(input) {
        const file = input.files[0];
        
        if (file) {
            // Ukuran file dalam Byte (2MB = 2 * 1024 * 1024)
            const maxSize = 2 * 1024 * 1024; 

            if (file.size > maxSize) {
                // 1. Munculkan Peringatan SweetAlert
                Swal.fire({
                    icon: 'error',
                    title: 'Ukuran File Terlalu Besar!',
                    text: 'Maksimal ukuran foto adalah 2MB. Silakan pilih foto yang lebih kecil.',
                    confirmButtonColor: '#65825C'
                });

                // 2. Reset Input (Kosongkan pilihan file)
                input.value = ''; 
            }
        }
    }
</script>
@endsection