@extends('layouts.dashboard')

@section('content')
<div class="space-y-6">
    
    <div class="flex flex-col md:flex-row justify-between items-center bg-white p-6 rounded-xl shadow-sm border-l-4 border-[#65825C]">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Data Guru & Staf</h1>
            <p class="text-gray-500 text-sm">Kelola data pengajar dan jadwal mata pelajaran</p>
        </div>
        <div class="mt-4 md:mt-0">
            <span class="bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded-full">
                Total: {{ $gurus->count() }} Guru
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <h3 class="font-bold text-lg mb-4 border-b pb-2 flex items-center text-gray-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    Tambah Guru Baru
                </h3>
                
                <form action="{{ route('admin.guru.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1 uppercase">Nama Lengkap</label>
                        <input type="text" name="name" class="w-full bg-gray-50 border border-gray-200 rounded p-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#65825C]" required placeholder="Nama Guru + Gelar">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1 uppercase">NIP / Username</label>
                        <input type="text" name="username" class="w-full bg-gray-50 border border-gray-200 rounded p-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#65825C]" required placeholder="NIP (untuk login)">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1 uppercase">Password</label>
                        <input type="text" name="password" class="w-full bg-gray-50 border border-gray-200 rounded p-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#65825C]" required placeholder="Default: 123456">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1 uppercase">Foto Profil</label>
                        <input type="file" name="foto" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100" accept="image/*">
                        <p class="text-[10px] text-gray-400 mt-1">*Opsional. Maks 2MB.</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-2 uppercase">Jadwal Mengajar</label>
                        <div class="h-32 overflow-y-auto border border-gray-200 p-2 rounded bg-gray-50 text-xs scrollbar-thin">
                            @foreach($mapels as $mapel)
                                <div class="font-bold text-green-600 mt-2 mb-1 border-b border-blue-100 pb-1">{{ $mapel->nama_mapel }}</div>
                                @foreach($kelasList as $kelas)
                                    <div class="flex items-center mb-1 pl-2">
                                        <input type="checkbox" name="assign_mapel[]" value="{{ $mapel->id }}-{{ $kelas->id }}" class="mr-2 rounded text-blue-600 focus:ring-blue-500">
                                        <span class="text-gray-600">Kelas {{ $kelas->nama_kelas }}</span>
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1 uppercase">Tugas Tambahan (Wali Kelas)</label>
                        <select name="wali_kelas_id" class="w-full bg-gray-50 border border-gray-200 rounded p-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#65825C]">
                            <option value="">-- Bukan Wali Kelas --</option>
                            @foreach($kelasList as $k)
                                <option value="{{ $k->id }}">Wali Kelas {{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="w-full bg-[#65825C] hover:bg-[#546e4b] text-white font-bold py-2.5 rounded shadow-md transition text-sm">
                        Simpan Data Guru
                    </button>
                </form>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                
                <div class="p-4 border-b bg-gray-50 flex justify-between items-center">
                    <h3 class="font-bold text-gray-700">Daftar Guru</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left min-w-[600px]">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                            <tr>
                                <th class="p-4 text-center w-10">No</th> <th class="p-4 text-center w-16">Foto</th>
                                <th class="p-4">Nama / NIP</th>
                                <th class="p-4">Tugas</th>
                                <th class="p-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($gurus as $index => $g)
                            <tr class="hover:bg-gray-50 transition">
                                
                                <td class="p-4 text-center text-gray-500 font-medium">
                                    {{ $index + 1 }}
                                </td>

                                <td class="p-4 text-center">
                                    <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-200 mx-auto border border-gray-300 shadow-sm">
                                        @if($g->foto)
                                            <img src="{{ asset('storage/' . $g->foto) }}" class="w-full h-full object-cover" alt="Foto">
                                        @else
                                            <svg class="w-full h-full text-gray-400 p-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                                        @endif
                                    </div>
                                </td>

                                <td class="p-4">
                                    <div class="font-bold text-gray-800">{{ $g->name }}</div>
                                    <div class="text-xs text-gray-500 font-mono mt-0.5">NIP: {{ $g->username }}</div>
                                </td>

                                <td class="p-4">
                                    <div class="space-y-1">
                                        @if($g->kelasPerwalian)
                                            <span class="inline-block bg-yellow-100 text-yellow-800 text-[10px] font-bold px-2 py-0.5 rounded border border-yellow-200">
                                                Wali Kelas {{ $g->kelasPerwalian->nama_kelas }}
                                            </span>
                                        @endif
                                        
                                        <div class="flex flex-wrap gap-1 mt-1">
                                            @forelse($g->mapels->unique('nama_mapel') as $m)
                                                <span class="bg-blue-50 text-blue-600 px-1.5 py-0.5 rounded text-[10px] border border-blue-100">
                                                    {{ $m->nama_mapel }}
                                                </span>
                                            @empty
                                                <span class="text-gray-400 text-[10px] italic">- Tidak ada mapel -</span>
                                            @endforelse
                                        </div>
                                    </div>
                                </td>

                                <td class="p-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('admin.guru.edit', $g->id) }}" class="text-yellow-600 border border-yellow-600 px-2 py-1 rounded text-xs hover:bg-yellow-50 font-bold">Edit</a>
                                        
                                        <form id = "delete-form-{{ $g->id }}" action="{{ route('admin.guru.destroy', $g->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="konfirmasiHapus({{ $g->id }})" class="text-red-600 border border-red-600 px-2 py-1 rounded text-xs hover:bg-red-50 font-bold">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-gray-400 italic">
                                    Belum ada data guru. Silakan tambah di formulir sebelah kiri.
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function konfirmasiHapus(id) {
        Swal.fire({
            title: 'Yakin hapus data guru ini?',
            text: "Hati-hati! Data guru akan hilang selamanya!.",
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