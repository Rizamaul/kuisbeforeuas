<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;


use App\Models\Kamar;
use App\Models\Penyewa;
use App\Models\KontrakSewa;
use App\Models\Pembayaran;

class DashboardController extends Controller
{
    public function index()
    {
     
        $totalKamar = Kamar::count();

    
        $kamarTersedia = Kamar::where('status', 'tersedia')->count();
        $kamarTerisi = Kamar::where('status', 'terisi')->count();

       
        $pendapatanBulanIni = Pembayaran::whereMonth('tanggal_bayar', now()->month)
            ->whereYear('tanggal_bayar', now()->year)
            ->where('status', 'lunas') 
            ->sum('jumlah_bayar');

    
        $pembayaranTertunggak = Pembayaran::where('status', 'tertunggak')->count();

       
        $grafikPendapatan = [];
        for ($i = 1; $i <= 12; $i++) {
            $grafikPendapatan[] = Pembayaran::whereMonth('tanggal_bayar', $i)
                ->whereYear('tanggal_bayar', now()->year)
                ->where('status', 'lunas')
                ->sum('jumlah_bayar');
        }

        return view('dashboard.index', compact(
            'totalKamar',
            'kamarTersedia',
            'kamarTerisi',
            'pendapatanBulanIni',
            'pembayaranTertunggak',
            'grafikPendapatan'
        ));
    }
}