<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenyakitAnggur extends Model
{
    use HasFactory;

    protected $fillable = [
        'gambar',
        'nama',
        'gejala',
        'solusi',
        'penyebab',
    ];
}
