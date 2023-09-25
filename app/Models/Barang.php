<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_barang',
        'kategori_id',
        'satuan_id',
        'nama_barang',
        'merk_barang',
        'gambar_barang',
        'harga_barang',
        'deskripsi_barang',
        'stok_barang'
    ];
}
