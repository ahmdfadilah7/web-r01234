<?php

namespace App\Http\Controllers;

use App\Exports\PenyewaanExport;
use App\Helpers\AllHelper;
use App\Models\Barang;
use App\Models\Penyewaan;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Excel;
use Illuminate\Support\Facades\Auth;
use PDF;

class PenyewaanController extends Controller
{
    // Menampilkan halaman penyewaan
    public function index()
    {
        $setting = Setting::first();

        return view('penyewaan.index', compact('setting'));
    }

    // Menampilkan data penyewaan dengan datatables
    public function listData() 
    {
        $data = Penyewaan::join('barangs', 'penyewaans.barang_id', 'barangs.id')
            ->select('penyewaans.*', 'barangs.nama_barang');
        $datatables = DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('total', function($row) {
                $hrg = AllHelper::rupiah($row->total);
                return $hrg;
            })
            ->addColumn('dari', function($row) {
                $dari = date('d M Y', strtotime($row->dari));
                return $dari;
            })
            ->addColumn('sampai', function($row) {
                $sampai = date('d M Y', strtotime($row->sampai));
                return $sampai;
            })
            ->addColumn('status', function($row) {
                if ($row->status == '0') {
                    $hrg = '<span class="badge badge-pill badge-warning">Belum diambil</span>';
                } elseif ($row->status == '1') {
                    $hrg = '<span class="badge badge-pill badge-primary">Sudah diambil</span>';
                } elseif ($row->status == '2') {
                    $hrg = '<span class="badge badge-pill badge-success">Selesai</span>';
                } elseif ($row->status == '3') {
                    $hrg = '<span class="badge badge-pill badge-danger">Dibatalkan</span>';
                }
                return $hrg;
            })
            ->addColumn('action', function($row) {
                if ($row->status == '0') {
                    $btn = '<a href="'.route('penyewaan.diambil', $row->id).'" class="btn btn-primary btn-sm" style="margin-bottom: 10px;" title="Sudah Diambil">
                            <i class="fa fa-check"></i>
                        </a>';
                    $btn .= '<a href="'.route('penyewaan.dibatalkan', $row->id).'" class="btn btn-danger btn-sm" style="margin-bottom: 10px;" title="Dibatalkan">
                            <i class="fa fa-close"></i>
                        </a>';
                } elseif ($row->status == '1') {
                    $btn = '<a href="'.route('penyewaan.selesai', $row->id).'" class="btn btn-success btn-sm" style="margin-bottom: 10px;" title="Selesai">
                            <i class="fa fa-check"></i>
                        </a>';
                } elseif ($row->status == '2') {
                    $btn = '<a href="'.route('penyewaan.invoice', ['type' => 'stream', 'no_referensi' => $row->no_referensi]).'" class="btn btn-primary btn-sm mr-2" target="_blank">
                                <i class="fa fa-print"></i>
                            </a>';
                } else {
                    $btn = '';
                }
                if (Auth::user()->level <> 'Operator') {
                    $btn .= '<a href="'.route('penyewaan.delete', $row->id).'" class="btn btn-danger btn-sm">
                            <i class="fa fa-trash"></i>
                        </a>';
                }
                return $btn;
            })
            ->rawColumns(['action', 'total', 'status', 'dari', 'sampai'])
            ->make(true);

        return $datatables;
    }

    public function diambil($id)
    {
        $penyewaan = Penyewaan::find($id);
        $penyewaan->status = '1';
        $penyewaan->save();

        return redirect()->route('penyewaan')->with('success', 'Berhasil mengkonfirmasi sudah diambail.');
    }

    public function selesai($id)
    {
        $penyewaan = Penyewaan::find($id);
        $penyewaan->status = '2';
        $penyewaan->save();

        return redirect()->route('penyewaan')->with('success', 'Berhasil mengkonfirmasi selesai.');
    }

    public function dibatalkan($id)
    {
        $penyewaan = Penyewaan::find($id);
        $penyewaan->status = '3';
        $penyewaan->save();

        return redirect()->route('penyewaan')->with('success', 'Berhasil mengkonfirmasi dibatalkan.');
    }

