<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage; // Penting

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        // Filter per kelas jika ada request
        $kelasId = $request->get('kelas_id');
        
        $siswas = User::where('role', 'walimurid')
                    ->when($kelasId, function($q) use ($kelasId){
                        return $q->where('kelas_id', $kelasId);
                    })
                    ->with('kelas')
                    ->orderBy('kelas_id')
                    ->get();
        
        $kelasList = Kelas::all();
        return view('admin.siswa.index', compact('siswas', 'kelasList', 'kelasId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|numeric|unique:users,username', // NISN
            'kelas_id' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ], [
            'username.unique' => 'NISN sudah terdaftar!'
        ]);

        // Upload Foto
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('profil', 'public');
        }

        // Buat Akun Siswa
        User::create([
            'name' => $request->name,
            'username' => $request->username, // NISN
            'password' => Hash::make($request->username), // Password awal = NISN
            'role' => 'walimurid',
            'kelas_id' => $request->kelas_id,
            'tahun_masuk' => date('Y'), // Otomatis tahun sekarang
            'foto' => $fotoPath
        ]);

        return back()->with('success', 'Siswa berhasil ditambahkan');
    }

    public function edit($id)
    {
        $siswa = User::findOrFail($id);
        $kelasList = Kelas::all();
        return view('admin.siswa.edit', compact('siswa', 'kelasList'));
    }

    public function update(Request $request, $id)
    {
        $siswa = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'username' => 'required|numeric|unique:users,username,'.$id,
            'kelas_id' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $dataUpdate = [
            'name' => $request->name,
            'username' => $request->username,
            'kelas_id' => $request->kelas_id,
        ];

        // Update Password (Jika diisi)
        if($request->filled('password')) {
            $dataUpdate['password'] = Hash::make($request->password);
        }

        // Update Foto
        if ($request->hasFile('foto')) {
            if ($siswa->foto) {
                Storage::disk('public')->delete($siswa->foto);
            }
            $dataUpdate['foto'] = $request->file('foto')->store('profil', 'public');
        }

        $siswa->update($dataUpdate);

        return redirect()->route('admin.siswa.index')->with('success', 'Data Siswa berhasil diperbarui');
    }
    
    public function destroy($id)
    {
        $siswa = User::find($id);
        
        if ($siswa->foto) {
            Storage::disk('public')->delete($siswa->foto);
        }

        $siswa->delete();
        return back()->with('success', 'Siswa dihapus');
    }
}