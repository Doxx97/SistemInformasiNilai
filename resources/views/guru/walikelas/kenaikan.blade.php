@extends('layouts.dashboard')

@section('content')
<div class="space-y-6">

    <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-purple-500">
        <h1 class="text-2xl font-bold text-gray-800">Manajemen Kenaikan Kelas</h1>
        <p class="text-gray-600">Kelas Saat Ini: <span class="font-bold">{{ $kelas->nama_kelas }}</span></p>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm">
        <h3 class="font-bold text-lg mb-4 text-gray-800 border-b pb-2">1. Input Status Rapor (Semester Genap)</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left min-w-[600px]">
                <thead class="bg-gray-100 font-bold text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="p-3">Nama Siswa</th>
                        <th class="p-3">Status Saat Ini</th>
                        <th class="p-3">Ubah Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($siswas as $s)
                    <tr class="hover:bg-gray-50">
                        <td class="p-3 font-bold">{{ $s->name }}</td>
                        <td class="p-3 text-blue-600 font-semibold">
                            {{ $s->status_kenaikan ?? '-' }}
                        </td>
                        <td class="p-3">
                            <form action="{{ route('guru.walikelas.update_status') }}" method="POST" class="flex gap-2">
                                @csrf
                                <input type="hidden" name="siswa_id" value="{{ $s->id }}">
                                
                                <input type="text" name="status" class="border rounded px-2 py-1 w-full text-xs" 
                                       placeholder="Contoh: Naik ke Kelas 2" value="{{ $s->status_kenaikan }}" required>
                                
                                <button class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700">Simpan</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-yellow-50 p-6 rounded-xl shadow-sm border border-yellow-200">
        <h3 class="font-bold text-lg mb-2 text-gray-800 flex items-center">
            <svg class="w-6 h-6 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
            2. Proses Pindah Kelas (Naik Kelas)
        </h3>
        <p class="text-sm text-gray-600 mb-4">
            Fitur ini akan memindahkan siswa yang dipilih ke <b>Kelas Baru</b>. Lakukan ini hanya saat tahun ajaran akan berganti.
        </p>

        <form action="{{ route('guru.walikelas.proses_naik') }}" method="POST" id="formPindahKelas">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Pindahkan Ke Kelas:</label>
                    <select name="target_kelas_id" class="w-full border p-2 rounded bg-white" required>
                        <option value="">-- Pilih Kelas Tujuan --</option>
                        @foreach($allKelas as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                        @endforeach
                        </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Siswa yang Naik:</label>
                    <div class="h-40 overflow-y-auto border p-2 rounded bg-white">
                        <div class="flex items-center mb-2 border-b pb-2">
                            <input type="checkbox" id="checkAll" class="mr-2">
                            <label for="checkAll" class="text-xs font-bold text-gray-500">Pilih Semua</label>
                        </div>

                        @foreach($siswas as $s)
                        <div class="flex items-center mb-1">
                            <input type="checkbox" name="siswa_ids[]" value="{{ $s->id }}" class="siswa-checkbox mr-2">
                            <span class="text-sm">{{ $s->name }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="text-right">
                <button type="button" onclick="konfirmasiPindah()" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-6 rounded shadow-lg transition transform hover:-translate-y-0.5">
                    PROSES PINDAH KELAS SEKARANG
                </button>
            </div>
        </form>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Script Check All
    document.getElementById('checkAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.siswa-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });

    // Konfirmasi SweetAlert
    function konfirmasiPindah() {
        Swal.fire({
            title: 'Yakin Pindahkan Siswa?',
            text: "Siswa yang dipilih akan berpindah ke Kelas Baru secara permanen.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Ya, Pindahkan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('formPindahKelas').submit();
            }
        })
    }
</script>
@endsection