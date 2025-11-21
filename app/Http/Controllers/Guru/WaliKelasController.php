<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\StatusRapor;
use App\Models\TahunPelajaran;

class WaliKelasController extends Controller
{
    public function rekap()
    {
        $guru = Auth::user();
        $kelas = $guru->kelasPerwalian;

        if (!$kelas) {
            return redirect()->back()->with('error', 'Anda bukan Wali Kelas.');
        }

        // Ambil Tahun Aktif
        $tahunAktif = TahunPelajaran::where('is_active', true)->first();

        // Cek Status Publikasi Rapor
        $statusRapor = StatusRapor::where('kelas_id', $kelas->id)
                        ->where('tahun_pelajaran_id', $tahunAktif->id)
                        ->first();
        
        $isPublished = $statusRapor && $statusRapor->is_published;

        $mapels = Mapel::all();
        
        // Ambil Siswa & Nilai (Sesuai Tahun Aktif)
        $siswas = User::where('role', 'walimurid')
                    ->where('kelas_id', $kelas->id)
                    ->with(['nilais' => function($q) use ($tahunAktif) {
                        $q->where('tahun_pelajaran_id', $tahunAktif->id);
                    }])
                    ->get();

        return view('guru.walikelas.rekap', compact('kelas', 'mapels', 'siswas', 'isPublished'));
    }

    // TAMBAHKAN FUNCTION PUBLISH INI
    public function publish()
    {
        $guru = Auth::user();
        $kelas = $guru->kelasPerwalian;
        $tahunAktif = TahunPelajaran::where('is_active', true)->first();

        // Update atau Create status menjadi TRUE (Published)
        StatusRapor::updateOrCreate(
            [
                'kelas_id' => $kelas->id,
                'tahun_pelajaran_id' => $tahunAktif->id
            ],
            [
                'is_published' => true
            ]
        );

        return back()->with('success', 'Rapor berhasil diterbitkan ke Wali Murid!');
    }

    // TAMBAHKAN FUNCTION UN-PUBLISH (Tarik Kembali) - Opsional
    public function unpublish()
    {
        $guru = Auth::user();
        $kelas = $guru->kelasPerwalian;
        $tahunAktif = TahunPelajaran::where('is_active', true)->first();

        StatusRapor::updateOrCreate(
            ['kelas_id' => $kelas->id, 'tahun_pelajaran_id' => $tahunAktif->id],
            ['is_published' => false]
        );

        return back()->with('success', 'Rapor ditarik kembali (Draft Mode).');
    }

    public function cetakRapor($siswa_id)
    {
        $guru = Auth::user();
        // Pastikan yang akses adalah wali kelas siswa tsb
        $siswa = User::findOrFail($siswa_id);
        
        if($siswa->kelas_id != $guru->kelasPerwalian->id){
             abort(403, 'Anda bukan Wali Kelas siswa ini');
        }

        $nilais = Nilai::where('siswa_id', $siswa_id)->with('mapel')->get();
        
        return view('guru.walikelas.rapor', compact('siswa', 'nilais', 'guru'));
    }

    // 1. FORM INPUT CATATAN
    public function formCatatan($siswa_id)
    {
        $guru = Auth::user();
        $siswa = User::findOrFail($siswa_id);

        // Security: Pastikan siswa ini muridnya wali kelas yang login
        if($siswa->kelas_id != $guru->kelasPerwalian->id){
             abort(403, 'Anda bukan Wali Kelas siswa ini');
        }

        return view('guru.walikelas.catatan', compact('siswa'));
    }

    // 2. PROSES SIMPAN CATATAN
    public function simpanCatatan(Request $request, $siswa_id)
    {
        $request->validate([
            'catatan' => 'required|string|max:1000'
        ]);

        $siswa = User::findOrFail($siswa_id);
        
        // Update kolom catatan
        $siswa->update([
            'catatan_wali_kelas' => $request->catatan
        ]);

        return redirect()->route('guru.walikelas.rekap')->with('success', 'Catatan untuk ' . $siswa->name . ' berhasil disimpan.');
    }
}