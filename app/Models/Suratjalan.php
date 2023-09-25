<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suratjalan extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_po',
        'tanggal_po',
        'no_surat',
        'tanggal',
        'no_mobil'
    ];
}
