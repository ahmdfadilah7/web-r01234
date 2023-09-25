<?php

namespace App\Exports;

use App\Models\Pembelian;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PembelianExport implements FromView, ShouldAutoSize
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
            $pembelian = Pembelian::join('barangs', 'pembelians.barang_id', 'barangs.id')
                        ->whereDate('pembelians.created_at', '>=', $dari)
                        ->whereDate('pembelians.created_at', '<=', $sampai)
                    ->select('pembelians.*', 'barangs.nama_barang')
                    ->get();
        } else {
            $pembelian = Pembelian::join('aksesoris', 'pembelians.aksesoris_id', 'aksesoris.id')
                        ->whereDate('pembelians.created_at', '>=', $dari)
                        ->whereDate('pembelians.created_at', '<=', $sampai)
                    ->select('pembelians.*', 'aksesoris.nama_aksesoris')
                    ->get();
        }
        return view('pembelian.excel', compact('pembelian', 'kategori', 'dari', 'sampai'));
    }
}
