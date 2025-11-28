<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Mapel;
use App\Models\TahunPelajaran;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage; // Penting untuk upload foto

class GuruController extends Controller
{
    public function index()
    {
        // Ambil data guru beserta relasi
        $gurus = User::where('role', 'guru')->with(['mapels', 'kelasPerwalian'])->get();
        $mapels = Mapel::all();
        $kelasList = Kelas::all();
        
        return view('admin.guru.index', compact('gurus', 'mapels', 'kelasList'));
    }

    public function store(Request $request)
    {
        // 1. VALIDASI
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username', // NIP
            'password' => 'required|min:6',
            'assign_mapel' => 'nullable|array',
            'wali_kelas_id' => 'nullable',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048' // Validasi Foto
        ], [
            'username.unique' => 'NIP sudah terdaftar!',
            'foto.max' => 'Ukuran foto maksimal 2MB'
        ]);

        // 2. CEK TAHUN AKTIF
        $tahunAktif = TahunPelajaran::where('is_active', true)->first();
        if (!$tahunAktif) {
            return back()->with('error', 'GAGAL: Belum ada Tahun Pelajaran Aktif.');
        }

        // 3. UPLOAD FOTO (JIKA ADA)
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('profil', 'public');
        }

        // 4. BUAT USER GURU
        $guru = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password), // Password manual
            'role' => 'guru',
            'nip' => $request->username,
            'foto' => $fotoPath // Simpan path foto
        ]);

        // 5. SIMPAN JADWAL MENGAJAR (ASSIGN MAPEL)
        if($request->has('assign_mapel')){
            foreach($request->assign_mapel as $item) {
                $parts = explode('-', $item);
                if(count($parts) == 2) {
                    DB::table('guru_mapel')->insert([
                        'user_id' => $guru->id,
                        'mapel_id' => $parts[0],
                        'kelas_id' => $parts[1],
                        'tahun_pelajaran_id' => $tahunAktif->id,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
        }
        
        // 6. SIMPAN WALI KELAS
        if($request->wali_kelas_id) {
            // Reset kelas lama agar tidak double wali kelasnya
            Kelas::where('id', $request->wali_kelas_id)->update(['wali_kelas_id' => null]);
            // Set guru ini jadi wali kelas
            Kelas::where('id', $request->wali_kelas_id)->update(['wali_kelas_id' => $guru->id]);
        }

        return back()->with('success', 'Guru berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $guru = User::with(['mapels', 'kelasPerwalian'])->findOrFail($id);
        $mapels = Mapel::all();
        $kelasList = Kelas::all();
        
        // Ambil data jadwal guru ini di tahun aktif (untuk mengisi checkbox di view edit)
        $tahunAktif = TahunPelajaran::where('is_active', true)->first();
        
        $assigned = [];
        if($tahunAktif) {
            $data = DB::table('guru_mapel')
                    ->where('user_id', $id)
                    ->where('tahun_pelajaran_id', $tahunAktif->id)
                    ->get();
            
            foreach($data as $d) {
                // Format: mapelID-kelasID
                $assigned[] = $d->mapel_id . '-' . $d->kelas_id;
            }
        }

        return view('admin.guru.edit', compact('guru', 'mapels', 'kelasList', 'assigned'));
    }

    public function update(Request $request, $id)
    {
        $guru = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username,'.$id,
            'assign_mapel' => 'nullable|array',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // 1. Update Data Dasar
        $dataUpdate = [
            'name' => $request->name,
            'username' => $request->username,
            'nip' => $request->username
        ];

        // 2. Update Password (Jika Diisi)
        if($request->filled('password')) {
            $dataUpdate['password'] = Hash::make($request->password);
        }

        // 3. Update Foto (Hapus lama, upload baru)
        if ($request->hasFile('foto')) {
            if ($guru->foto) {
                Storage::disk('public')->delete($guru->foto);
            }
            $dataUpdate['foto'] = $request->file('foto')->store('profil', 'public');
        }

        $guru->update($dataUpdate);

        // 4. Update Jadwal (Mapel & Kelas)
        $tahunAktif = TahunPelajaran::where('is_active', true)->first();
        
        if($tahunAktif) {
            // Hapus jadwal lama di tahun ini
            DB::table('guru_mapel')
                ->where('user_id', $guru->id)
                ->where('tahun_pelajaran_id', $tahunAktif->id)
                ->delete();

            // Insert jadwal baru
            if($request->has('assign_mapel')){
                foreach($request->assign_mapel as $item) {
                    $parts = explode('-', $item);
                    if(count($parts) == 2) {
                        DB::table('guru_mapel')->insert([
                            'user_id' => $guru->id,
                            'mapel_id' => $parts[0],
                            'kelas_id' => $parts[1],
                            'tahun_pelajaran_id' => $tahunAktif->id,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    }
                }
            }
        }

        // 5. Update Wali Kelas
        // Lepaskan jabatan wali kelas lama dari guru ini
        Kelas::where('wali_kelas_id', $guru->id)->update(['wali_kelas_id' => null]);
        
        // Set kelas baru (jika dipilih)
        if($request->wali_kelas_id) {
            Kelas::where('id', $request->wali_kelas_id)->update(['wali_kelas_id' => null]); // Reset target kelas
            Kelas::where('id', $request->wali_kelas_id)->update(['wali_kelas_id' => $guru->id]);
        }

        return redirect()->route('admin.guru.index')->with('success', 'Data Guru berhasil diperbarui');
    }

    public function destroy($id)
    {
        $guru = User::find($id);
        
        // Hapus foto dari storage jika ada
        if ($guru->foto) {
            Storage::disk('public')->delete($guru->foto);
        }

        $guru->delete();
        return back()->with('success', 'Guru berhasil dihapus');
    }
}