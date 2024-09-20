<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoryClass extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'about',
        'thumbnail_category',
    ];

    public function videos() {
        return $this->hasMany(ClassVideo::class, 'category_classes_id');
    }
}
