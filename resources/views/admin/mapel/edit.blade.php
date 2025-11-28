@extends('layouts.dashboard')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800">Edit Mata Pelajaran</h1>
        <a href="{{ route('admin.mapel.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-bold transition">
            &larr; Kembali
        </a>
    </div>

    <div class="bg-white p-8 rounded-xl shadow-lg border-t-4 border-[#65825C]">
        
        <form action="{{ route('admin.mapel.update', $mapel->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT') {{-- WAJIB: Mengubah method POST menjadi PUT untuk Update --}}
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2 uppercase">Nama Mata Pelajaran</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-[#65825C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <input type="text" name="nama_mapel" 
                           value="{{ old('nama_mapel', $mapel->nama_mapel) }}" 
                           class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#65825C] focus:bg-white transition" 
                           required placeholder="Contoh: Matematika">
                </div>
                @error('nama_mapel')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Input KKM (Jika Diaktifkan) --}}
            {{-- 
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2 uppercase">KKM (Nilai Minimal)</label>
                <input type="number" name="kkm" value="{{ $mapel->kkm }}" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-500">
            </div> 
            --}}

            <div class="pt-4 flex gap-4">
                <button type="submit" class="w-full bg-[#65825C] hover:bg-[#546e4b] text-white font-bold py-3 rounded-lg shadow-md transition transform hover:-translate-y-0.5 flex justify-center items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>

    </div>

    <div class="bg-blue-50 border border-blue-100 p-4 rounded-lg flex items-start gap-3">
        <svg class="w-6 h-6 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <div>
            <h4 class="text-sm font-bold text-blue-800">Catatan:</h4>
            <p class="text-xs text-blue-600 mt-1">Mengubah nama mata pelajaran akan otomatis memperbarui tampilan di seluruh rapor dan jadwal guru yang terkait.</p>
        </div>
    </div>

</div>
@endsection     