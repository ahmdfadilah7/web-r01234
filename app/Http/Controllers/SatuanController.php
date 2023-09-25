<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SatuanController extends Controller
{
    // Menampilkan halaman satuan
    public function index()
    {
        $setting = Setting::first();

        return view('satuan.index', compact('setting'));
    }

    // Menampilkan data satuan dengan datatables
    public function listData() 
    {
        $data = Satuan::query();
        $datatables = DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row) {
                $btn = '<a href="'.route('satuan.edit', $row->id).'" class="btn btn-primary btn-sm" style="margin-right: 10px;">
                            <i class="fa fa-edit"></i>
                        </a>';
                if ($row->level <> 'Superadmin') {
                    $btn .= '<a href="'.route('satuan.delete', $row->id).'" class="btn btn-danger btn-sm">
                            <i class="fa fa-trash"></i>
                        </a>';
                }
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);

        return $datatables;
    }

    // Menampilkan halaman tambah satuan
    public function create()
    {
        $setting = Setting::first();

        return view('satuan.add', compact('setting'));
    }

    // Proses menambahkan satuan
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_satuan' => 'required',
            'keterangan' => 'required',
        ],
        [
            'required' => ':attribute wajib diisi!!'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors)->withInput($request->all());
        }

        Satuan::create([
            'nama_satuan' => $request->get('nama_satuan'),
            'keterangan' => $request->get('keterangan')
        ]);

        return redirect()->route('satuan')->with('success', 'Berhasil menambahkan satuan.');
    }

    // Menampilkan halaman edit satuan
    public function edit($id)
    {
        $setting = Setting::first();
        $satuan = Satuan::find($id);

        return view('satuan.edit', compact('setting', 'satuan'));
    }

    // Proses mengedit satuan
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_satuan' => 'required',
            'keterangan' => 'required',
        ],
        [
            'required' => ':attribute wajib diisi!!'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors)->withInput($request->all());
        }

        $satuan = Satuan::find($id);
        $satuan->nama_satuan = $request->get('nama_satuan');
        $satuan->keterangan = $request->get('keterangan');
        $satuan->save();

        return redirect()->route('satuan')->with('success', 'Berhasil mengedit satuan.');
    }

    // Proses menghapus satuan
    public function destroy($id)
    {
        $satuan = Satuan::find($id);
        $satuan->delete();

        return redirect()->route('satuan')->with('success', 'Berhasil menghapus satuan.');
    }
}
