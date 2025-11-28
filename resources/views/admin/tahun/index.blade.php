@extends('layouts.dashboard')

@section('content')
<div class="space-y-6">
    
    <div class="flex flex-col md:flex-row justify-between items-center bg-white p-6 rounded-xl shadow-sm border-l-4 border-[#65825C]">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Tahun Pelajaran</h1>
            <p class="text-gray-500 text-sm">Atur tahun ajaran dan semester aktif</p>
        </div>
        <div class="mt-4 md:mt-0 text-right">
            @php $aktif = $tahuns->where('is_active', 1)->first(); @endphp
            <p class="text-xs text-gray-500 uppercase">Sedang Aktif:</p>
            <span class="bg-green-100 text-green-800 text-sm font-bold px-4 py-1 rounded-full border border-green-200">
                {{ $aktif ? $aktif->tahun . ' (' . $aktif->semester . ')' : 'Belum Diset' }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <h3 class="font-bold text-lg mb-4 border-b pb-2 flex items-center text-gray-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Tambah Periode Baru
                </h3>
                
                <form action="{{ route('admin.tahun.store') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1 uppercase">Tahun Pelajaran</label>
                        <input type="text" name="tahun" class="w-full bg-gray-50 border border-gray-200 rounded p-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500" required placeholder="Contoh: 2024/2025">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1 uppercase">Semester</label>
                        <select name="semester" class="w-full bg-gray-50 border border-gray-200 rounded p-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                            <option value="Ganjil">Ganjil</option>
                            <option value="Genap">Genap</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full bg-[#65825C] hover:bg-[#546e4b] text-white font-bold py-2.5 rounded shadow-md transition text-sm">
                        Simpan & Buat Baru
                    </button>
                </form>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                
                <div class="p-4 border-b bg-gray-50">
                    <h3 class="font-bold text-gray-700">Riwayat Tahun Ajaran</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left min-w-[500px]">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                            <tr>
                                <th class="p-4 text-center w-10">No</th>
                                <th class="p-4">Tahun</th>
                                <th class="p-4">Semester</th>
                                <th class="p-4 text-center">Status</th>
                                <th class="p-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($tahuns as $index => $t)
                            <tr class="hover:bg-gray-50 transition {{ $t->is_active ? 'bg-green-50' : '' }}">
                                <td class="p-4 text-center text-gray-500 font-medium">
                                    {{ $index + 1 }}
                                </td>
                                <td class="p-4 font-bold text-gray-800">
                                    {{ $t->tahun }}
                                </td>
                                <td class="p-4">
                                    <span class="px-2 py-1 text-xs rounded border {{ $t->semester == 'Ganjil' ? 'bg-blue-50 text-blue-700 border-blue-200' : 'bg-yellow-50 text-yellow-700 border-yellow-200' }}">
                                        {{ $t->semester }}
                                    </span>
                                </td>
                                <td class="p-4 text-center">
                                    @if($t->is_active)
                                        <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold border border-green-200 shadow-sm">
                                            <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                                            Aktif
                                        </span>
                                    @else
                                        <form action="{{ route('admin.tahun.update', $t->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="set_active" value="1">
                                            <button class="text-gray-400 hover:text-green-600 hover:underline text-xs font-bold transition">
                                                Aktifkan
                                            </button>
                                        </form>
                                    @endif
                                </td>
                                <td class="p-4 text-center">
                                    <form id = "delete-form-{{ $t->id }}" action="{{ route('admin.tahun.destroy', $t->id) }}" method="POST" onsubmit="return confirm('Hapus tahun ini? Hati-hati, data nilai terkait bisa error!');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="konfirmasiHapus({{ $t->id }})" class="text-red-600 border border-red-600 px-2 py-1 rounded text-xs hover:bg-red-50 font-bold">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-gray-400 italic">
                                    Belum ada data tahun pelajaran.
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
            title: 'Yakin hapus siswa ini?',
            text: "Hati-hati! Data tahun ajaran akan hilang selamanya!",
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