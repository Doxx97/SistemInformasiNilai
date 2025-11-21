@extends('layouts.dashboard')
@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    
    <div class="bg-white p-6 rounded-xl shadow-sm h-fit">
        <h3 class="font-bold mb-4">Tambah Guru Baru</h3>

        {{-- MENAMPILKAN PESAN ERROR (VALIDASI) --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 text-xs">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- MENAMPILKAN PESAN SUKSES/GAGAL --}}
        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-xs">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-xs">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.guru.store') }}" method="POST" class="space-y-3" enctype="multipart/form-data">
            @csrf
            
            <div>
                <label class="text-xs font-bold text-gray-600">Nama Guru</label>
                <input type="text" name="name" class="w-full border bg-gray-100 rounded p-2 mt-1" required placeholder="Contoh: Bu Siti">
            </div>
            
            <div>
                <label class="text-xs font-bold text-gray-600">NIP / Username</label>
                <input type="number" name="username" class="w-full border bg-gray-100 rounded p-2 mt-1" required placeholder="Contoh: 123456">
                <p class="text-[10px] text-gray-400">*NIP harus unik (belum terdaftar)</p>
            </div>

            <div>
                <label class="text-xs font-bold text-gray-600">Password Akun</label>
                <input type="text" name="password" class="w-full border bg-gray-100 rounded p-2 mt-1" required placeholder="Password untuk Login">
                <p class="text-[10px] text-gray-400">*Wajib diisi minimal 6 karakter.</p>
            </div>
            <div>
                <label class="text-xs font-bold text-gray-600">Foto Profil</label>
                <input type="file" name="foto" class="w-full text-xs bg-gray-100 rounded border p-2 mt-1">
                <p class="text-[10px] text-gray-400">*Format: JPG, PNG. Maks: 2MB.</p>
            </div>
            <div>
                <label class="text-xs font-bold text-gray-600">Assign Kelas & Mapel :</label>
                <div class="mt-2 h-48 overflow-y-auto border p-3 rounded bg-gray-50 grid grid-cols-1 gap-2">
                    @foreach($mapels as $mapel)
                        <div class="font-bold text-xs text-gray-500 mt-2 uppercase border-b border-gray-300 pb-1">
                            {{ $mapel->nama_mapel }}
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            @foreach($kelasList as $kelas)
                                <div class="flex items-center">
                                    {{-- VALUE: ID_MAPEL-ID_KELAS --}}
                                    <input type="checkbox" name="assign_mapel[]" value="{{ $mapel->id }}-{{ $kelas->id }}" class="mr-2 cursor-pointer">
                                    <span class="text-[11px]">Kelas {{ $kelas->nama_kelas }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>

            <div>
                <label class="text-xs font-bold text-gray-600">Tugas Tambahan (Wali Kelas)</label>
                <select name="wali_kelas_id" class="w-full border bg-gray-100 rounded p-2 mt-1 text-sm">
                    <option value="">-- Bukan Wali Kelas --</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id }}">Wali Kelas {{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>

            <button class="w-full bg-[#65825C] text-white py-2 rounded hover:bg-[#546e4b] font-bold text-sm mt-4">Simpan Guru</button>
        </form>
    </div>

    <div class="md:col-span-2 bg-white p-6 rounded-xl shadow-sm">
        <h3 class="font-bold mb-4">Data Guru Pengajar</h3>
        <div class="overflow-x-auto h-[600px]">
            <table class="w-full text-sm text-left border">
                <thead class="bg-gray-100 font-bold text-gray-700 sticky top-0">
                    <tr>
                        <th class="p-3 border">Nama & NIP</th>
                        <th class="p-3 border">Mengajar Mapel</th>
                        <th class="p-3 border">Wali Kelas</th>
                        <th class="p-3 border text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($gurus as $g)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3 align-top">
                            <div class="font-bold">{{ $g->name }}</div>
                            <div class="text-xs text-gray-500">{{ $g->username }}</div>
                        </td>
                        <td class="p-3 align-top">
                            <div class="flex flex-wrap gap-1">
                                {{-- Kita ambil unique mapelnya saja biar tidak panjang --}}
                                @foreach($g->mapels->unique('id') as $m)
                                    <span class="bg-green-100 text-green-800 text-[10px] px-2 py-0.5 rounded border border-green-200">{{ $m->nama_mapel }}</span>
                                @endforeach
                            </div>
                        </td>
                        <td class="p-3 align-top">
                            @if($g->kelasPerwalian)
                                <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded font-bold border border-yellow-200">
                                    Kelas {{ $g->kelasPerwalian->nama_kelas }}
                                </span>
                            @else
                                <span class="text-gray-400 text-xs">-</span>
                            @endif
                        </td>
                        <td class="p-3 text-center align-top">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('admin.guru.edit', $g->id) }}" class="text-yellow-600 hover:text-yellow-800 font-bold text-xs border border-yellow-600 px-2 py-1 rounded">
                                    Edit
                                </a>
                            <form id="delete-guru-{{ $g->id }}" action="{{ route('admin.guru.destroy', $g->id) }}" method="POST">
                            @csrf 
                            @method('DELETE')
                                <button type="button" onclick="hapusGuru({{ $g->id }}, '{{ $g->name }}')" class="text-red-600 border border-red-600 px-2 py-1 rounded text-xs hover:bg-red-50 transition">
                                Hapus
                                </button>
                            </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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