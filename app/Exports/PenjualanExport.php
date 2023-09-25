<?php

namespace App\Exports;

use App\Models\Penjualan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PenjualanExport implements FromView, ShouldAutoSize
{
    use Exportable;

    private $daritgl;
    private $sampaitgl;
    private $kategoris;

    public function __construct($dari, $sampai, $kategori) {
        $this->daritgl = $dari;
        $this->sampaitgl = $sampai;
        $this->kategoris = $kategori;
    }
     

    public function view(): View
    {
        $dari = date('Y-m-d', strtotime($this->daritgl));
        $sampai = date('Y-m-d', strtotime($this->sampaitgl));
        $kategori = $this->kategoris;
        if ($this->kategoris == 'barang') {
            $penjualan = Penjualan::join('barangs', 'penjualans.barang_id', 'barangs.id')
                        ->whereDate('penjualans.created_at', '>=', $dari)
                        ->whereDate('penjualans.created_at', '<=', $sampai)
                    ->select('penjualans.*', 'barangs.nama_barang')
                    ->get();
        } else {
            $penjualan = Penjualan::join('aksesoris', 'penjualans.aksesoris_id', 'aksesoris.id')
                        ->whereDate('penjualans.created_at', '>=', $dari)
                        ->whereDate('penjualans.created_at', '<=', $sampai)
                    ->select('penjualans.*', 'aksesoris.nama_aksesoris')
                    ->get();
        }
        return view('penjualan.excel', compact('penjualan', 'kategori', 'dari', 'sampai'));
    }
}
