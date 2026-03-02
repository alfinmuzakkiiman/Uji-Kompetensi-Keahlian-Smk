<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'judul',
        'penerbit',
        'tahun_terbit',
        'stok',
    ];
}
