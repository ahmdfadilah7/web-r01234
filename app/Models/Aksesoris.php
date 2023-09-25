<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aksesoris extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_aksesoris',
        'nama_aksesoris',
        'merk_aksesoris',
        'kategori_id',
        'satuan_id',
        'gambar_aksesoris',
        'harga_aksesoris',
        'deskripsi_aksesoris'
    ];
}
