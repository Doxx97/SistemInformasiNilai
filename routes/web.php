<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\MapelController;
use App\Http\Controllers\Admin\TahunPelajaranController;
use App\Http\Controllers\Guru\NilaiController;
use App\Http\Controllers\Guru\WaliKelasController;
use App\Http\Middleware\RoleMiddleware; 
use App\Http\Controllers\Guru\AbsensiController;

// 1. Route untuk Login/Logout
Route::get('/', [AuthController::class, 'landing'])->name('landing');
Route::get('/login-redirect', function () { return redirect()->route('landing'); })->name('login');
Route::get('/login/{role}', [AuthController::class, 'loginForm'])->name('login.form');
Route::post('/login/{role}', [AuthController::class, 'authenticate'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 2. Group Route Khusus ADMIN
Route::middleware(['auth', RoleMiddleware::class.':admin'])->group(function () {
    
    // Dashboard Admin
    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');

    // Group CRUD (Prefix: admin, Name: admin.)
    Route::name('admin.')->prefix('admin')->group(function() {
        Route::resource('guru', GuruController::class);
        Route::resource('siswa', SiswaController::class);
        Route::resource('mapel', MapelController::class);
        
        // Route Tahun Pelajaran (DIMASUKKAN KE SINI AGAR KENA NAME admin.)
        Route::resource('tahun', TahunPelajaranController::class);
        Route::post('tahun/active/{id}', [TahunPelajaranController::class, 'setActive'])->name('tahun.active');
    });
});

// 3. Group Route Khusus GURU
Route::middleware(['auth', RoleMiddleware::class.':guru'])->group(function () {

    // Dashboard
    Route::get('/dashboard/guru', [DashboardController::class, 'guru'])->name('dashboard.guru');
    
    // Pilih Kelas & Input Nilai
    Route::get('/guru/mapel/{mapel_id}', [NilaiController::class, 'pilihKelas'])->name('guru.pilih.kelas');
    Route::get('/guru/nilai/{kelas_id}/{mapel_id}', [NilaiController::class, 'create'])->name('guru.nilai.create');
    Route::post('/guru/nilai/simpan', [NilaiController::class, 'store'])->name('guru.nilai.store');
    
    // Ganti Tahun
    Route::post('/guru/ganti-tahun', [DashboardController::class, 'gantiTahun'])->name('guru.ganti.tahun');

    // Route Wali Kelas
    Route::get('/guru/walikelas/rekap', [WaliKelasController::class, 'rekap'])->name('guru.walikelas.rekap');
    Route::get('/guru/walikelas/rapor/{siswa_id}', [WaliKelasController::class, 'cetakRapor'])->name('guru.walikelas.rapor');

    // Route Publikasi Rapor
    Route::post('/guru/walikelas/publish', [WaliKelasController::class, 'publish'])->name('guru.walikelas.publish');
    Route::post('/guru/walikelas/unpublish', [WaliKelasController::class, 'unpublish'])->name('guru.walikelas.unpublish');

    // Catatan Wali Kelas
    Route::get('/guru/walikelas/catatan/{siswa_id}', [WaliKelasController::class, 'formCatatan'])->name('guru.walikelas.catatan');
    Route::post('/guru/walikelas/catatan/{siswa_id}', [WaliKelasController::class, 'simpanCatatan'])->name('guru.walikelas.update_catatan');

    // Halaman Menu Kenaikan Kelas
    Route::get('/guru/walikelas/kenaikan', [App\Http\Controllers\Guru\WaliKelasController::class, 'indexKenaikan'])->name('guru.walikelas.kenaikan');

// Proses Simpan Status (Hanya teks untuk Rapor)
    Route::post('/guru/walikelas/kenaikan/update', [App\Http\Controllers\Guru\WaliKelasController::class, 'updateStatusKenaikan'])->name('guru.walikelas.update_status');

// Proses PINDAH KELAS (Naik Kelas Fisik)
    Route::post('/guru/walikelas/kenaikan/proses', [App\Http\Controllers\Guru\WaliKelasController::class, 'prosesNaikKelas'])->name('guru.walikelas.proses_naik');
    Route::get('/guru/absensi/input/{kelas_id}/{mapel_id}', [AbsensiController::class, 'create'])->name('guru.absensi.create');
    Route::post('/guru/absensi/simpan', [AbsensiController::class, 'store'])->name('guru.absensi.store');
});

// 4. Group Route Khusus WALI MURID
Route::middleware(['auth', RoleMiddleware::class.':walimurid'])->group(function () {
    Route::get('/dashboard/walimurid', [DashboardController::class, 'walimurid'])->name('dashboard.walimurid');
    Route::get('/dashboard/walimurid/profil', [DashboardController::class, 'profilSiswa'])->name('walimurid.profil');
});

//dd
Route::get('/cek-foto', function() {
    $user = \Illuminate\Support\Facades\Auth::user();
    return [
        'Nama' => $user->name,
        'Isi Kolom Foto di DB' => $user->foto,
        'Link Asset' => asset('storage/' . $user->foto),
        'Apakah File Ada di Public?' => file_exists(public_path('storage/' . $user->foto)) ? 'YA ADA' : 'TIDAK ADA',
    ];
}); 