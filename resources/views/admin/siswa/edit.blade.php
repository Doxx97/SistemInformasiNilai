@extends('layouts.dashboard')
@section('content')
<div class="max-w-lg mx-auto bg-white p-8 rounded-xl shadow-sm">
    <div class="flex justify-between items-center mb-6">
        <h3 class="font-bold text-xl">Edit Data Siswa</h3>
        <a href="{{ route('admin.siswa.index') }}" class="text-gray-500 hover:text-gray-700 text-sm">Kembali</a>
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

    <form action="{{ route('admin.siswa.update', $siswa->id) }}" method="POST" class="space-y-4" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div>
            <label class="text-sm font-bold text-gray-600 block mb-1">Nama Siswa</label>
            <input type="text" name="name" value="{{ $siswa->name }}" class="w-full border bg-gray-50 rounded p-2.5" required>
        </div>

        <div>
            <label class="text-sm font-bold text-gray-600 block mb-1">NISN</label>
            <input type="number" name="username" value="{{ $siswa->username }}" class="w-full border bg-gray-50 rounded p-2.5" required>
        </div>
        <div>
            <label class="text-xs font-bold text-gray-600">Foto Profil</label>
            <input type="file" name="foto" class="w-full text-xs bg-gray-100 rounded border p-2 mt-1">
            <p class="text-[10px] text-gray-400">*Format: JPG, PNG. Maks: 2MB.</p>
        </div>
        <div>
            <label class="text-sm font-bold text-gray-600 block mb-1">Kelas</label>
            <select name="kelas_id" class="w-full border bg-gray-50 rounded p-2.5">
                @foreach($kelasList as $k)
                    <option value="{{ $k->id }}" {{ $siswa->kelas_id == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kelas }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="text-sm font-bold text-gray-600 block mb-1">Password Baru <span class="font-normal text-gray-400">(Opsional)</span></label>
            <input type="text" name="password" class="w-full border bg-gray-50 rounded p-2.5" placeholder="Isi jika ingin reset password...">
        </div>

        <button class="w-full bg-yellow-500 text-white py-2.5 rounded-lg hover:bg-yellow-600 font-bold mt-4">Update Siswa</button>
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