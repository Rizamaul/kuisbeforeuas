<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penyewa;

class PenyewaController extends Controller
{
  
    public function index()
    {
        $penyewas = Penyewa::latest()->get();
        return view('penyewa.index', compact('penyewas'));
    }

    public function create()
    {
        return view('penyewa.create');
    }

  
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'nomor_telepon' => 'required|string|max:15',
            'nomor_ktp' => 'required|string|max:20|unique:penyewa,nomor_ktp',
            'alamat_asal' => 'required|string',
            'pekerjaan' => 'required|string|max:50',
        ]);

        Penyewa::create($request->all());

        return redirect()->route('penyewa.index')
            ->with('success', 'Data Penyewa berhasil ditambahkan!');
    }

   
    public function edit(string $id)
    {
        $penyewa = Penyewa::findOrFail($id);
        return view('penyewa.edit', compact('penyewa'));
    }

  
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'nomor_telepon' => 'required|string|max:15',
            'nomor_ktp' => 'required|string|max:20|unique:penyewa,nomor_ktp,'.$id, 
            'alamat_asal' => 'required|string',
            'pekerjaan' => 'required|string|max:50',
        ]);

        $penyewa = Penyewa::findOrFail($id);
        $penyewa->update($request->all());

        return redirect()->route('penyewa.index')
            ->with('success', 'Data Penyewa berhasil diperbarui!');
    }

 
    public function destroy(string $id)
    {
        $penyewa = Penyewa::findOrFail($id);
        
        if ($penyewa->kontrakSewa()->count() > 0) {
            return redirect()->route('penyewa.index')
                ->with('error', 'Gagal hapus! Penyewa ini masih punya kontrak aktif.');
        }

        $penyewa->delete();

        return redirect()->route('penyewa.index')
            ->with('success', 'Data Penyewa berhasil dihapus!');
    }
}