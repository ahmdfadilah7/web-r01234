<?php

namespace App\Http\Controllers;

use App\Helpers\AllHelper;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Satuan;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class BarangController extends Controller
{
    // Menampilkan halaman barang
    public function index() 
    {
        $setting = Setting::first();

        return view('barang.index', compact('setting'));
    }

    // Menampilkan data barang dengan datatables
    public function listData() 
    {
        $data = Barang::query();
        $datatables = DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('gambar_barang', function($row) {
                if ($row->gambar_barang <> '') {
                    $img = '<img src="'.url($row->gambar_barang).'" width="70">';
                } else {
                    $img = '';
                }
                return $img;
            })
            ->addColumn('harga_barang', function($row) {
                $hrg = AllHelper::rupiah($row->harga_barang);
                return $hrg;
            })
            ->addColumn('stok_barang', function($row) {
                if ($row->stok_barang == NULL) {
                    $stok = 0;
                } else {
                    $stok = $row->stok_barang;
                }
                return $stok;
            })
            ->addColumn('action', function($row) {
                $btn = '<a href="'.route('barang.edit', $row->id).'" class="btn btn-primary btn-sm" style="margin-right: 10px;">
                            <i class="fa fa-edit"></i>
                        </a>';
                if ($row->level <> 'Superadmin') {
                    $btn .= '<a href="'.route('barang.delete', $row->id).'" class="btn btn-danger btn-sm">
                            <i class="fa fa-trash"></i>
                        </a>';
                }
                return $btn;
            })
            ->rawColumns(['action', 'gambar_barang', 'harga_barang', 'stok_barang'])
            ->make(true);

        return $datatables;
    }

    // Mengambil data barang
    public function getBarang($id)
    {
        $barang = Barang::find($id);

        return json_encode($barang);
    }

    // Menampilkan halaman tambah barang
    public function create()
    {
        $setting = Setting::first();
        $kategori = Kategori::get();
        $satuan = Satuan::get();

        $barang = Barang::selectRaw('MAX(RIGHT(kode_barang, 3)) as kode_max');

        if ($barang->count() > 0) {
            $urutan = (int) $barang->first()->kode_max;
            $urutan++;
            $kode_barang = 'BR'.sprintf('%03s', $urutan);
        } else {
            $kode_barang = 'BR001';
        }
        
        return view('barang.add', compact('setting', 'kategori', 'satuan', 'kode_barang'));
    }

    // Proses menambahkan barang
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required',
            'merk_barang' => 'required',
            'kode_barang' => 'required',
            'kategori_id' => 'required',
            'satuan_id' => 'required',
            'gambar_barang' => 'required|mimes:jpg,jpeg,png,svg,webp',
            'harga_barang' => 'required',
            'deskripsi_barang' => 'required'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors)->withInput($request->all());
        }

        $gambar = $request->file('gambar_barang');
        $namagambar = 'Barang-'.str_replace(' ', '-', $request->get('nama_barang')).'-'.Str::random(4).'.'.$gambar->extension();
        $tujuan = 'images';
        $gambar->move(public_path($tujuan), $namagambar);
        $gambarNama = $tujuan.'/'.$namagambar;

        Barang::create([
            'nama_barang' => $request->get('nama_barang'),
            'merk_barang' => $request->get('merk_barang'),
            'kode_barang' => $request->get('kode_barang'),
            'kategori_id' => $request->get('kategori_id'),
            'satuan_id' => $request->get('satuan_id'),
            'gambar_barang' => $gambarNama,
            'harga_barang' => $request->get('harga_barang'),
            'deskripsi_barang' => $request->get('deskripsi_barang')
        ]);

        return redirect()->route('barang')->with('success', 'Berhasil menambahkan barang.');
    }

    // Menampilkan halaman edit barang
    public function edit($id)
    {
        $setting = Setting::first();
        $kategori = Kategori::get();
        $satuan = Satuan::get();
        $barang = Barang::find($id);

        return view('barang.edit', compact('setting', 'kategori', 'satuan', 'barang'));
    }

    // Proses update barang
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required',
            'merk_barang' => 'required',
            'kategori_id' => 'required',
            'satuan_id' => 'required',
            'gambar_barang' => 'mimes:jpg,jpeg,png,svg,webp',
            'harga_barang' => 'required',
            'deskripsi_barang' => 'required'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors)->withInput($request->all());
        }

        if ($request->gambar_barang <> '') {
            $gambar = $request->file('gambar_barang');
            $namagambar = 'Barang-'.str_replace(' ', '-', $request->get('nama_barang')).'-'.Str::random(4).'.'.$gambar->extension();
            $tujuan = 'images';
            $gambar->move(public_path($tujuan), $namagambar);
            $gambarNama = $tujuan.'/'.$namagambar;
        }

        $barang = Barang::find($id);
        $barang->nama_barang = $request->get('nama_barang');
        $barang->merk_barang = $request->get('merk_barang');
        $barang->kategori_id = $request->get('kategori_id');
        $barang->satuan_id = $request->get('satuan_id');
        $barang->harga_barang = $request->get('harga_barang');
        $barang->deskripsi_barang = $request->get('deskripsi_barang');
        if ($request->gambar_barang <> '') {
            File::delete($barang->gambar_barang);

            $barang->gambar_barang = $gambarNama;
        }
        $barang->save();

        return redirect()->route('barang')->with('success', 'Berhasil mengupdate barang.');
    }

    // Proses menghapus barang
    public function destroy($id)
    {
        $barang = Barang::find($id);
        $barang->delete();

        File::delete($barang->gambar_barang);

        return redirect()->route('barang')->with('success', 'Berhasil menghapus barang.');
    }
}
