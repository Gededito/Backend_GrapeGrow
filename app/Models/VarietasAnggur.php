<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class VarietasAnggur extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'deskripsi',
        'karakteristik',
        'gambar',
    ];

    public function getGambarUrlAttribute()
    {
        return asset('storage/gambar_varietas/' . $this->attributes['gambar']); // Hapus satu 'gambar_varietas'
    }
}
