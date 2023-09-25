<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function index() 
    {
        $setting = Setting::first();

        return view('auth.login', compact('setting'));
    }

    // Menampilkan halaman register
    public function register() 
    {
        $setting = Setting::first();

        return view('auth.register', compact('setting'));
    }

    // Proses Logout
    public function logout()
    {
        if (Auth::check()) {
            Auth::logout();
        }
        return redirect()->route('login')->with('success', 'Berhasil keluar.');
    }

    // Proses register
    public function store(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required',
            'email' => 'required',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors)->withInput($request->all());
        }

        User::create([
            'name' => $request->get('name'),
            'username' => $request->get('username'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'level' => 'Superadmin'
        ]);

        return redirect()->route('login')->with('success', 'Berhasil menambahkan user baru.');
    }

    // Proses login
    public function proses_login(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required|min:8'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors)->withInput($request->all());
        }

        $username = $request->get('username');
        $password = Hash::make($request->get('password'));
        if (Auth::attempt($request->only(['username', 'password']))) {
            return redirect()->route('dashboard')->with('success', 'Berhasil Login');
        } else {
            return back()->with('danger', 'Data yang dimasukkan tidak sesuai.');
        }
    }
}
