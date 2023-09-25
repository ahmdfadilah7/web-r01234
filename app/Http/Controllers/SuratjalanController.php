<?php

namespace App\Http\Controllers;

use App\Helpers\AllHelper;
use App\Models\Barang;
use App\Models\ProdukSuratjalan;
use App\Models\Setting;
use App\Models\Suratjalan;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SuratjalanController extends Controller
{
    // Menampilkan halaman suratjalan
    public function index()
    {
        $setting = Setting::first();

        return view('suratjalan.index', compact('setting'));
    }

    // Menampilkan data suratjalan dengan datatables
    public function listData() 
    {
        $data = Suratjalan::query();
        $datatables = DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row) {
                $btn = '<a href="'.route('suratjalan.invoice', ['type' => 'stream', 'no_referensi' => $row->no_surat]).'" class="btn btn-primary btn-sm mr-2" target="_blank">
                            <i class="fa fa-print"></i>
                        </a>';
                if (Auth::user()->level <> 'Operator') {
                    $btn .= '<a href="'.route('suratjalan.delete', $row->id).'" class="btn btn-danger btn-sm">
                            <i class="fa fa-trash"></i>
                        </a>';
                }
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);

        return $datatables;
    }

    // Menampilkan halaman tambah suratjalan
    public function create()
    {
        $setting = Setting::first();
        $barang = Barang::get();

        return view('suratjalan.add', compact('setting', 'barang'));
    }

    // Proses menambahkan suratjalan
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_po' => 'required',
            'no_surat' => 'required',
            'tanggal_po' => 'required',
            'tanggal' => 'required',
            'no_mobil' => 'required',
            'barang_id.*' => 'required',
            'jumlah.*' => 'required',
            'harga.*' => 'required',
        ],
        [
            'required' => ':attribute wajib diisi!!'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors)->withInput($request->all());
        }

        $suratjalan = new Suratjalan;
        $suratjalan->no_po = $request->get('no_po');
        $suratjalan->no_surat = $request->get('no_surat');
        $suratjalan->tanggal_po = $request->get('tanggal_po');
        $suratjalan->tanggal = $request->get('tanggal');
        $suratjalan->no_mobil = $request->get('no_mobil');
        $suratjalan->save();
        $suratjalan_id = $suratjalan->id;        
        
        for ($i=0; $i < count($request->get('barang_id')); $i++) { 
            ProdukSuratjalan::create([
                'suratjalan_id' => $suratjalan_id,
                'barang_id' => $request->get('barang_id')[$i],
                'harga' => $request->get('harga')[$i],
                'jumlah' => $request->get('jumlah')[$i],
                'total' => $request->get('jumlah')[$i] * $request->get('harga')[$i]
            ]);
        }

        return redirect()->route('suratjalan')->with('success', 'Berhasil menambahkan Surat Jalan.');

    }

    // Menampilkan halaman invoice
    public function invoice($type, $no_surat)
    {
        $setting = Setting::first();

        $suratjalan = Suratjalan::where('no_surat', $no_surat)->first();
        $produk = ProdukSuratjalan::join('barangs', 'produk_suratjalans.barang_id', 'barangs.id')->where('suratjalan_id', $suratjalan->id)->get();

        view()->share([
            'setting' => $setting, 
            'suratjalan' => $suratjalan,
            'produk' => $produk
        ]);
        $pdf = PDF::loadview('suratjalan.invoice');

        if ($type == 'stream') {
            return $pdf->stream('SuratJalan-'.str_replace(' ', '-', $setting->nama_website).'-'.date('dMY').'-'.date('dMY').'.pdf');
        } else {
            return $pdf->download('SuratJalan-'.str_replace(' ', '-', $setting->nama_website).'-'.date('dMY').'-'.date('dMY').'.pdf');
        }
    }

    // Proses menghapus suratjalan
    public function destroy(Request $request)
    {
        $suratjalan = Suratjalan::find($request->id);
        $suratjalan->delete();

        return redirect()->route('suratjalan')->with('success', 'Berhasil menghapus Surat Jalan.');
    }
}
