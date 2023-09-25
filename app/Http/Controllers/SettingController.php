<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class SettingController extends Controller
{
    // Menampilkan halaman setting
    public function index() 
    {
        $setting = Setting::first();
        return view('setting.index', compact('setting'));
    }

    // Proses menampilkan data setting dengan datatables
    public function listData() 
    {
        $data = Setting::query();
        $datatables = DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('logo', function($row) {
                if ($row->logo <> '') {
                    $img = '<img src="'.url($row->logo).'" width="70">';
                } else {
                    $img = '';
                }
                return $img;
            })
            ->addColumn('favicon', function($row) {
                if ($row->favicon <> '') {
                    $img = '<img src="'.url($row->favicon).'" width="70">';
                } else {
                    $img = '';
                }
                return $img;
            })
            ->addColumn('action', function($row) {
                $btn = '<a href="'.route('setting.edit', $row->id).'" class="btn btn-primary btn-sm" style="margin-right: 10px;">
                            <i class="fa fa-edit"></i>
                        </a>';
                return $btn;
            })
            ->rawColumns(['action', 'logo', 'favicon'])
            ->make(true);

            return $datatables;
    }

    // Menampilkan halaman tambah setting
    public function create() 
    {
        return view('setting.add');
    }

    // Proses menambahkan setting
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_website' => 'required',
            'logo' => 'required|mimes:png,jpg,jpeg,svg',
            'favicon' => 'required|mimes:png,jpg,jpeg,svg',
        ],
        [
            'required' => ':attribute wajib diisi!!'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors)->withInput($request->all());
        }

        $logo = $request->file('logo');
        $namalogo = 'Logo-'.str_replace(' ', '-', $request->get('nama_website')).'-'.Str::random(4).'.'.$logo->extension();
        $tujuan = 'images';
        $logo->move(public_path($tujuan), $namalogo);
        $logoNama = $tujuan.'/'.$namalogo;

        $favicon = $request->file('favicon');
        $namafavicon = 'Favicon-'.str_replace(' ', '-', $request->get('nama_website')).'-'.Str::random(4).'.'.$favicon->extension();
        $favicon->move(public_path($tujuan), $namafavicon);
        $faviconNama = $tujuan.'/'.$namafavicon;

        Setting::create([
            'nama_website' => $request->get('nama_website'),
            'logo' => $logoNama,
            'favicon' => $faviconNama
        ]);

        return redirect()->route('setting')->with('success', 'Berhasil menambahkan setting.');
    }

    // Menampilkan halaman edit setting
    public function edit($id)
    {
        $setting = Setting::first();
        $settings = Setting::find($id);

        return view('setting.edit', compact('setting', 'settings'));
    }

    // Proses mengupdate setting
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_website' => 'required',
            'nama_toko' => 'required',
            'email' => 'required',
            'no_hp' => 'required',
            'alamat' => 'required',
            'logo' => 'mimes:png,jpg,jpeg,svg',
            'favicon' => 'mimes:png,jpg,jpeg,svg',
        ],
        [
            'required' => ':attribute wajib diisi!!'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors)->withInput($request->all());
        }

        $tujuan = 'images';
        if ($request->logo <> '') {
            $logo = $request->file('logo');
            $namalogo = 'Logo-'.str_replace(' ', '-', $request->get('nama_website')).'-'.Str::random(4).'.'.$logo->extension();
            $logo->move(public_path($tujuan), $namalogo);
            $logoNama = $tujuan.'/'.$namalogo;
        }

        if ($request->favicon <> '') {
            $favicon = $request->file('favicon');
            $namafavicon = 'Favicon-'.str_replace(' ', '-', $request->get('nama_website')).'-'.Str::random(4).'.'.$favicon->extension();
            $favicon->move(public_path($tujuan), $namafavicon);
            $faviconNama = $tujuan.'/'.$namafavicon;
        }

        $settings = Setting::find($id);
        $settings->nama_website = $request->get('nama_website');
        $settings->nama_toko = $request->get('nama_toko');
        $settings->email = $request->get('email');
        $settings->no_hp = $request->get('no_hp');
        $settings->alamat = $request->get('alamat');
        if ($request->logo <> '') {
            File::delete($settings->logo);

            $settings->logo = $logoNama;
        }
        if ($request->favicon <> '') {
            File::delete($settings->favicon);

            $settings->favicon = $faviconNama;
        }
        $settings->save();

        return redirect()->route('setting')->with('success', 'Berhasil mengupdate setting.');
    }
}
