<?php

namespace App\Http\Controllers;

use App\Exports\PenjualanExport;
use App\Helpers\AllHelper;
use App\Models\Aksesoris;
use App\Models\Barang;
use App\Models\Penjualan;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Excel;
use Illuminate\Support\Facades\Auth;
use PDF;

class PenjualanController extends Controller
{
    // Menampilkan halaman penjualan
    public function index()
    {
        $setting = Setting::first();

        return view('penjualan.index', compact('setting'));
    }

    // Menampilkan data penjualan dengan datatables
    public function listData($id) 
    {

        if ($id == 'barang') {

            $data = Penjualan::join('barangs', 'penjualans.barang_id', 'barangs.id')
                ->select('penjualans.*', 'barangs.nama_barang');
            $datatables = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('harga', function($row) {
                    $harga = AllHelper::rupiah($row->harga);
                    return $harga;
                })
                ->addColumn('total', function($row) {
                    $total = AllHelper::rupiah($row->total);
                    return $total;
                })
                ->addColumn('created_at', function($row) {
                    $tgl = date('d M Y', strtotime($row->created_at));
                    return $tgl;
                })
                ->addColumn('action', function($row) {    
                    $btn = '<a href="'.route('penjualan.invoice', ['jenis' => 'barang', 'type' => 'stream', 'no_referensi' => $row->no_referensi]).'" class="btn btn-primary btn-sm mr-2" target="_blank">
                                <i class="fa fa-print"></i>
                            </a>';                
                    $btn .= '<a href="'.route('penjualan.delete', ['jenis' => 'barang', 'id' => $row->id]).'" class="btn btn-danger btn-sm">
                            <i class="fa fa-trash"></i>
                        </a>';
                    
                    return $btn;
                })
                ->rawColumns(['action', 'harga', 'total', 'created_at'])
                ->make(true);
        } else {
            
            $data = Penjualan::join('aksesoris', 'penjualans.aksesoris_id', 'aksesoris.id')
                ->select('penjualans.*', 'aksesoris.nama_aksesoris');
            $datatables = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('harga', function($row) {
                    $harga = AllHelper::rupiah($row->harga);
                    return $harga;
                })
                ->addColumn('total', function($row) {
                    $total = AllHelper::rupiah($row->total);
                    return $total;
                })
                ->addColumn('created_at', function($row) {
                    $tgl = date('d M Y', strtotime($row->created_at));
                    return $tgl;
                })
                ->addColumn('action', function($row) {
                    $btn = '<a href="'.route('penjualan.invoice', ['jenis' => 'aksesoris', 'type' => 'stream', 'no_referensi' => $row->no_referensi]).'" class="btn btn-primary btn-sm mr-2" target="_blank">
                                <i class="fa fa-print"></i>
                            </a>';
                    if (Auth::user()->level <> 'Operator') {
                        $btn .= '<a href="'.route('penjualan.delete', ['jenis' => 'aksesoris', 'id' => $row->id]).'" class="btn btn-danger btn-sm">
                                <i class="fa fa-trash"></i>
                            </a>';
                    } else {
                        $btn = '';
                    }
                    
                    return $btn;
                })
                ->rawColumns(['action', 'harga', 'total', 'created_at'])
                ->make(true);

        }

        return $datatables;
    }

    // Menampilkan halaman invoice
    public function invoice($jenis, $type, $no_referensi)
    {
        $setting = Setting::first();

        if ($jenis == 'barang') {
            $penjualan = Penjualan::join('barangs', 'penjualans.barang_id', 'barangs.id')
                ->where('no_referensi', $no_referensi);
        } else {
            $penjualan = Penjualan::join('aksesoris', 'penjualans.aksesoris_id', 'aksesoris.id')
                ->where('no_referensi', $no_referensi);
        }

        view()->share([
            'setting' => $setting, 
            'penjualan' => $penjualan->first()
        ]);
        $pdf = PDF::loadview('penjualan.invoice');

        if ($type == 'stream') {
            return $pdf->stream('Invoice-Penjualan-Barang-'.str_replace(' ', '-', $setting->nama_website).'-'.date('dMY').'-'.date('dMY').'.pdf');
        } else {
            return $pdf->download('Invoice-Penjualan-Barang-'.str_replace(' ', '-', $setting->nama_website).'-'.date('dMY').'-'.date('dMY').'.pdf');
        }
    }

    // Menampilkan halaman tambah penjualan barang
    public function create(Request $request)
    {
        $setting = Setting::first();

        $pembelian = Penjualan::selectRaw('MAX(RIGHT(no_referensi, 3)) as kode_max');

        if ($pembelian->count() > 0) {
            $urutan = (int) $pembelian->first()->kode_max;
            $urutan++;
            $no_referensi = 'TR'.date('ymd').sprintf('%03s', $urutan);
        } else {
            $no_referensi = 'TR'.date('ymd').'001';
        }

        if ($request->segment(2)=='barang') {
            $data = Barang::get();
        } else {
            $data = Aksesoris::get();
        }

        return view('penjualan.add', compact('setting', 'data', 'no_referensi'));
    }

