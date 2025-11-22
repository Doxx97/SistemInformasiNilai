@extends('layouts.dashboard')

@section('content')
<div class="space-y-6">
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <div class="bg-white p-6 rounded-xl shadow-sm h-fit">
            <h3 class="font-bold mb-4 text-lg border-b pb-2">Tambah Guru Baru</h3>
            
            {{-- Form dengan Upload Foto --}}
            <form action="{{ route('admin.guru.store') }}" method="POST" class="space-y-4" enctype="multipart/form-data">
                @csrf
                <div>
                    <label class="text-xs font-bold text-gray-600">Nama Lengkap</label>
                    <input type="text" name="name" class="w-full border bg-gray-50 rounded p-2 mt-1 focus:ring-2 focus:ring-[#65825C] outline-none" required placeholder="Contoh: Budi Santoso, S.Pd">
                </div>
                
                <div>
                    <label class="text-xs font-bold text-gray-600">NIP / Username</label>
                    <input type="number" name="username" class="w-full border bg-gray-50 rounded p-2 mt-1 focus:ring-2 focus:ring-[#65825C] outline-none" required placeholder="1987xxxxx">
                </div>

                <div>
                    <label class="text-xs font-bold text-gray-600">Password</label>
                    <input type="text" name="password" class="w-full border bg-gray-50 rounded p-2 mt-1 focus:ring-2 focus:ring-[#65825C] outline-none" required placeholder="Min. 6 karakter">
                </div>

                <div>
                    <label class="text-xs font-bold text-gray-600">Foto Profil</label>
                    <input type="file" name="foto" onchange="cekUkuranFoto(this)" class="w-full text-xs bg-gray-100 rounded border p-2 mt-1" accept="image/*">
                    <p class="text-[10px] text-gray-400 mt-1">*Format: JPG, PNG. Maks: 2MB.</p>
                </div>

                <div>
                    <label class="text-xs font-bold text-gray-600 block mb-2">Jadwal Mengajar (Tahun Aktif)</label>
                    <div class="h-32 overflow-y-auto border p-2 rounded bg-gray-50 text-xs">
                        @foreach($mapels as $mapel)
                            <div class="font-bold text-gray-500 mt-2 mb-1">{{ $mapel->nama_mapel }}</div>
                            @foreach($kelasList as $kelas)
                                <div class="flex items-center mb-1">
                                    <input type="checkbox" name="assign_mapel[]" value="{{ $mapel->id }}-{{ $kelas->id }}" class="mr-2">
                                    <span>Kelas {{ $kelas->nama_kelas }}</span>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>

                <div>
                    <label class="text-xs font-bold text-gray-600 block mb-1">Tugas Tambahan</label>
                    <select name="wali_kelas_id" class="w-full border bg-gray-50 rounded p-2 text-xs">
                        <option value="">-- Bukan Wali Kelas --</option>
                        @foreach($kelasList as $k)
                            <option value="{{ $k->id }}">Wali Kelas {{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>

                <button class="w-full bg-[#65825C] text-white py-2 rounded hover:bg-[#546e4b] font-bold text-sm transition">Simpan Data</button>
            </form>
        </div>

        <div class="md:col-span-2 bg-white p-6 rounded-xl shadow-sm">
            <h3 class="font-bold mb-4 text-lg flex items-center justify-between">
                <span>Daftar Guru</span>
                <span class="text-xs font-normal bg-green-100 text-green-800 px-2 py-1 rounded-full">Total: {{ $gurus->count() }}</span>
            </h3>
            
            {{-- === PERUBAHAN RESPONSIF DISINI (overflow-x-auto) === --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left border min-w-[600px]">
                    <thead class="bg-gray-100 font-bold text-gray-700 uppercase text-xs">
                        <tr>
                            <th class="p-3 border">Foto</th>
                            <th class="p-3 border">Nama / NIP</th>
                            <th class="p-3 border">Wali Kelas</th>
                            <th class="p-3 border">Mapel Ajar</th>
                            <th class="p-3 border text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($gurus as $g)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="p-3 border text-center w-16">
                                <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-200 mx-auto">
                                    @if($g->foto)
                                        <img src="{{ asset('storage/' . $g->foto) }}" class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-full h-full text-gray-400 p-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                                    @endif
                                </div>
                            </td>
                            <td class="p-3 border">
                                <div class="font-bold text-gray-800">{{ $g->name }}</div>
                                <div class="text-xs text-gray-500">{{ $g->username }}</div>
                            </td>
                            <td class="p-3 border">
                                @if($g->kelasPerwalian)
                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-2 py-1 rounded">Kelas {{ $g->kelasPerwalian->nama_kelas }}</span>
                                @else
                                    <span class="text-gray-400 text-xs">-</span>
                                @endif
                            </td>
                            <td class="p-3 border">
                                <div class="flex flex-wrap gap-1">
                                    @foreach($g->mapels->unique('nama_mapel') as $m)
                                        <span class="bg-blue-50 text-blue-600 px-2 py-0.5 rounded text-[10px] border border-blue-100">{{ $m->nama_mapel }}</span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="p-3 border text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.guru.edit', $g->id) }}" class="text-yellow-600 border border-yellow-600 px-2 py-1 rounded text-xs hover:bg-yellow-50">Edit</a>
                                    
                                    <form id="delete-guru-{{ $g->id }}" action="{{ route('admin.guru.destroy', $g->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="hapusGuru({{ $g->id }}, '{{ $g->name }}')" class="text-red-600 border border-red-600 px-2 py-1 rounded text-xs hover:bg-red-50">Hapus</button>
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
</div>

{{-- Script Validasi Ukuran Foto & Hapus --}}
<script>
    function cekUkuranFoto(input) {
        const file = input.files[0];
        if (file && file.size > 2 * 1024 * 1024) {
            Swal.fire({ icon: 'error', title: 'Terlalu Besar!', text: 'Maksimal ukuran foto 2MB.', confirmButtonColor: '#65825C' });
            input.value = ''; 
        }
    }

    function hapusGuru(id, nama) {
        Swal.fire({
            title: 'Hapus ' + nama + '?',
            text: "Data jadwal dan akun akan terhapus permanen!",
            icon: 'warning', showCancelButton: true, confirmButtonColor: '#d33', cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) { document.getElementById('delete-guru-' + id).submit(); }
        })
    }
</script>
@endsection