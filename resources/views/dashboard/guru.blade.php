@extends('layouts.dashboard')

@section('content')
<div class="space-y-6">
    
    @php
        $guru = Auth::user();
        $tahunAktif = \App\Models\TahunPelajaran::where('is_active', true)->first();
    @endphp

    {{-- HEADER DASHBOARD --}}
    <div class="bg-[#65825C] rounded-2xl p-6 md:p-10 text-white shadow-lg relative overflow-hidden">
        <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold mb-2">Halo, {{ $guru->name }}!</h1>
                <p class="opacity-90 text-sm md:text-base">
                    Selamat datang di Dashboard Guru. 
                    @if($tahunAktif)
                        Tahun Ajaran Aktif: <span class="font-bold text-yellow-300">{{ $tahunAktif->tahun }} ({{ $tahunAktif->semester }})</span>
                    @else
                        <span class="text-red-200 font-bold">Tahun Ajaran Belum Diset</span>
                    @endif
                </p>
            </div>
            
            {{-- Tombol Shortcut Wali Kelas --}}
            @if($guru->kelasPerwalian)
                <a href="{{ route('guru.walikelas.rekap') }}" class="bg-yellow-400 hover:bg-yellow-500 text-gray-900 px-6 py-3 rounded-full font-bold text-sm shadow-lg transition transform hover:scale-105 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    Masuk Menu Wali Kelas
                </a>
            @endif
        </div>

        <div class="absolute right-0 top-0 w-40 h-40 bg-white opacity-10 rounded-full blur-3xl -mr-10 -mt-10"></div>
        <div class="absolute left-0 bottom-0 w-24 h-24 bg-yellow-400 opacity-10 rounded-full blur-2xl -ml-5 -mb-5"></div>
    </div>

    {{-- KARTU INFO RINGKAS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <div class="bg-white p-6 rounded-xl shadow-sm border-t-4 border-[#65825C] flex items-center gap-4">
            <div class="w-16 h-16 flex-shrink-0 rounded-full border-2 border-gray-200 overflow-hidden bg-gray-100">
                @if($guru->foto)
                    <img src="{{ asset('storage/' . $guru->foto) }}" class="w-full h-full object-cover" alt="Foto Profil">
                @else
                    <svg class="w-full h-full text-gray-400 p-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                @endif
            </div>
            <div class="overflow-hidden">
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Akun Guru</p>
                <h3 class="font-bold text-gray-800 truncate">{{ $guru->name }}</h3>
                <p class="text-xs text-green-600 font-mono mt-1">{{ $guru->username }}</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border-t-4 border-blue-500 flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-xs font-bold uppercase tracking-wider">Jadwal Mengajar</p>
                @php
                    $jumlahKelas = DB::table('guru_mapel')
                                    ->where('user_id', $guru->id)
                                    ->where('tahun_pelajaran_id', $tahunAktif->id ?? 0)
                                    ->count();
                @endphp
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ $jumlahKelas }} <span class="text-sm font-normal text-gray-400">Kelas</span></p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border-t-4 {{ $guru->kelasPerwalian ? 'border-yellow-400' : 'border-gray-300' }} flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-xs font-bold uppercase tracking-wider">Tugas Tambahan</p>
                @if($guru->kelasPerwalian)
                    <p class="text-xl font-bold text-gray-800 mt-1">Wali Kelas {{ $guru->kelasPerwalian->nama_kelas }}</p>
                    <p class="text-xs text-green-600 mt-1">Aktif</p>
                @else
                    <p class="text-xl font-bold text-gray-400 mt-1">Tidak Ada</p>
                    <p class="text-xs text-gray-400 mt-1">-</p>
                @endif
            </div>
            <div class="w-12 h-12 {{ $guru->kelasPerwalian ? 'bg-yellow-100 text-yellow-600' : 'bg-gray-100 text-gray-400' }} rounded-full flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
        </div>
    </div>

    {{-- TABEL JADWAL --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-bold text-gray-800">Jadwal Mengajar & Input Nilai</h3>
            <span class="text-xs bg-gray-100 text-gray-500 px-2 py-1 rounded">Tahun: {{ $tahunAktif->tahun ?? '-' }}</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left min-w-[600px]">
                <thead class="bg-gray-50 text-gray-600 font-bold uppercase text-xs">
                    <tr>
                        <th class="p-4">Mata Pelajaran</th>
                        <th class="p-4">Kelas</th>
                        <th class="p-4 text-center">Status Nilai</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @php
                        $jadwals = DB::table('guru_mapel')
                                    ->join('mapels', 'guru_mapel.mapel_id', '=', 'mapels.id')
                                    ->join('kelas', 'guru_mapel.kelas_id', '=', 'kelas.id')
                                    ->where('guru_mapel.user_id', $guru->id)
                                    ->where('guru_mapel.tahun_pelajaran_id', $tahunAktif->id ?? 0)
                                    ->select('mapels.nama_mapel', 'kelas.nama_kelas', 'kelas.id as kelas_id', 'mapels.id as mapel_id')
                                    ->get();
                    @endphp

                    @forelse($jadwals as $jadwal)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4 font-bold text-gray-800">{{ $jadwal->nama_mapel }}</td>
                        <td class="p-4">
                            <span class="bg-blue-50 text-blue-600 px-2 py-1 rounded text-xs font-bold">
                                {{ $jadwal->nama_kelas }}
                            </span>
                        </td>
                        <td class="p-4 text-center">
                            @php
                                $cekNilai = \App\Models\Nilai::where('kelas_id', $jadwal->kelas_id)
                                                            ->where('mapel_id', $jadwal->mapel_id)
                                                            ->where('tahun_pelajaran_id', $tahunAktif->id ?? 0)
                                                            ->count();
                            @endphp
                            @if($cekNilai > 0)
                                <span class="text-green-600 text-xs flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Sudah Input ({{ $cekNilai }})
                                </span>
                            @else
                                <span class="text-gray-400 text-xs italic">Belum ada nilai</span>
                            @endif
                        </td>
                        
                        {{-- KOLOM AKSI: TOMBOL ABSENSI & NILAI --}}
                        <td class="p-4 text-right">
                            <div class="flex justify-end gap-2">
                                
                                {{-- 1. TOMBOL ABSENSI (UNGU) --}}
                                <a href="{{ route('guru.absensi.create', ['kelas_id' => $jadwal->kelas_id, 'mapel_id' => $jadwal->mapel_id]) }}" 
                                   class="inline-flex items-center bg-purple-600 hover:bg-purple-700 text-white px-3 py-2 rounded-lg text-xs font-bold transition shadow-sm"
                                   title="Input Absensi">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                    Absensi
                                </a>

                                {{-- 2. TOMBOL NILAI (HIJAU) --}}
                                <a href="{{ route('guru.nilai.create', ['kelas_id' => $jadwal->kelas_id, 'mapel_id' => $jadwal->mapel_id]) }}" 
                                   class="inline-flex items-center bg-[#65825C] hover:bg-[#546e4b] text-white px-3 py-2 rounded-lg text-xs font-bold transition shadow-sm"
                                   title="Input Nilai">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Nilai
                                </a>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <p>Belum ada jadwal mengajar di tahun ajaran ini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection