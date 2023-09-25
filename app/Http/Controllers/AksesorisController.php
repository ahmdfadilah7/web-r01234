<?php

namespace App\Http\Controllers;

use App\Helpers\AllHelper;
use App\Models\Aksesoris;
use App\Models\Kategori;
use App\Models\Satuan;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class AksesorisController extends Controller
{
    // Menampilkan halaman aksesoris
    public function index()
    {
        $setting = Setting::first();

        return view('aksesoris.index', compact('setting'));
    }

    // Menampilkan data aksesoris dengan datatables
    public function listData() 
    {
        $data = Aksesoris::query();
        $datatables = DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('gambar_aksesoris', function($row) {
                if ($row->gambar_aksesoris <> '') {
                    $img = '<img src="'.url($row->gambar_aksesoris).'" width="70">';
                } else {
                    $img = '';
                }
                return $img;
            })
            ->addColumn('harga_aksesoris', function($row) {
                $hrg = AllHelper::rupiah($row->harga_aksesoris);
                return $hrg;
            })
            ->addColumn('action', function($row) {
                $btn = '<a href="'.route('aksesoris.edit', $row->id).'" class="btn btn-primary btn-sm" style="margin-right: 10px;">
                            <i class="fa fa-edit"></i>
                        </a>';
                if ($row->level <> 'Superadmin') {
                    $btn .= '<a href="'.route('aksesoris.delete', $row->id).'" class="btn btn-danger btn-sm">
                            <i class="fa fa-trash"></i>
                        </a>';
                }
                return $btn;
            })
            ->rawColumns(['action', 'gambar_aksesoris', 'harga_aksesoris'])
            ->make(true);

        return $datatables;
    }

    // Mengambil data aksesoris
    public function getAksesoris($id)
    {
        $aksesoris = Aksesoris::find($id);

        return json_encode($aksesoris);
    }

    // Menampilkan halaman tambah aksesoris
    public function create()
    {
        $setting = Setting::first();
        $kategori = Kategori::get();
        $satuan = Satuan::get();

        $aksesoris = Aksesoris::selectRaw('MAX(RIGHT(kode_aksesoris, 3)) as kode_max');

        if ($aksesoris->count() > 0) {
            $urutan = (int) $aksesoris->first()->kode_max;
            $urutan++;
            $kode_aksesoris = 'AKS'.sprintf('%03s', $urutan);
        } else {
            $kode_aksesoris = 'AKS001';
        }

        return view('aksesoris.add', compact('setting', 'kategori', 'satuan', 'kode_aksesoris'));
    }

    // Proses menambahkan aksesoris
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_aksesoris' => 'required',
            'nama_aksesoris' => 'required',
            'merk_aksesoris' => 'required',
            'kategori_id' => 'required',
            'satuan_id' => 'required',
            'gambar_aksesoris' => 'required|mimes:png,jpg,jpeg,svg,webp',
            'harga_aksesoris' => 'required',
            'deskripsi_aksesoris' => 'required'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors)->withInput($request->all());
        }

        $gambar = $request->file('gambar_aksesoris');
        $namagambar = 'Aksesoris-'.str_replace(' ', '-', $request->get('nama_aksesoris')).'-'.Str::random(4).'.'.$gambar->extension();
        $tujuan = 'images';
        $gambar->move(public_path($tujuan), $namagambar);
        $gambarNama = $tujuan.'/'.$namagambar;

        Aksesoris::create([
            'kode_aksesoris' => $request->get('kode_aksesoris'),
            'nama_aksesoris' => $request->get('nama_aksesoris'),
            'merk_aksesoris' => $request->get('merk_aksesoris'),
            'kategori_id' => $request->get('kategori_id'),
            'satuan_id' => $request->get('satuan_id'),
            'gambar_aksesoris' => $gambarNama,
            'harga_aksesoris' => $request->get('harga_aksesoris'),
            'deskripsi_aksesoris' => $request->get('deskripsi_aksesoris')
        ]);

        return redirect()->route('aksesoris')->with('success', 'Berhasil menambahkan aksesoris.');
    }

    // Menampilkan halaman edit aksesoris
    public function edit($id)
    {
        $setting = Setting::first();
        $kategori = Kategori::get();
        $satuan = Satuan::get();
        $aksesoris = Aksesoris::find($id);

        return view('aksesoris.edit', compact('setting', 'kategori', 'satuan', 'aksesoris'));
    }

    // Proses mengupdate aksesoris
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_aksesoris' => 'required',
            'merk_aksesoris' => 'required',
            'kategori_id' => 'required',
            'satuan_id' => 'required',
            'gambar_aksesoris' => 'mimes:png,jpg,jpeg,svg,webp',
            'harga_aksesoris' => 'required',
            'deskripsi_aksesoris' => 'required'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors)->withInput($request->all());
        }

        if ($request->gamba_aksesoris <> '') {
            $gambar = $request->file('gambar_aksesoris');
            $namagambar = 'Aksesoris-'.str_replace(' ', '-', $request->get('nama_aksesoris')).'-'.Str::random(4).'.'.$gambar->extension();
            $tujuan = 'images';
            $gambar->move(public_path($tujuan), $namagambar);
            $gambarNama = $tujuan.'/'.$namagambar;
        }

        $aksesoris = Aksesoris::find($id);
        $aksesoris->nama_aksesoris = $request->get('nama_aksesoris');
        $aksesoris->merk_aksesoris = $request->get('merk_aksesoris');
        $aksesoris->kategori_id = $request->get('kategori_id');
        $aksesoris->satuan_id = $request->get('satuan_id');
        $aksesoris->harga_aksesoris = $request->get('harga_aksesoris');
        $aksesoris->deskripsi_aksesoris = $request->get('deskripsi_aksesoris');
        if ($request->gambar_aksesoris <> '') {
            File::delete($aksesoris->gambar_aksesoris);

            $aksesoris->gambar_aksesoris = $gambarNama;
        }
        $aksesoris->save();

        return redirect()->route('aksesoris')->with('success', 'Berhasil mengupdate aksesoris.');
    }

    // Proses menghapus aksesoris
    public function destroy($id)
    {
        $aksesoris = Aksesoris::find($id);
        $aksesoris->delete();

        File::delete($aksesoris->gambar_aksesoris);

        return redirect()->route('aksesoris')->with('success', 'Berhasil menghapus aksesoris.');
    }

}
