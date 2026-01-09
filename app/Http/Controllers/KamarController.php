<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kamar; 

class KamarController extends Controller
{
   
    public function index(Request $request)
    {
      
        $query = Kamar::query();

        if ($request->has('tipe') && $request->tipe != '') {
            $query->where('tipe', $request->tipe);
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $kamars = $query->latest()->get();

        return view('kamar.index', compact('kamars'));
    }

   
    public function create()
    {
        return view('kamar.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_kamar' => 'required|unique:kamar,nomor_kamar|max:10',
            'tipe' => 'required|in:standard,deluxe,vip',
            'harga_bulanan' => 'required|numeric|min:0',
            'fasilitas' => 'required|string',
            'status' => 'required|in:tersedia,terisi',
        ]);

        Kamar::create($request->all());

        return redirect()->route('kamar.index')
            ->with('success', 'Kamar berhasil ditambahkan!');
    }

   
    public function edit(string $id)
    {
        $kamar = Kamar::findOrFail($id);
        return view('kamar.edit', compact('kamar'));
    }

    
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nomor_kamar' => 'required|max:10|unique:kamar,nomor_kamar,' . $id,
            'tipe' => 'required|in:standard,deluxe,vip',
            'harga_bulanan' => 'required|numeric|min:0',
            'fasilitas' => 'required|string',
            'status' => 'required|in:tersedia,terisi',
        ]);

        $kamar = Kamar::findOrFail($id);
        $kamar->update($request->all());

        return redirect()->route('kamar.index')
            ->with('success', 'Data Kamar berhasil diperbarui!');
    }


    public function destroy(string $id)
    {
        $kamar = Kamar::findOrFail($id);

      
        if ($kamar->kontrakSewa()->count() > 0) {
            return redirect()->route('kamar.index')
                ->with('error', 'Gagal hapus! Kamar ini sedang disewa.');
        }

        $kamar->delete();

        return redirect()->route('kamar.index')
            ->with('success', 'Kamar berhasil dihapus!');
    }
}