    // Proses menambahkan penjualan
    public function store(Request $request)
    {
        if ($request->jenis=='barang') {

            $validator = Validator::make($request->all(), [
                'barang_id' => 'required',
                'nama_pembeli' => 'required',
                'harga' => 'required',
                'jumlah' => 'required'
            ]);
    
            if ($validator->fails()) {
                $errors = $validator->errors();
                return back()->with('errors', $errors)->with($request->all());
            }

            $barang = Barang::find($request->get('barang_id'));
            $totalstok = $barang->stok_barang - $request->get('jumlah');

            if($totalstok < 0) {
                return back()->with('warning', 'Stok Barang tidak mencukupi.')->withInput($request->all());
            }

            Penjualan::create([
                'no_referensi' => $request->get('no_referensi'),
                'barang_id' => $request->get('barang_id'),
                'nama_pembeli' => $request->get('nama_pembeli'),
                'harga' => $request->get('harga'),
                'jumlah' => $request->get('jumlah'),
                'total' => $request->get('jumlah') * $request->get('harga'),
            ]);
            
            $barang->stok_barang = $barang->stok_barang - $request->get('jumlah');
            $barang->save();

            return redirect()->route('penjualan.barang')->with('success', 'Berhasil menambahkan penjualan barang.');

        } else {
            
            $validator = Validator::make($request->all(), [
                'aksesoris_id' => 'required',
                'nama_pembeli' => 'required',
                'harga' => 'required',
                'jumlah' => 'required'
            ]);
    
            if ($validator->fails()) {
                $errors = $validator->errors();
                return back()->with('errors', $errors)->with($request->all());
            }

            $aksesoris = Aksesoris::find($request->get('aksesoris_id'));
            $totalstok = $aksesoris->stok_aksesoris - $request->get('jumlah');

            if ($totalstok < 0) {
                return back()->with('warning', 'Stok Aksesoris tidak mencukupi.')->withInput($request->all());
            }

            Penjualan::create([
                'no_referensi' => $request->get('no_referensi'),
                'aksesoris_id' => $request->get('aksesoris_id'),
                'nama_pembeli' => $request->get('nama_pembeli'),
                'harga' => $request->get('harga'),
                'jumlah' => $request->get('jumlah'),
                'total' => $request->get('jumlah') * $request->get('harga'),
            ]);
            
            $aksesoris->stok_aksesoris = $aksesoris->stok_aksesoris - $request->get('jumlah');
            $aksesoris->save();

            return redirect()->route('penjualan.aksesoris')->with('success', 'Berhasil menambahkan penjualan aksesoris.');

        }

    }

    // Proses export
    public function export(Request $request) 
    {    
        $validator = Validator::make($request->all(), [
            'dari' => 'required',
            'sampai' => 'required',
            'jenis' => 'required'
        ],
        [
            'required' => ':attribute wajib diisi!!'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors)->withInput($request->all());
        }

        $setting = Setting::first();

        if ($request->jenis == 'excel') {
            if ($request->kategori == 'barang') {
                return Excel::download(new PenjualanExport($request->get('dari'), $request->get('sampai'), $request->get('kategori')), 'Laporan-Penjualan-Barang-'.str_replace(' ', '-', $setting->nama_website).'-'.date('dMY', strtotime($request->get('dari'))).'-'.date('dMY', strtotime($request->get('sampai'))).'.xlsx');
            } else {
                return Excel::download(new PenjualanExport($request->get('dari'), $request->get('sampai'), $request->get('kategori')), 'Laporan-Penjualan-Aksesoris-'.str_replace(' ', '-', $setting->nama_website).'-'.date('dMY', strtotime($request->get('dari'))).'-'.date('dMY', strtotime($request->get('sampai'))).'.xlsx');
            }
        } else {
            if ($request->kategori == 'barang') {
                $penjualan = Penjualan::join('barangs', 'penjualans.barang_id', 'barangs.id')
                        ->whereDate('penjualans.created_at', '>=', date('Y-m-d', strtotime($request->get('dari'))))
                        ->whereDate('penjualans.created_at', '<=', date('Y-m-d', strtotime($request->get('sampai'))))
                        ->select('penjualans.*', 'barangs.nama_barang')
                        ->get();
            } else {
                $penjualan = Penjualan::join('aksesoris', 'penjualans.aksesoris_id', 'aksesoris.id')
                    ->whereDate('penjualans.created_at', '>=', date('Y-m-d', strtotime($request->get('dari'))))
                    ->whereDate('penjualans.created_at', '<=', date('Y-m-d', strtotime($request->get('sampai'))))
                    ->select('penjualans.*', 'aksesoris.nama_aksesoris')
                    ->get();
            }

            view()->share([
                'kategori' => $request->get('kategori'), 
                'penjualan' => $penjualan,
                'dari' => $request->get('dari'),
                'sampai' => $request->get('sampai')
            ]);
            $pdf = PDF::loadview('penjualan.pdf');

            if ($request->kategori == 'barang') {
                return $pdf->download('Laporan-Penjualan-Barang-'.str_replace(' ', '-', $setting->nama_website).'-'.date('dMY', strtotime($request->get('dari'))).'-'.date('dMY', strtotime($request->get('sampai'))).'.pdf');
            } else {
                return $pdf->download('Laporan-Penjualan-Aksesoris-'.str_replace(' ', '-', $setting->nama_website).'-'.date('dMY', strtotime($request->get('dari'))).'-'.date('dMY', strtotime($request->get('sampai'))).'.pdf');
            }
        }
    }

    // Proses menghapus penjualan
    public function destroy(Request $request)
    {
        $penjualan = Penjualan::find($request->id);
        $penjualan->delete();

        if ($request->jenis=='barang') {
            return redirect()->route('penjualan.barang')->with('success', 'Berhasil menghapus penjualan barang.');
        } else {
            return redirect()->route('penjualan.aksesoris')->with('success', 'Berhasil menghapus penjualan aksesoris.');
        }
    }
}
