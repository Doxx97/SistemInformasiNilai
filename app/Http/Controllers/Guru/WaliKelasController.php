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

        foreach($siswas as $siswa) {
            $queryAbsen = \App\Models\Absensi::where('siswa_id', $siswa->id)
                            ->where('tahun_pelajaran_id', $tahunAktif->id)
                            ->where('status', 'terkirim'); // <--- TAMBAHAN PENTING (Filter Status)

            // Hitung total dari semua mapel yang sudah 'terkirim'
            $siswa->total_hadir = $queryAbsen->sum('hadir');
            $siswa->total_izin  = $queryAbsen->sum('izin');
            $siswa->total_sakit = $queryAbsen->sum('sakit');
            $siswa->total_alpha = $queryAbsen->sum('alpha');
            
            // Hitung berapa mapel yang sudah mengirim absen (Opsional, untuk info)
            $siswa->mapel_terkirim = $queryAbsen->count();
        }

        return view('guru.walikelas.rekap', compact('kelas', 'mapels', 'siswas', 'isPublished', 'tahunAktif'));
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

    public function cetakRapor($id)
    {
        // 1. Ambil Tahun Ajaran yang AKTIF
        $tahunAktif = \App\Models\TahunPelajaran::where('is_active', true)->first();

        if (!$tahunAktif) {
            return back()->with('error', 'Tahun pelajaran aktif belum diset!');
        }

        // 2. Ambil Data Siswa & Mapel
        $siswa = \App\Models\User::findOrFail($id);
        $mapels = \App\Models\Mapel::all();
        
        // 3. Ambil Data Wali Kelas & Kelas
        $kelas = $siswa->kelas;
        $waliKelas = $kelas->waliKelas;

        // 4. Kirim variabel $tahunAktif ke View
        return view('guru.walikelas.rapor', compact('siswa', 'mapels', 'kelas', 'waliKelas', 'tahunAktif'));
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
    // 1. TAMPILKAN HALAMAN KENAIKAN
    public function indexKenaikan()
    {
        $guru = Auth::user();
        // Cek apakah guru ini punya kelas
        $kelas = $guru->kelasPerwalian;
        
        if(!$kelas) {
            return back()->with('error', 'Anda bukan Wali Kelas.');
        }

        // Ambil semua siswa di kelas ini
        $siswas = \App\Models\User::where('role', 'walimurid')
                    ->where('kelas_id', $kelas->id)
                    ->orderBy('name')
                    ->get();
        
        // Ambil daftar SEMUA kelas (untuk target kenaikan)
        $allKelas = \App\Models\Kelas::all();

        return view('guru.walikelas.kenaikan', compact('kelas', 'siswas', 'allKelas'));
    }

    // 2. SIMPAN STATUS TEKS (Untuk Tampilan Rapor)
    public function updateStatusKenaikan(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required',
            'status' => 'required', // "Naik ke Kelas X" atau "Tinggal"
        ]);

        $siswa = \App\Models\User::findOrFail($request->siswa_id);
        $siswa->update(['status_kenaikan' => $request->status]);

        return back()->with('success', 'Status berhasil disimpan.');
    }

    // 3. EKSEKUSI PINDAH KELAS (Perubahan Data Fisik)
    public function prosesNaikKelas(Request $request)
    {
        $request->validate([
            'target_kelas_id' => 'required|exists:kelas,id',
            'siswa_ids' => 'required|array' // Array ID siswa yang dipilih
        ]);

        // Pindahkan siswa-siswa yang dipilih ke kelas baru
        \App\Models\User::whereIn('id', $request->siswa_ids)
            ->update([
                'kelas_id' => $request->target_kelas_id,
                // Reset status kenaikan agar rapor tahun depan bersih
                'status_kenaikan' => null 
            ]);

        return back()->with('success', 'Siswa berhasil dipindahkan ke kelas baru!');
    }
}