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
}