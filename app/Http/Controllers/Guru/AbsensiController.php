<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Absensi;
use App\Models\TahunPelajaran;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    // HALAMAN INPUT ABSENSI (GRID 1-16)
    public function create($kelas_id, $mapel_id)
    {
        $guru = Auth::user();
        $kelas = Kelas::findOrFail($kelas_id);
        $mapel = Mapel::findOrFail($mapel_id);
        
        $tahunAktif = TahunPelajaran::where('is_active', true)->first();
        if (!$tahunAktif) return back()->with('error', 'Tahun aktif belum diset!');

        $siswas = User::where('kelas_id', $kelas_id)
                    ->whereIn('role', ['walimurid', 'siswa'])
                    ->orderBy('name')
                    ->get();

        return view('guru.absensi.input', compact('kelas', 'mapel', 'siswas', 'tahunAktif'));
    }

    // PROSES SIMPAN ABSENSI
    public function store(Request $request)
    {
        $guruId = Auth::id();
        $aksi = $request->aksi; 
        $absensiInput = $request->absensi; // Array [siswa_id][pertemuan]

        // Loop setiap siswa
        if($request->siswa_id){
            foreach ($request->siswa_id as $siswaId) {
                
                $detailAbsensi = $absensiInput[$siswaId] ?? [];

                // Hitung Rekap
                $h = 0; $i_count = 0; $s = 0; $a = 0;
                if(is_array($detailAbsensi)) {
                    foreach($detailAbsensi as $ket) {
                        if($ket == 'H') $h++;
                        elseif($ket == 'I') $i_count++;
                        elseif($ket == 'S') $s++;
                        elseif($ket == 'A') $a++;
                    }
                }

                $status = ($aksi == 'kirim_wali') ? 'terkirim' : 'draft';

                Absensi::updateOrCreate(
                    [
                        'siswa_id' => $siswaId,
                        'mapel_id' => $request->mapel_id,
                        'kelas_id' => $request->kelas_id,
                        'tahun_pelajaran_id' => $request->tahun_pelajaran_id,
                    ],
                    [
                        'guru_id' => $guruId,
                        'detail_absensi' => $detailAbsensi,
                        'hadir' => $h,
                        'izin'  => $i_count,
                        'sakit' => $s,
                        'alpha' => $a,
                        'status' => $status
                    ]
                );
            }
        }

        if($aksi == 'kirim_wali') {
            return back()->with('success', 'Absensi berhasil dikirim ke Wali Kelas!');
        }
        return back()->with('success', 'Absensi berhasil disimpan sementara.');
    }
}