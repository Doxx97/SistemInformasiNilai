<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TahunPelajaran;
use Illuminate\Http\Request;

class TahunPelajaranController extends Controller
{
    public function index()
    {
        // Urutkan dari yang terbaru
        $tahuns = TahunPelajaran::orderBy('tahun', 'desc')->orderBy('semester', 'desc')->get();
        return view('admin.tahun.index', compact('tahuns'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required',
            'semester' => 'required'
        ]);

        // --- PERBAIKAN DISINI ---
        // Kita harus mendefinisikan 'is_active' secara manual menjadi 0 (False)
        TahunPelajaran::create([
            'tahun' => $request->tahun,
            'semester' => $request->semester,
            'is_active' => 0 // 0 artinya Tidak Aktif (False)
        ]);
        // ------------------------

        return back()->with('success', 'Tahun Pelajaran berhasil ditambahkan');
    }

    public function setActive($id)
    {
        // 1. Matikan semua tahun
        TahunPelajaran::query()->update(['is_active' => false]);
        
        // 2. Aktifkan yang dipilih
        $tahun = TahunPelajaran::findOrFail($id);
        $tahun->update(['is_active' => true]);

        return back()->with('success', 'Tahun Pelajaran ' . $tahun->tahun . ' (' . $tahun->semester . ') berhasil DIAKTIFKAN!');
    }

    public function destroy($id)
    {
        // Cegah hapus tahun yang sedang aktif
        $tahun = TahunPelajaran::findOrFail($id);
        if($tahun->is_active) {
            return back()->with('error', 'Tidak bisa menghapus tahun yang sedang AKTIF!');
        }
        
        $tahun->delete();
        return back()->with('success', 'Tahun Pelajaran dihapus.');
    }
}