<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SebaranVarietas extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama',
        'gambar',
        'deskripsi',
        'jumlah_tanaman',
        'menjual_bibit',
        'lat',
        'lon'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
