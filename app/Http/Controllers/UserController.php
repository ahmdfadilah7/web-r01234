<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    // Menampilkan halaman user
    public function index() 
    {
        $setting = Setting::first();

        return view('user.index', compact('setting'));
    }

    // Menampilkan data user dengan datatables
    public function listData() 
    {
        if (Auth::user()->level == 'Operator') {
            $data = User::where('id', Auth::user()->id);
        } elseif (Auth::user()->level == 'Administrator') {
            $data = User::where('level', '<>', 'Superadmin');
        } else {
            $data = User::query();
        }
        $datatables = DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row) {
                $btn = '<a href="'.route('user.edit', $row->id).'" class="btn btn-primary btn-sm" style="margin-right: 10px;">
                            <i class="fa fa-edit"></i>
                        </a>';
                if ($row->id <> Auth::user()->id) {
                    $btn .= '<a href="'.route('user.delete', $row->id).'" class="btn btn-danger btn-sm">
                            <i class="fa fa-trash"></i>
                        </a>';
                }
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);

            return $datatables;
    }

    // Menampilkan halaman tambah user
    public function create() 
    {
        $setting = Setting::first();
        $level = array('Administrator', 'Operator');

        return view('user.add', compact('setting', 'level'));
    }

    // Proses menambahkan user
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'email' => 'required',
            'username' => 'required',
            'password' => 'required|min:8',
            'level' => 'required',
        ],
        [
            'required' => ':attribute wajib diisi!!'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors)->withInput($request->all());
        }

        User::create([
            'name' => $request->get('nama'),
            'email' => $request->get('email'),
            'username' => $request->get('username'),
            'password' => Hash::make($request->get('password')),
            'level' => $request->get('level')
        ]);

        return redirect()->route('user')->with('success', 'Berhasil menambahkan user.');
    }

    // Menampilkan halaman edit user
    public function edit($id) 
    {
        $setting = Setting::first();
        $user = User::find($id);
        $level = array('Administrator', 'Operator');

        return view('user.edit', compact('setting', 'user', 'level'));
    }

    // Proses mengupdate user
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'email' => 'required',
            'username' => 'required',
            'level' => 'required',
        ],
        [
            'required' => ':attribute wajib diisi!!'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors)->withInput($request->all());
        }

        $user = User::find($id);
        $user->name = $request->get('nama');
        $user->email = $request->get('email');
        $user->username = $request->get('username');
        $user->level = $request->get('level');
        if ($request->get('password') <> '') {
            $user->password = Hash::make($request->get('password'));
        }
        $user->save();

        return redirect()->route('user')->with('success', 'Berhasil mengupdate user.');
    }

    // Proses menghapus user
    public function destroy($id) 
    {
        $user = User::find($id);
        $user->delete();

        return redirect()->route('user')->with('success', 'Berhasil menghapus user.');
    }
}
