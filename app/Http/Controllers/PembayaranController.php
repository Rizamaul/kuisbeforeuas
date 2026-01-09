<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\KontrakSewa;

class PembayaranController extends Controller
{
   
    public function index()
    {
        
        $pembayarans = Pembayaran::with(['kontrakSewa.penyewa', 'kontrakSewa.kamar'])
                        ->latest()
                        ->get();
                        
        return view('pembayaran.index', compact('pembayarans'));
    }

    
 
    public function create()
    {

        $kontraks = KontrakSewa::with(['penyewa', 'kamar'])
                    ->where('status', 'aktif')
                    ->get();
                    
        return view('pembayaran.create', compact('kontraks'));
    }

   
    public function store(Request $request)
    {
       
        $request->validate([
            'kontrak_sewa_id' => 'required|exists:kontrak_sewa,id', 
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2020|max:2030',
            'tanggal_bayar' => 'required|date',
            'jumlah_bayar' => 'required|numeric|min:0',
            'status' => 'required|in:lunas,tertunggak',
            'keterangan' => 'nullable|string'
        ]);

        
        Pembayaran::create($request->all());

        return redirect()->route('pembayaran.index')
            ->with('success', 'Pembayaran berhasil dicatat!');
    }

  
    public function show(string $id)
    {
        $pembayaran = Pembayaran::with(['kontrakSewa.penyewa', 'kontrakSewa.kamar'])->findOrFail($id);
        return view('pembayaran.show', compact('pembayaran'));
    }


    public function edit(string $id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        
        $kontraks = KontrakSewa::with(['penyewa', 'kamar'])->get();
        
        return view('pembayaran.edit', compact('pembayaran', 'kontraks'));
    }

   
    public function update(Request $request, string $id)
    {
        $request->validate([
            'kontrak_sewa_id' => 'required|exists:kontrak_sewa,id',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer',
            'tanggal_bayar' => 'required|date',
            'jumlah_bayar' => 'required|numeric|min:0',
            'status' => 'required|in:lunas,tertunggak',
            'keterangan' => 'nullable|string'
        ]);

        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->update($request->all());

        return redirect()->route('pembayaran.index')
            ->with('success', 'Data pembayaran berhasil diperbarui!');
    }


    public function destroy(string $id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->delete();

        return redirect()->route('pembayaran.index')
            ->with('success', 'Data pembayaran berhasil dihapus!');
    }
}