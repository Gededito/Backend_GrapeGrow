<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClassVideo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama',
        'path_video',
        'thumbnail_video',
        'category_classes_id'
    ];

    public function categoryClass() {
        return $this->belongsTo(CategoryClass::class);
    }
}
