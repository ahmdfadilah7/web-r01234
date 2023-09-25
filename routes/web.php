<?php

use App\Http\Controllers\AksesorisController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PenyewaanController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SuratjalanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [AuthController::class, 'index'])->name('login');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::post('prosesLogin', [AuthController::class, 'proses_login'])->name('prosesLogin');
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('prosesRegister', [AuthController::class, 'store'])->name('prosesRegister');

Route::group(['middleware' => ['auth']], function() {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('setting', [SettingController::class, 'index'])->name('setting');
    Route::get('setting/getlistdata', [SettingController::class, 'listData'])->name('setting.list');
    Route::get('setting/add', [SettingController::class, 'create'])->name('setting.add');
    Route::post('setting/store', [SettingController::class, 'store'])->name('setting.store');
    Route::get('setting/edit/{id}', [SettingController::class, 'edit'])->name('setting.edit');
    Route::put('setting/update/{id}', [SettingController::class, 'update'])->name('setting.update');
    Route::get('setting/delete/{id}', [SettingController::class, 'destroy'])->name('setting.delete');

    Route::get('user', [UserController::class, 'index'])->name('user');
    Route::get('user/getlistdata', [UserController::class, 'listData'])->name('user.list');
    Route::get('user/add', [UserController::class, 'create'])->name('user.add');
    Route::post('user/store', [UserController::class, 'store'])->name('user.store');
    Route::get('user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('user/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::get('user/delete/{id}', [UserController::class, 'destroy'])->name('user.delete');

    Route::get('kategori', [KategoriController::class, 'index'])->name('kategori');
    Route::get('kategori/getlistdata', [KategoriController::class, 'listData'])->name('kategori.list');
    Route::get('kategori/add', [KategoriController::class, 'create'])->name('kategori.add');
    Route::post('kategori/store', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('kategori/edit/{id}', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('kategori/update/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::get('kategori/delete/{id}', [KategoriController::class, 'destroy'])->name('kategori.delete');

    Route::get('satuan', [SatuanController::class, 'index'])->name('satuan');
    Route::get('satuan/getlistdata', [SatuanController::class, 'listData'])->name('satuan.list');
    Route::get('satuan/add', [SatuanController::class, 'create'])->name('satuan.add');
    Route::post('satuan/store', [SatuanController::class, 'store'])->name('satuan.store');
    Route::get('satuan/edit/{id}', [SatuanController::class, 'edit'])->name('satuan.edit');
    Route::put('satuan/update/{id}', [SatuanController::class, 'update'])->name('satuan.update');
    Route::get('satuan/delete/{id}', [SatuanController::class, 'destroy'])->name('satuan.delete');

    Route::get('barang', [BarangController::class, 'index'])->name('barang');
    Route::get('barang/getlistdata', [BarangController::class, 'listData'])->name('barang.list');
    Route::get('barang/add', [BarangController::class, 'create'])->name('barang.add');
    Route::post('barang/store', [BarangController::class, 'store'])->name('barang.store');
    Route::get('barang/edit/{id}', [BarangController::class, 'edit'])->name('barang.edit');
    Route::put('barang/update/{id}', [BarangController::class, 'update'])->name('barang.update');
    Route::get('barang/delete/{id}', [BarangController::class, 'destroy'])->name('barang.delete');

    Route::get('aksesoris', [AksesorisController::class, 'index'])->name('aksesoris');
    Route::get('aksesoris/getlistdata', [AksesorisController::class, 'listData'])->name('aksesoris.list');
    Route::get('aksesoris/add', [AksesorisController::class, 'create'])->name('aksesoris.add');
    Route::post('aksesoris/store', [AksesorisController::class, 'store'])->name('aksesoris.store');
    Route::get('aksesoris/edit/{id}', [AksesorisController::class, 'edit'])->name('aksesoris.edit');
    Route::put('aksesoris/update/{id}', [AksesorisController::class, 'update'])->name('aksesoris.update');
    Route::get('aksesoris/delete/{id}', [AksesorisController::class, 'destroy'])->name('aksesoris.delete');

    Route::get('pembelian/barang', [PembelianController::class, 'index'])->name('pembelian.barang');
    Route::get('pembelian/aksesoris', [PembelianController::class, 'index'])->name('pembelian.aksesoris');
    Route::get('pembelian/getlistdata/{id}', [PembelianController::class, 'listData'])->name('pembelian.list');
    Route::get('pembelian/barang/add', [PembelianController::class, 'create'])->name('pembelian.barang.add');
    Route::get('pembelian/aksesoris/add', [PembelianController::class, 'create'])->name('pembelian.aksesoris.add');
    Route::post('pembelian/store', [PembelianController::class, 'store'])->name('pembelian.store');
    Route::get('pembelian/delete/{jenis}/{id}', [PembelianController::class, 'destroy'])->name('pembelian.delete');
    Route::post('pembelian/export', [PembelianController::class, 'export'])->name('pembelian.export');
    Route::get('pembelian/invoice/{jenis}/{type}/{no_referensi}', [PembelianController::class, 'invoice'])->name('pembelian.invoice');

    Route::get('penjualan/barang', [PenjualanController::class, 'index'])->name('penjualan.barang');
    Route::get('penjualan/aksesoris', [PenjualanController::class, 'index'])->name('penjualan.aksesoris');
    Route::get('penjualan/getlistdata/{id}', [PenjualanController::class, 'listData'])->name('penjualan.list');
    Route::get('penjualan/barang/add', [PenjualanController::class, 'create'])->name('penjualan.barang.add');
    Route::get('penjualan/aksesoris/add', [PenjualanController::class, 'create'])->name('penjualan.aksesoris.add');
    Route::post('penjualan/store', [PenjualanController::class, 'store'])->name('penjualan.store');
    Route::get('penjualan/delete/{jenis}/{id}', [PenjualanController::class, 'destroy'])->name('penjualan.delete');
    Route::post('penjualan/export', [PenjualanController::class, 'export'])->name('penjualan.export');
    Route::get('penjualan/invoice/{jenis}/{type}/{no_referensi}', [PenjualanController::class, 'invoice'])->name('penjualan.invoice');

    Route::get('penyewaan', [PenyewaanController::class, 'index'])->name('penyewaan');
    Route::get('penyewaan/getlistdata', [PenyewaanController::class, 'listData'])->name('penyewaan.list');
    Route::get('penyewaan/add', [PenyewaanController::class, 'create'])->name('penyewaan.add');
    Route::post('penyewaan/store', [PenyewaanController::class, 'store'])->name('penyewaan.store');
    Route::get('penyewaan/diambil/{id}', [PenyewaanController::class, 'diambil'])->name('penyewaan.diambil');
    Route::get('penyewaan/selesai/{id}', [PenyewaanController::class, 'selesai'])->name('penyewaan.selesai');
    Route::get('penyewaan/dibatalkan/{id}', [PenyewaanController::class, 'dibatalkan'])->name('penyewaan.dibatalkan');
    Route::get('penyewaan/delete/{id}', [PenyewaanController::class, 'destroy'])->name('penyewaan.delete');
    Route::post('penyewaan/export', [PenyewaanController::class, 'export'])->name('penyewaan.export');
    Route::get('penyewaan/invoice/{type}/{no_referensi}', [PenyewaanController::class, 'invoice'])->name('penyewaan.invoice');

    Route::get('suratjalan', [SuratjalanController::class, 'index'])->name('suratjalan');
    Route::get('suratjalan/getlistdata', [SuratjalanController::class, 'listData'])->name('suratjalan.list');
    Route::get('suratjalan/add', [SuratjalanController::class, 'create'])->name('suratjalan.add');
    Route::post('suratjalan/store', [SuratjalanController::class, 'store'])->name('suratjalan.store');
    Route::get('suratjalan/delete/{id}', [SuratjalanController::class, 'destroy'])->name('suratjalan.delete');
    Route::get('suratjalan/invoice/{type}/{no_referensi}', [SuratjalanController::class, 'invoice'])->name('suratjalan.invoice');

    Route::get('barang/{id}', [BarangController::class, 'getBarang'])->name('barang.get_barang');
    Route::get('aksesoris/{id}', [AksesorisController::class, 'getAksesoris'])->name('aksesoris.get_aksesoris');

});
