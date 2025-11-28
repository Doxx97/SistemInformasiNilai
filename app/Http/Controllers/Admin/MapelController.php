<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Mapel;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    public function index()
    {
        $mapels = Mapel::all();
        return view('admin.mapel.index', compact('mapels'));
    }

    public function store(Request $request)
    {
        $request->validate(['nama_mapel' => 'required|string|max:255']);
        Mapel::create($request->all());
        return back()->with('success', 'Mata Pelajaran berhasil ditambahkan');
    }

    public function destroy(Mapel $mapel)
    {
        $mapel->delete();
        return back()->with('success', 'Mata Pelajaran dihapus');
    }

    // ... method index dan store yang sudah ada ...

    // 1. MENAMPILKAN HALAMAN EDIT
    public function edit($id)
    {
        $mapel = \App\Models\Mapel::findOrFail($id);
        return view('admin.mapel.edit', compact('mapel'));
    }

    // 2. PROSES UPDATE DATA
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_mapel' => 'required|string|max:255',
        ]);

        $mapel = \App\Models\Mapel::findOrFail($id);
        
        $mapel->update([
            'nama_mapel' => $request->nama_mapel,
            // 'kkm' => $request->kkm, // Uncomment jika pakai KKM
        ]);

        return redirect()->route('admin.mapel.index')->with('success', 'Mata Pelajaran berhasil diperbarui!');
    }
}