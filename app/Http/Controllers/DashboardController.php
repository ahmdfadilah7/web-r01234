<?php

namespace App\Http\Controllers;

use App\Models\Aksesoris;
use App\Models\Barang;
use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\Penyewaan;
use App\Models\Setting;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Menampilkan halaman dashboard
    public function index() 
    {
        $setting = Setting::first();
        $barang_count = Barang::count();
        $aksesoris_count = Aksesoris::count();
        $pembelian_count = Pembelian::count();
        $penjualan_count = Penjualan::count();
        $penyewaan_count = Penyewaan::count();

        return view('dashboard.index', compact('setting', 'barang_count', 'aksesoris_count', 'pembelian_count', 'penjualan_count', 'penyewaan_count'));
    }
}
