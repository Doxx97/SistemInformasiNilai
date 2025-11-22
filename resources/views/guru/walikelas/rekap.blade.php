@extends('layouts.dashboard')

@section('content')
<div class="space-y-6">
    
    <div class="flex flex-col md:flex-row justify-between items-center bg-white p-6 rounded-xl shadow-sm border-l-4 border-yellow-500">
        <div class="mb-4 md:mb-0">
            <h1 class="text-2xl font-bold text-gray-800">Rekapitulasi Nilai (Leger)</h1>
            <p class="text-gray-600 flex items-center gap-2 mt-1">
                <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-2 py-1 rounded uppercase">Wali Kelas</span>
                <span class="font-bold text-lg">{{ $kelas->nama_kelas }}</span>
            </p>
        </div>
        <div class="text-right">
            <p class="text-sm text-gray-500 uppercase tracking-wider">Tahun Pelajaran</p>
            @php $tahunAktif = \App\Models\TahunPelajaran::where('is_active', true)->first(); @endphp
            <p class="font-bold text-xl text-gray-800">{{ $tahunAktif->tahun ?? '-' }} <span class="text-sm font-normal text-gray-500">({{ $tahunAktif->semester ?? '' }})</span></p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
        
        <div>
            <h3 class="font-bold text-gray-700 mb-1">Status Penerbitan Rapor</h3>
            @if($isPublished)
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center justify-center w-8 h-8 bg-green-100 rounded-full"><svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg></span>
                    <div><p class="text-green-700 font-bold text-sm uppercase">Sudah Diterbitkan</p><p class="text-xs text-gray-500">Wali murid dapat melihat nilai.</p></div>
                </div>
            @else
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center justify-center w-8 h-8 bg-orange-100 rounded-full"><svg class="w-5 h-5 text-orange-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg></span>
                    <div><p class="text-orange-700 font-bold text-sm uppercase">Draft (Belum Terbit)</p><p class="text-xs text-gray-500">Wali murid belum bisa melihat nilai.</p></div>
                </div>
            @endif
        </div>

        <div>
            @if($isPublished)
                <form id="form-unpublish" action="{{ route('guru.walikelas.unpublish') }}" method="POST">
                    @csrf
                    <button type="button" onclick="konfirmasiTarik()" class="group flex items-center bg-gray-100 text-gray-600 px-5 py-2.5 rounded-lg hover:bg-red-50 hover:text-red-600 text-sm font-bold transition border border-gray-200">
                        <svg class="w-4 h-4 mr-2 text-gray-400 group-hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Tarik Kembali (Unpublish)
                    </button>
                </form>
            @else
                <form id="form-publish" action="{{ route('guru.walikelas.publish') }}" method="POST">
                    @csrf
                    <button type="button" onclick="konfirmasiTerbit()" class="flex items-center bg-blue-600 text-white px-6 py-2.5 rounded-lg hover:bg-blue-700 text-sm font-bold shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        Terbitkan Rapor
                    </button>
                </form>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 overflow-hidden">
        <h3 class="font-bold text-gray-800 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Detail Nilai Siswa
        </h3>
        
        {{-- === WRAPPER RESPONSIF === --}}
        <div class="overflow-x-auto pb-4">
            <table class="w-full text-sm text-left border-collapse border border-gray-200 min-w-[800px]">
                <thead class="bg-gray-800 text-white font-bold text-xs uppercase text-center">
                    <tr>
                        <th rowspan="2" class="p-3 border border-gray-600 w-10 bg-gray-900 sticky left-0 z-20">No</th>
                        <th rowspan="2" class="p-3 border border-gray-600 text-left min-w-[200px] bg-gray-900 sticky left-10 z-20">Nama Siswa</th>
                        <th colspan="{{ $mapels->count() }}" class="p-2 border border-gray-600 bg-gray-800">Mata Pelajaran</th>
                        <th rowspan="2" class="p-3 border border-gray-600 w-24 bg-gray-900">Aksi</th>
                    </tr>
                    <tr>
                        @foreach($mapels as $mapel)
                            <th class="p-2 border border-gray-600 w-16 text-[10px]">{{ $mapel->nama_mapel }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach($siswas as $index => $siswa)
                    <tr class="hover:bg-gray-50 border-b border-gray-200 transition">
                        <td class="p-2 text-center border border-gray-200 font-medium bg-white sticky left-0 z-10">{{ $index + 1 }}</td>
                        <td class="p-2 font-medium border border-gray-200 text-gray-900 bg-white sticky left-10 z-10 shadow-sm whitespace-nowrap">{{ $siswa->name }}</td>
                        
                        @foreach($mapels as $mapel)
                            @php
                                $nilai = $siswa->nilais->where('mapel_id', $mapel->id)->first();
                                $skor = $nilai ? $nilai->nilai : 0;
                                $warnatext = $skor < 70 ? 'text-red-500 font-bold' : 'text-gray-600';
                            @endphp
                            <td class="p-2 text-center border border-gray-200 {{ $warnatext }}">{{ $skor > 0 ? $skor : '-' }}</td>
                        @endforeach

                        <td class="p-2 text-center border border-gray-200">
                            <div class="flex justify-center gap-1">
                                <a href="{{ route('guru.walikelas.catatan', $siswa->id) }}" class="bg-yellow-100 text-yellow-600 p-1.5 rounded hover:bg-yellow-200" title="Catatan"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></a>
                                <a href="{{ route('guru.walikelas.rapor', $siswa->id) }}" target="_blank" class="bg-blue-100 text-blue-600 p-1.5 rounded hover:bg-blue-200" title="Cetak"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg></a>
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
<script>
    function konfirmasiTerbit() {
        Swal.fire({ title: 'Terbitkan Rapor?', text: "Wali Murid akan bisa melihat nilai.", icon: 'question', showCancelButton: true, confirmButtonText: 'Ya, Terbitkan!' }).then((result) => { if (result.isConfirmed) { document.getElementById('form-publish').submit(); } })
    }
    function konfirmasiTarik() {
        Swal.fire({ title: 'Tarik Kembali?', text: "Rapor akan kembali ke Draft.", icon: 'warning', showCancelButton: true, confirmButtonColor: '#d33', confirmButtonText: 'Ya, Tarik!' }).then((result) => { if (result.isConfirmed) { document.getElementById('form-unpublish').submit(); } })
    }
</script>
@endsection