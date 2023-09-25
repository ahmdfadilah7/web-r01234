<?php

namespace App\Http\Controllers;

use App\Exports\PembelianExport;
use App\Helpers\AllHelper;
use App\Models\Aksesoris;
use App\Models\Barang;
use App\Models\Pembelian;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Excel;
use Illuminate\Support\Facades\Auth;
use PDF;

class PembelianController extends Controller
{
    // Menampilkan halaman pembelian
    public function index()
    {
        $setting = Setting::first();

        return view('pembelian.index', compact('setting'));
    }

    // Menampilkan data pembelian dengan datatables
    public function listData($id) 
    {

        if ($id == 'barang') {

            $data = Pembelian::join('barangs', 'pembelians.barang_id', 'barangs.id')
                ->select('pembelians.*', 'barangs.nama_barang');
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
                    $btn = '<a href="'.route('pembelian.invoice', ['jenis' => 'barang', 'type' => 'stream', 'no_referensi' => $row->no_referensi]).'" class="btn btn-primary btn-sm mr-2" target="_blank">
                                <i class="fa fa-print"></i>
                            </a>';           
                    $btn .= '<a href="'.route('pembelian.delete', ['jenis' => 'barang', 'id' => $row->id]).'" class="btn btn-danger btn-sm">
                            <i class="fa fa-trash"></i>
                        </a>';
                    
                    return $btn;
                })
                ->rawColumns(['action', 'harga', 'total', 'created_at'])
                ->make(true);
        } else {
            
            $data = Pembelian::join('aksesoris', 'pembelians.aksesoris_id', 'aksesoris.id')
                ->select('pembelians.*', 'aksesoris.nama_aksesoris');
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
                    $btn = '<a href="'.route('pembelian.invoice', ['jenis' => 'aksesoris', 'type' => 'stream', 'no_referensi' => $row->no_referensi]).'" class="btn btn-primary btn-sm mr-2" target="_blank">
                                <i class="fa fa-print"></i>
                            </a>';
                    if (Auth::user()->level <> 'Operator') {
                        $btn .= '<a href="'.route('pembelian.delete', ['jenis' => 'aksesoris', 'id' => $row->id]).'" class="btn btn-danger btn-sm">
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
            $pembelian = Pembelian::join('barangs', 'pembelians.barang_id', 'barangs.id')
                ->where('no_referensi', $no_referensi);
        } else {
            $pembelian = Pembelian::join('aksesoris', 'pembelians.aksesoris_id', 'aksesoris.id')
                ->where('no_referensi', $no_referensi);
        }

        view()->share([
            'setting' => $setting, 
            'pembelian' => $pembelian->first()
        ]);
        $pdf = PDF::loadview('pembelian.invoice');

        if ($jenis == 'barang') {
            if ($type == 'stream') {
                return $pdf->stream('Invoice-Pembelian-Barang-'.str_replace(' ', '-', $setting->nama_website).'-'.date('dMY').'-'.date('dMY').'.pdf');
            } else {
                return $pdf->download('Invoice-Pembelian-Barang-'.str_replace(' ', '-', $setting->nama_website).'-'.date('dMY').'-'.date('dMY').'.pdf');
            }
        } else {
            if ($type == 'stream') {
                return $pdf->stream('Invoice-Pembelian-Aksesoris-'.str_replace(' ', '-', $setting->nama_website).'-'.date('dMY').'-'.date('dMY').'.pdf');
            } else {
                return $pdf->download('Invoice-Pembelian-Aksesoris-'.str_replace(' ', '-', $setting->nama_website).'-'.date('dMY').'-'.date('dMY').'.pdf');
            }
        }        
    }

    // Menampilkan halaman tambah pembelian barang
    public function create(Request $request)
    {
        $setting = Setting::first();

        $pembelian = Pembelian::selectRaw('MAX(RIGHT(no_referensi, 3)) as kode_max');

        if ($pembelian->count() > 0) {
            $urutan = (int) $pembelian->first()->kode_max;
            $urutan++;
            $no_referensi = 'INV'.date('ymd').sprintf('%03s', $urutan);
        } else {
            $no_referensi = 'INV'.date('ymd').'001';
        }

        if ($request->segment(2)=='barang') {
            $data = Barang::get();
        } else {
            $data = Aksesoris::get();
        }

        return view('pembelian.add', compact('setting', 'data', 'no_referensi'));
    }

    // Proses menambahkan pembelian
    public function store(Request $request)
    {
        if ($request->jenis=='barang') {

            $validator = Validator::make($request->all(), [
                'barang_id' => 'required',
                'nama_supplier' => 'required',
                'harga' => 'required',
                'jumlah' => 'required'
            ]);
    
            if ($validator->fails()) {
                $errors = $validator->errors();
                return back()->with('errors', $errors)->with($request->all());
            }

            Pembelian::create([
                'no_referensi' => $request->get('no_referensi'),
                'barang_id' => $request->get('barang_id'),
                'nama_supplier' => $request->get('nama_supplier'),
                'harga' => $request->get('harga'),
                'jumlah' => $request->get('jumlah'),
                'total' => $request->get('jumlah') * $request->get('harga'),
            ]);

            $barang = Barang::find($request->get('barang_id'));
            $barang->stok_barang = $barang->stok_barang + $request->get('jumlah');
            $barang->save();

            return redirect()->route('pembelian.barang')->with('success', 'Berhasil menambahkan pembelian barang.');

        } else {
            
            $validator = Validator::make($request->all(), [
                'aksesoris_id' => 'required',
                'nama_supplier' => 'required',
                'harga' => 'required',
                'jumlah' => 'required'
            ]);
    
            if ($validator->fails()) {
                $errors = $validator->errors();
                return back()->with('errors', $errors)->with($request->all());
            }

            Pembelian::create([
                'no_referensi' => $request->get('no_referensi'),
                'aksesoris_id' => $request->get('aksesoris_id'),
                'nama_supplier' => $request->get('nama_supplier'),
                'harga' => $request->get('harga'),
                'jumlah' => $request->get('jumlah'),
                'total' => $request->get('jumlah') * $request->get('harga'),
            ]);

            $aksesoris = Aksesoris::find($request->get('aksesoris_id'));
            $aksesoris->stok_aksesoris = $aksesoris->stok_aksesoris + $request->get('jumlah');
            $aksesoris->save();

            return redirect()->route('pembelian.aksesoris')->with('success', 'Berhasil menambahkan pembelian aksesoris.');

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
                return Excel::download(new PembelianExport($request->get('dari'), $request->get('sampai'), $request->get('kategori')), 'Laporan-Pembelian-Barang-'.str_replace(' ', '-', $setting->nama_website).'-'.date('dMY', strtotime($request->get('dari'))).'-'.date('dMY', strtotime($request->get('sampai'))).'.xlsx');
            } else {
                return Excel::download(new PembelianExport($request->get('dari'), $request->get('sampai'), $request->get('kategori')), 'Laporan-Pembelian-Aksesoris-'.str_replace(' ', '-', $setting->nama_website).'-'.date('dMY', strtotime($request->get('dari'))).'-'.date('dMY', strtotime($request->get('sampai'))).'.xlsx');
            }
        } else {
            if ($request->kategori == 'barang') {
                $pembelian = Pembelian::join('barangs', 'pembelians.barang_id', 'barangs.id')
                        ->whereDate('pembelians.created_at', '>=', date('Y-m-d', strtotime($request->get('dari'))))
                        ->whereDate('pembelians.created_at', '<=', date('Y-m-d', strtotime($request->get('sampai'))))
                        ->select('pembelians.*', 'barangs.nama_barang')
                        ->get();
            } else {
                $pembelian = Pembelian::join('aksesoris', 'pembelians.aksesoris_id', 'aksesoris.id')
                    ->whereDate('pembelians.created_at', '>=', date('Y-m-d', strtotime($request->get('dari'))))
                    ->whereDate('pembelians.created_at', '<=', date('Y-m-d', strtotime($request->get('sampai'))))
                    ->select('pembelians.*', 'aksesoris.nama_aksesoris')
                    ->get();
            }

            view()->share([
                'kategori' => $request->get('kategori'), 
                'pembelian' => $pembelian,
                'dari' => $request->get('dari'),
                'sampai' => $request->get('sampai')
            ]);
            $pdf = PDF::loadview('pembelian.pdf');

            if ($request->kategori == 'barang') {
                return $pdf->download('Laporan-Pembelian-Barang-'.str_replace(' ', '-', $setting->nama_website).'-'.date('dMY', strtotime($request->get('dari'))).'-'.date('dMY', strtotime($request->get('sampai'))).'.pdf');
            } else {
                return $pdf->download('Laporan-Pembelian-Aksesoris-'.str_replace(' ', '-', $setting->nama_website).'-'.date('dMY', strtotime($request->get('dari'))).'-'.date('dMY', strtotime($request->get('sampai'))).'.pdf');
            }
        }
    }

    // Proses menghapus pembelian
    public function destroy(Request $request)
    {
        $pembelian = Pembelian::find($request->id);
        $pembelian->delete();

        if ($request->jenis=='barang') {
            return redirect()->route('pembelian.barang')->with('success', 'Berhasil menghapus pembelian barang.');
        } else {
            return redirect()->route('pembelian.aksesoris')->with('success', 'Berhasil menghapus pembelian aksesoris.');
        }
    }
}