    // Menampilkan halaman invoice
    public function invoice($type, $no_referensi)
    {
        $setting = Setting::first();

        $penyewaan = Penyewaan::join('barangs', 'penyewaans.barang_id', 'barangs.id')
            ->where('no_referensi', $no_referensi);
        

        view()->share([
            'setting' => $setting, 
            'penyewaan' => $penyewaan->first()
        ]);
        $pdf = PDF::loadview('penyewaan.invoice');

        if ($type == 'stream') {
            return $pdf->stream('Invoice-Penyewaan-Barang-'.str_replace(' ', '-', $setting->nama_website).'-'.date('dMY').'-'.date('dMY').'.pdf');
        } else {
            return $pdf->download('Invoice-Penyewaan-Barang-'.str_replace(' ', '-', $setting->nama_website).'-'.date('dMY').'-'.date('dMY').'.pdf');
        }
    }

    // Menampilkan halaman penyewaan
    public function create()
    {
        $setting = Setting::first();
        
        $penyewaan = Penyewaan::selectRaw('MAX(RIGHT(no_referensi, 3)) as kode_max');

        if ($penyewaan->count() > 0) {
            $urutan = (int) $penyewaan->first()->kode_max;
            $urutan++;
            $no_referensi = 'SW'.date('ymd').sprintf('%03s', $urutan);
        } else {
            $no_referensi = 'SW'.date('ymd').'001';
        }

        $barang = Barang::get();

        return view('penyewaan.add', compact('setting', 'no_referensi', 'barang'));
    }

    // Proses menambahkan penyewaan
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_penyewa' => 'required',
            'no_telp' => 'required',
            'barang_id' => 'required',
            'jumlah' => 'required',
            'dari' => 'required',
            'sampai' => 'required',
            'total' => 'required',
        ],
        [
            'required' => ':attribute wajib diisi!!'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors)->withInput($request->all());
        }

        Penyewaan::create([
            'no_referensi' => $request->get('no_referensi'),
            'nama_penyewa' => $request->get('nama_penyewa'),
            'no_telp' => $request->get('no_telp'),
            'barang_id' => $request->get('barang_id'),
            'jumlah' => $request->get('jumlah'),
            'dari' => $request->get('dari'),
            'sampai' => $request->get('sampai'),
            'total' => $request->get('total')
        ]);

        return redirect()->route('penyewaan')->with('success', 'Berhasil menambahkan penyewaan.');
    }

    // Proses export
    public function export(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dari' => 'required',
            'status' => 'required',
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
            return Excel::download(new PenyewaanExport($request->get('dari'), $request->get('status')), 'Laporan-Penyewaan-Barang-'.str_replace(' ', '-', $setting->nama_website).'-'.date('dMY', strtotime($request->get('dari'))).'.xlsx');
        } else {
            $penyewaan = Penyewaan::join('barangs', 'penyewaans.barang_id', 'barangs.id')
                ->whereDate('penyewaans.dari', '=', $request->get('dari'))
                ->where('penyewaans.status', '=', $request->get('status'))
                ->select('penyewaans.*', 'barangs.nama_barang')
                ->get();
            
            if ($request->status == '0') {
                $status = 'Belum Diambil';
            } elseif ($request->status == '1') {
                $status = 'Sudah Diambil';
            } elseif ($request->status == '2') {
                $status = 'Selesai';
            } elseif ($request->status == '3') {
                $status = 'Dibatalkan';
            }

            view()->share([
                'penyewaan' => $penyewaan,
                'dari' => $request->get('dari'),
                'status' => $status
            ]);
            $pdf = PDF::loadview('penyewaan.pdf');

            return $pdf->download('Laporan-Penyewaan-Barang-'.str_replace(' ', '-', $setting->nama_website).'-'.date('dMY', strtotime($request->get('dari'))).'.pdf');            
        }
    }

    // Proses menghapus penyewaan
    public function destroy(Request $request)
    {
        $penyewaan = Penyewaan::find($request->id);
        $penyewaan->delete();

        return redirect()->route('penyewaan')->with('success', 'Berhasil menghapus penyewaan barang.');
    }
}
