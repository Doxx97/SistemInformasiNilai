<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mapel;
use App\Models\Kelas;
use App\Models\StatusNilai;
use App\Models\Nilai; // Tambahkan Model Nilai
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function admin(Request $request)
    {
        // 1. HITUNG KARTU STATISTIK
        $guruCount = User::where('role', 'guru')->count();
        $siswaCount = User::where('role', 'walimurid')->count();
        $mapelCount = Mapel::count();
        $kelasCount = Kelas::count();

        // 2. LOGIC FILTER KELAS
        $selectedKelasId = $request->input('kelas_id', 1);
        
        $statusNilai = StatusNilai::with(['mapel', 'guru'])
                        ->where('kelas_id', $selectedKelasId)
                        ->get();

        $daftarKelas = Kelas::all();

        return view('dashboard.admin', [
            'guruCount' => $guruCount,
            'siswaCount' => $siswaCount,
            'mapelCount' => $mapelCount,
            'kelasCount' => $kelasCount,
            'statusNilai' => $statusNilai,
            'daftarKelas' => $daftarKelas,
            'selectedKelasId' => $selectedKelasId
        ]);
    }

    public function guru(Request $request)
    {
        // 1. Cek Tahun Pelajaran (Dari Session atau Default Aktif)
        $tahunId = session('tahun_pengajar_id');
        
        // Jika session kosong, ambil tahun yang is_active = true di database
        if(!$tahunId) {
            $tahunAktif = \App\Models\TahunPelajaran::where('is_active', true)->first();
            // Jika database kosong (belum di-seed), hindari error
            if ($tahunAktif) {
                $tahunId = $tahunAktif->id;
                session(['tahun_pengajar_id' => $tahunId]);
            }
        }

        $selectedTahun = \App\Models\TahunPelajaran::find($tahunId);
        $listTahun = \App\Models\TahunPelajaran::all();

        // 2. Ambil Jadwal Mengajar Sesuai TAHUN yang dipilih
        $jadwalMengajar = collect(); // Default kosong
        
        if ($selectedTahun) {
            $jadwalMengajar = DB::table('guru_mapel')
                                ->join('mapels', 'guru_mapel.mapel_id', '=', 'mapels.id')
                                ->join('kelas', 'guru_mapel.kelas_id', '=', 'kelas.id')
                                ->where('guru_mapel.user_id', Auth::id()) // <--- UBAH DISINI (Gunakan Auth::id())
                                ->where('guru_mapel.tahun_pelajaran_id', $selectedTahun->id)
                                ->select('mapels.id as mapel_id', 'mapels.nama_mapel', 'kelas.id as kelas_id', 'kelas.nama_kelas')
                                ->get();
        }

        // Grouping: Mapel -> List Kelas
        $groupedJadwal = $jadwalMengajar->groupBy('nama_mapel');

        return view('dashboard.guru', compact('selectedTahun', 'listTahun', 'groupedJadwal'));
    }

    // Fungsi Ganti Tahun (Via Route)
    public function gantiTahun(Request $request)
    {
        session(['tahun_pengajar_id' => $request->tahun_id]);
        return back();
    }

    // --- PERBAIKAN DISINI ---
    public function walimurid()
    {
        $siswa = Auth::user();
        $siswa->load('kelas');

        // 1. Ambil Tahun Aktif
        $tahunAktif = \App\Models\TahunPelajaran::where('is_active', true)->first();

        // 2. Cek Status Rapor Kelas Ini di Tahun Ini
        $statusRapor = \App\Models\StatusRapor::where('kelas_id', $siswa->kelas_id)
                        ->where('tahun_pelajaran_id', $tahunAktif->id)
                        ->first();

        $isPublished = $statusRapor && $statusRapor->is_published;

        // 3. Ambil Nilai (HANYA JIKA SUDAH PUBLISHED)
        $nilais = collect(); // Default kosong

        if ($isPublished) {
            $nilais = Nilai::with('mapel')
                        ->where('siswa_id', $siswa->id)
                        ->where('tahun_pelajaran_id', $tahunAktif->id)
                        ->get();
        }

        return view('dashboard.walimurid', compact('siswa', 'nilais', 'isPublished'));
    }
    // Halaman Detail Profil Siswa (Untuk Wali Murid)
    public function profilSiswa()
    {
        $siswa = Auth::user();
        
        // Load data kelas dan wali kelasnya (guru)
        $siswa->load(['kelas.waliKelas']); 

        return view('dashboard.walimurid.profil', compact('siswa'));
    }
}