<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukSuratjalan extends Model
{
    use HasFactory;

    protected $fillable = [
        'suratjalan_id',
        'barang_id',
        'harga',
        'jumlah',
        'total',
    ];
}
