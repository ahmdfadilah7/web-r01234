<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_referensi',
        'barang_id',
        'aksesoris_id',
        'nama_supplier',
        'harga',
        'jumlah',
        'total',
    ];
}
