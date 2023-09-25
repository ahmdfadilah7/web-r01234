<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyewaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_referensi',
        'barang_id',
        'nama_penyewa',
        'no_telp',
        'jumlah',
        'dari',
        'sampai',
        'total',
        'status',
    ];
}
