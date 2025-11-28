@extends('layouts.dashboard')

@section('content')
<div class="space-y-6">
    
    <div class="flex flex-col md:flex-row justify-between items-center bg-white p-6 rounded-xl shadow-sm border-l-4 border-[#65825C]">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Data Siswa</h1>
            <p class="text-gray-500 text-sm">Kelola data peserta didik SDN Liga Nusantara</p>
        </div>
        <div class="mt-4 md:mt-0">
            <span class="bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded-full">
                Total: {{ $siswas->count() }} Siswa
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <h3 class="font-bold text-lg mb-4 border-b pb-2 flex items-center text-gray-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    Tambah Siswa Baru
                </h3>
                
                <form action="{{ route('admin.siswa.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1 uppercase">Nama Lengkap</label>
                        <input type="text" name="name" class="w-full bg-gray-50 border border-gray-200 rounded p-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#65825C]" required placeholder="Nama Siswa">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1 uppercase">NISN / Username</label>
                        <input type="number" name="username" class="w-full bg-gray-50 border border-gray-200 rounded p-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#65825C]" required placeholder="Nomor Induk Siswa">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1 uppercase">Password</label>
                        <input type="text" name="password" class="w-full bg-gray-50 border border-gray-200 rounded p-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#65825C]" required placeholder="Default: 123456">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1 uppercase">Kelas</label>
                        <select name="kelas_id" class="w-full bg-gray-50 border border-gray-200 rounded p-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#65825C]">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($kelasList as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1 uppercase">Foto Profil</label>
                        <input type="file" name="foto" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100" accept="image/*">
                        <p class="text-[10px] text-gray-400 mt-1">*Opsional. Maks 2MB.</p>
                    </div>

                    <button type="submit" class="w-full bg-[#65825C] hover:bg-[#546e4b] text-white font-bold py-2 rounded shadow-md transition text-sm">
                        Simpan Siswa
                    </button>
                </form>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                
                <div class="p-4 border-b bg-gray-50 flex justify-between items-center">
                    <h3 class="font-bold text-gray-700">Daftar Siswa</h3>
                    <form action="{{ route('admin.siswa.index') }}" method="GET" class="flex items-center">
                        <select name="filter_kelas" onchange="this.form.submit()" class="text-xs border rounded p-1 bg-white">
                            <option value="">Semua Kelas</option>
                            @foreach($kelasList as $k)
                                <option value="{{ $k->id }}" {{ request('filter_kelas') == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left min-w-[600px]">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                            <tr>
                                <th class="p-4 text-center w-10">No</th>
                                <th class="p-4 text-center w-20">Foto</th> {{-- KOLOM BARU --}}
                                <th class="p-4">Nama Siswa</th>
                                <th class="p-4">NISN</th>
                                <th class="p-4 text-center">Kelas</th>
                                <th class="p-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($siswas as $index => $s)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 text-center text-gray-500">{{ $index + 1 }}</td>
                                
                                {{-- BAGIAN FOTO (Mirip Guru) --}}
                                <td class="p-4 text-center">
                                    <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-200 mx-auto border border-gray-300 shadow-sm">
                                        @if($s->foto)
                                            <img src="{{ asset('storage/' . $s->foto) }}" class="w-full h-full object-cover" alt="Foto">
                                        @else
                                            <svg class="w-full h-full text-gray-400 p-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                                        @endif
                                    </div>
                                </td>

                                <td class="p-4 font-bold text-gray-800">
                                    {{ $s->name }}
                                </td>
                                <td class="p-4 text-gray-600 font-mono text-xs">
                                    {{ $s->username }}
                                </td>
                                <td class="p-4 text-center">
                                    @if($s->kelas)
                                        <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2 py-1 rounded">
                                            {{ $s->kelas->nama_kelas }}
                                        </span>
                                    @else
                                        <span class="text-red-400 text-xs italic">Belum Masuk Kelas</span>
                                    @endif
                                </td>
                                <td class="p-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('admin.siswa.edit', $s->id) }}" class="text-yellow-600 border border-yellow-600 px-2 py-1 rounded text-xs hover:bg-yellow-50 font-bold">Edit</a>
                                        
                                        <form id = "delete-form-{{ $s->id }}" action="{{ route('admin.siswa.destroy', $s->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="konfirmasiHapus({{ $s->id }})" class="text-red-600 border border-red-600 px-2 py-1 rounded text-xs hover:bg-red-50 font-bold">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="p-8 text-center text-gray-400 italic">
                                    Belum ada data siswa. Silakan tambah di formulir sebelah kiri.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="p-4 border-t">
                    {{-- {{ $siswas->links() }} --}} 
                </div>

            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function konfirmasiHapus(id) {
        Swal.fire({
            title: 'Yakin hapus siswa ini?',
            text: "Hati-hati! Data siswa akan hilang selamanya!",
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