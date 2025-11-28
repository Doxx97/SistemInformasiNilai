<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\TahunPelajaran;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
{
    // 1. HALAMAN INPUT
    public function create($kelas_id, $mapel_id)
    {
        $kelas = Kelas::findOrFail($kelas_id);
        $mapel = Mapel::findOrFail($mapel_id);

        $tahunAktif = TahunPelajaran::where('is_active', true)->first();
        if (!$tahunAktif) return back()->with('error', 'Tahun aktif belum diset!');

        $siswas = User::where('kelas_id', $kelas_id)
                    ->whereIn('role', ['walimurid', 'siswa'])
                    ->with(['nilais' => function($q) use ($mapel_id, $tahunAktif) {
                        $q->where('mapel_id', $mapel_id)->where('tahun_pelajaran_id', $tahunAktif->id);
                    }])
                    ->orderBy('name')
                    ->get();

        return view('guru.nilai.input', compact('kelas', 'mapel', 'siswas', 'tahunAktif'));
    }

    // 2. PROSES SIMPAN
    public function store(Request $request)
    {
        $siswaIds = $request->siswa_id;
        if (empty($siswaIds) || !is_array($siswaIds)) {
            return back()->with('error', 'Tidak ada siswa.');
        }

        $harian = $request->harian; 
        $uts = $request->uts;
        $uas = $request->uas;
        $aksi = $request->aksi; 
        $guruId = Auth::id(); 

        foreach ($siswaIds as $siswaId) {
            // Harian
            $nilaiHarianSiswa = $harian[$siswaId] ?? [];
            $totalHarian = 0; $jumlahDiisi = 0;
            if (is_array($nilaiHarianSiswa)) {
                foreach($nilaiHarianSiswa as $n) {
                    if($n !== null && $n !== '') { $totalHarian += $n; $jumlahDiisi++; }
                }
            }
            $rataHarian = $jumlahDiisi > 0 ? $totalHarian / $jumlahDiisi : 0;

            // UTS UAS
            $inputUts = $uts[$siswaId] ?? null;
            $inputUas = $uas[$siswaId] ?? null;
            $nilaiUts = ($inputUts === null || $inputUts === '') ? null : $inputUts;
            $nilaiUas = ($inputUas === null || $inputUas === '') ? null : $inputUas;

            // Hitung Akhir
            $hitungUts = $nilaiUts ?? 0;
            $hitungUas = $nilaiUas ?? 0;
            $nilaiAkhir = ($rataHarian * 0.5) + ($hitungUts * 0.25) + ($hitungUas * 0.25);

            $status = ($aksi == 'kirim_wali') ? 'terkirim' : 'draft';

            Nilai::updateOrCreate(
                [
                    'siswa_id' => $siswaId,
                    'mapel_id' => $request->mapel_id,
                    'kelas_id' => $request->kelas_id,
                    'tahun_pelajaran_id' => $request->tahun_pelajaran_id
                ],
                [
                    'guru_id' => $guruId,
                    'detail_harian' => $nilaiHarianSiswa, 
                    'uts' => $nilaiUts, 
                    'uas' => $nilaiUas, 
                    'nilai' => round($nilaiAkhir),
                    'status' => $status
                ]
            );
        }

        if($aksi == 'kirim_wali'){
            return back()->with('success', 'Nilai berhasil dikirim ke Wali Kelas!');
        } else {
            return back()->with('success', 'Nilai berhasil disimpan sebagai Draft.');
        }
    }

    // 3. HAPUS / RESET NILAI (INI YANG PENTING)
    public function destroy($id)
    {
        $nilai = Nilai::findOrFail($id);
        $nilai->delete(); // Hapus data

        return back()->with('success', 'Data nilai berhasil di-reset (dihapus).');
    }
    
    // 4. Pilih Kelas (Opsional)
    public function pilihKelas($mapel_id) { /* ... kode pilih kelas ... */ }
}