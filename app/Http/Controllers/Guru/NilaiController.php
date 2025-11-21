<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\StatusNilai;
use App\Models\TahunPelajaran; // Tambahkan import ini
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NilaiController extends Controller
{
    // Halaman Form Input Nilai
    public function create($kelas_id, $mapel_id)
    {
        $guru = Auth::user();

        // Cek apakah guru ini benar mengajar mapel ini? (Security Check)
        if(!$guru->mapels->contains($mapel_id)) {
            abort(403, 'Anda tidak mengampu mata pelajaran ini.');
        }

        $kelas = Kelas::findOrFail($kelas_id);
        $mapel = Mapel::findOrFail($mapel_id);

        // AMBIL TAHUN AKTIF (Penting agar nilai yang muncul cuma tahun ini)
        $tahunId = session('tahun_pengajar_id') ?? TahunPelajaran::where('is_active', true)->first()->id;

        // Ambil semua siswa di kelas ini
        // Dan ambil nilai mereka KHUSUS untuk tahun ini saja
        $siswas = User::where('role', 'walimurid')
                    ->where('kelas_id', $kelas_id)
                    ->with(['nilais' => function($q) use ($mapel_id, $tahunId) {
                        $q->where('mapel_id', $mapel_id)
                          ->where('tahun_pelajaran_id', $tahunId); // <-- PERBAIKAN DISINI
                    }])
                    ->get();

        return view('guru.nilai.input', compact('kelas', 'mapel', 'siswas'));
    }

    // Proses Simpan Nilai
    public function store(Request $request)
    {
        // Ambil tahun dari session (atau aktif default)
        $tahunId = session('tahun_pengajar_id') ?? TahunPelajaran::where('is_active', true)->first()->id;
        $guruId = Auth::id(); // Simpan ID guru ke variabel biar rapi

        foreach ($request->nilai as $siswa_id => $skor) {
            Nilai::updateOrCreate(
                [
                    'siswa_id' => $siswa_id,
                    'mapel_id' => $request->mapel_id,
                    'kelas_id' => $request->kelas_id,
                    'tahun_pelajaran_id' => $tahunId, 
                ],
                [
                    'guru_id' => $guruId,
                    'nilai' => $skor ?? 0
                ]
            );
        }

        // UPDATE STATUS PENGIRIMAN
        // PERBAIKAN: Gunakan $request->... karena $kelas_id tidak ada variabelnya
        StatusNilai::updateOrCreate(
            [
                'kelas_id' => $request->kelas_id, // <-- Perbaikan: pakai $request
                'mapel_id' => $request->mapel_id, // <-- Perbaikan: pakai $request
                // Opsional: Sebaiknya status nilai juga per tahun, tapi untuk sekarang begini cukup
            ],
            [
                'guru_id' => $guruId,
                'status' => 'terkirim'
            ]
        );

        return redirect()->route('dashboard.guru')->with('success', 'Nilai berhasil disimpan!');
    }

    // Menampilkan Daftar Kelas untuk Mapel tertentu (Action dari Sidebar)
    public function pilihKelas($mapel_id)
    {
        $guru = Auth::user();
        $mapel = Mapel::findOrFail($mapel_id);
        
        // 1. Ambil Tahun Ajaran (PENTING: Agar tidak muncul kelas tahun lalu)
        $tahunId = session('tahun_pengajar_id') ?? TahunPelajaran::where('is_active', true)->first()->id;

        // 2. Ambil Daftar Kelas REAL dari Database (Bukan range 1-6 lagi)
        // Kita cari di tabel guru_mapel, kelas mana saja yang diajar guru ini
        $kelasIds = DB::table('guru_mapel')
                    ->where('user_id', $guru->id)
                    ->where('mapel_id', $mapel_id)
                    ->where('tahun_pelajaran_id', $tahunId)
                    ->pluck('kelas_id'); // Hasilnya array ID: [1, 2] misal

        // Ambil Data Detail Kelasnya
        $kelasList = Kelas::whereIn('id', $kelasIds)->orderBy('nama_kelas')->get();

        return view('guru.mapel.pilih_kelas', compact('mapel', 'kelasList'));
    }
}