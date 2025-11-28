<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TahunPelajaran; // Pastikan Model di-import

class TahunPelajaranController extends Controller
{
    // 1. TAMPILKAN HALAMAN
    public function index()
    {
        // Urutkan dari tahun terbaru
        $tahuns = TahunPelajaran::orderBy('tahun', 'desc')->orderBy('semester', 'desc')->get();
        return view('admin.tahun.index', compact('tahuns'));
    }

    // 2. SIMPAN TAHUN BARU
    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required|string',
            'semester' => 'required|in:Ganjil,Genap',
        ]);

        // Cek apakah ini data pertama? Jika iya, langsung set aktif
        $cekData = TahunPelajaran::count();
        $isActive = ($cekData == 0) ? true : false;

        TahunPelajaran::create([
            'tahun' => $request->tahun,
            'semester' => $request->semester,
            'is_active' => $isActive
        ]);

        return back()->with('success', 'Tahun pelajaran baru berhasil ditambahkan.');
    }

    // 3. UPDATE (AKTIFKAN TAHUN) - INI YANG TADI ERROR
    public function update(Request $request, $id)
    {
        $tahun = TahunPelajaran::findOrFail($id);

        // Jika tombol "Aktifkan" ditekan
        if ($request->has('set_active')) {
            
            // A. Matikan (Set 0) semua tahun pelajaran lain dulu
            TahunPelajaran::query()->update(['is_active' => false]);

            // B. Aktifkan (Set 1) tahun yang dipilih ini
            $tahun->update(['is_active' => true]);

            return back()->with('success', "Tahun Pelajaran {$tahun->tahun} ({$tahun->semester}) sekarang AKTIF!");
        }

        // Jika update biasa (edit nama/semester - opsional jika ada fitur edit)
        $tahun->update($request->all());
        
        return back()->with('success', 'Data berhasil diperbarui.');
    }

    // 4. HAPUS TAHUN
    public function destroy($id)
    {
        $tahun = TahunPelajaran::findOrFail($id);
        
        // Jangan biarkan menghapus tahun yang sedang aktif
        if ($tahun->is_active) {
            return back()->with('error', 'Tidak bisa menghapus Tahun Ajaran yang sedang AKTIF. Pindahkan status aktif ke tahun lain dulu.');
        }

        $tahun->delete();
        return back()->with('success', 'Tahun pelajaran berhasil dihapus.');
    }
}