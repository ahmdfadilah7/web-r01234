<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class KategoriController extends Controller
{
    // Menampilkan halaman kategori
    public function index()
    {
        $setting = Setting::first();

        return view('kategori.index', compact('setting'));
    }

    // Menampilkan data kategori dengan datatables
    public function listData() 
    {
        $data = Kategori::query();
        $datatables = DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row) {
                $btn = '<a href="'.route('kategori.edit', $row->id).'" class="btn btn-primary btn-sm" style="margin-right: 10px;">
                            <i class="fa fa-edit"></i>
                        </a>';
                if ($row->level <> 'Superadmin') {
                    $btn .= '<a href="'.route('kategori.delete', $row->id).'" class="btn btn-danger btn-sm">
                            <i class="fa fa-trash"></i>
                        </a>';
                }
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);

            return $datatables;
    }

    // Menampilkan halaman tambah Kategori
    public function create() 
    {
        $setting = Setting::first();

        return view('kategori.add', compact('setting'));
    }

    // Proses menambahkan kategori
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required'
        ],
        [
            'required' => ':attribute wajib diisi!!'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors)->withInput($request->all());
        }

        Kategori::create([
            'nama_kategori' => $request->get('nama_kategori')
        ]);

        return redirect()->route('kategori')->with('success', 'Berhasil menambahkan kategori.');
    }

    // Menampilkan halaman edit kategori
    public function edit($id)
    {
        $setting = Setting::first();
        $kategori = Kategori::find($id);

        return view('kategori.edit', compact('setting', 'kategori'));
    }

    // Proses mengedit kategori
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required'
        ],
        [
            'required' => ':attribute wajib diisi!!'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors)->withInput($request->all());
        }

        $kategori = Kategori::find($id);
        $kategori->nama_kategori = $request->get('nama_kategori');
        $kategori->save();

        return redirect()->route('kategori')->with('success', 'Berhasil mengedit kategori.');
    }

    // Proses menghapus kategori
    public function destroy($id)
    {
        $kategori = Kategori::find($id);
        $kategori->delete();

        return redirect()->route('kategori')->with('success', 'Berhasil menghapus kategori.');
    }
}
