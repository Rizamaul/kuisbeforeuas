<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KontrakSewa;
use App\Models\Penyewa;
use App\Models\Kamar;

class KontrakSewaController extends Controller
{

    public function index()
    {
    
        $kontrak = KontrakSewa::with(['penyewa', 'kamar'])->latest()->get();
        
        return view('kontrak.index', compact('kontrak'));
    }

    public function create()
    {
        $penyewas = Penyewa::all();
        
        $kamars = Kamar::where('status', 'tersedia')->get();
        
        return view('kontrak.create', compact('penyewa', 'kamar'));
    }

  
    public function store(Request $request)
    {
        $request->validate([
            'penyewa_id' => 'required|exists:penyewa,id',
            'kamar_id' => 'required|exists:kamar,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'harga_bulanan' => 'required|numeric|min:0',
        ]);

        $kontrak = KontrakSewa::create([
            'penyewa_id' => $request->penyewa_id,
            'kamar_id' => $request->kamar_id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'harga_bulanan' => $request->harga_bulanan,
            'status' => 'aktif'
        ]);

        $kamar = Kamar::findOrFail($request->kamar_id);
        $kamar->update(['status' => 'terisi']);

        return redirect()->route('kontrak-sewa.index')
            ->with('success', 'Kontrak berhasil dibuat & Status kamar diperbarui!');
    }

 
    public function show(string $id)
    {
        $kontrak = KontrakSewa::with(['penyewa', 'kamar', 'pembayaran'])->findOrFail($id);
        return view('kontrak.show', compact('kontrak'));
    }

    public function edit(string $id)
    {
        $kontrak = KontrakSewa::findOrFail($id);
        $penyewas = Penyewa::all();
    
        $kamars = Kamar::all(); 
        
        return view('kontrak.edit', compact('kontrak', 'penyewas', 'kamars'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'status' => 'required|in:aktif,selesai',
        ]);

        $kontrak = KontrakSewa::findOrFail($id);
        $kontrak->update($request->only(['tanggal_selesai', 'status', 'harga_bulanan']));

        if ($request->status == 'selesai') {
            $kamar = Kamar::find($kontrak->kamar_id);
            if ($kamar) {
                $kamar->update(['status' => 'tersedia']);
            }
        }

        return redirect()->route('kontrak-sewa.index')
            ->with('success', 'Data kontrak berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $kontrak = KontrakSewa::findOrFail($id);
        
        $kamarId = $kontrak->kamar_id;
        
        $kontrak->delete();

        $kamar = Kamar::find($kamarId);
        if ($kamar) {
            $kamar->update(['status' => 'tersedia']);
        }

        return redirect()->route('kontrak-sewa.index')
            ->with('success', 'Kontrak dihapus, Kamar sekarang tersedia.');
    }
}