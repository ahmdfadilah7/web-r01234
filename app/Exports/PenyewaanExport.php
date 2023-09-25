<?php

namespace App\Exports;

use App\Models\Penyewaan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PenyewaanExport implements FromView, ShouldAutoSize
{
    use Exportable;

    private $daritgl;
    private $status;

    public function __construct($dari, $status) {
        $this->daritgl = $dari;
        $this->status = $status;
    }
     

    public function view(): View
    {
        $dari = date('Y-m-d', strtotime($this->daritgl));
        
        $penyewaan = Penyewaan::join('barangs', 'penyewaans.barang_id', 'barangs.id')
                ->whereDate('penyewaans.dari', '=', $dari)
                ->where('penyewaans.status', '=', $this->status)
                ->select('penyewaans.*', 'barangs.nama_barang')
                ->get();

        return view('penyewaan.excel', compact('penyewaan', 'dari'));
    }
}
