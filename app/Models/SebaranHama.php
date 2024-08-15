<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SebaranHama extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama',
        'gejala',
        'solusi',
        'gambar',
        'lat',
        'lon',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
