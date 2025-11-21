@extends('layouts.dashboard')
@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-sm">
    <div class="flex justify-between items-center mb-6">
        <h3 class="font-bold text-xl">Edit Data Guru</h3>
        <a href="{{ route('admin.guru.index') }}" class="text-gray-500 hover:text-gray-700 text-sm">Kembali</a>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
            <strong class="font-bold">Gagal Update!</strong>
            <ul class="mt-1 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
            <strong class="font-bold">Berhasil!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <form action="{{ route('admin.guru.update', $guru->id) }}" method="POST" class="space-y-6" enctype="multipart/form-data">
        @csrf 
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="text-sm font-bold text-gray-600 block mb-2">Nama Guru</label>
                <input type="text" name="name" value="{{ $guru->name }}" class="w-full border bg-gray-50 rounded p-2.5" required>
            </div>
            <div>
                <label class="text-sm font-bold text-gray-600 block mb-2">NIP / Username</label>
                <input type="text" name="username" value="{{ $guru->username }}" class="w-full border bg-gray-50 rounded p-2.5" required>
            </div>
        </div>
        <div>
            <label class="text-xs font-bold text-gray-600">Foto Profil</label>
            <input type="file" name="foto" class="w-full text-xs bg-gray-100 rounded border p-2 mt-1">
            <p class="text-[10px] text-gray-400">*Format: JPG, PNG. Maks: 2MB.</p>
        </div>
        <div>
            <label class="text-sm font-bold text-gray-600 block mb-2">Password Baru <span class="font-normal text-gray-400">(Kosongkan jika tidak ingin mengubah)</span></label>
            <input type="text" name="password" class="w-full border bg-gray-50 rounded p-2.5" placeholder="Masukkan password baru...">
        </div>

        <div class="border-t pt-4">
            <label class="text-sm font-bold text-gray-600 block mb-3">Assign Kelas & Mapel (Tahun Ini)</label>
            <div class="h-64 overflow-y-auto border p-4 rounded bg-gray-50 grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($mapels as $mapel)
                    <div class="bg-white p-3 rounded border">
                        <div class="font-bold text-xs text-gray-500 uppercase mb-2 border-b pb-1">
                            {{ $mapel->nama_mapel }}
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            @foreach($kelasList as $kelas)
                                @php
                                    $val = $mapel->id . '-' . $kelas->id;
                                    $checked = in_array($val, $assigned) ? 'checked' : '';
                                @endphp
                                <div class="flex items-center">
                                    <input type="checkbox" name="assign_mapel[]" value="{{ $val }}" {{ $checked }} class="mr-2 cursor-pointer">
                                    <span class="text-xs">Kelas {{ $kelas->nama_kelas }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div>
            <label class="text-sm font-bold text-gray-600 block mb-2">Tugas Tambahan (Wali Kelas)</label>
            <select name="wali_kelas_id" class="w-full border bg-gray-50 rounded p-2.5">
                <option value="">-- Bukan Wali Kelas --</option>
                @foreach($kelasList as $k)
                    <option value="{{ $k->id }}" {{ ($guru->kelasPerwalian && $guru->kelasPerwalian->id == $k->id) ? 'selected' : '' }}>
                        Wali Kelas {{ $k->nama_kelas }}
                    </option>
                @endforeach
            </select>
        </div>

        <button class="w-full bg-yellow-500 text-white py-3 rounded-lg hover:bg-yellow-600 font-bold shadow-lg">Update Data Guru</button>
    </form>
</div>
<script>
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