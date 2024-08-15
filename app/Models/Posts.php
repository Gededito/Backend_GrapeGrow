<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Posts extends Model
{
    use HasFactory;

    // Hanya Dapat Digunakan Untuk Upload 1 Foto
    protected $fillable = [
        'user_id',
        'content',
        'gambar',
    ];

    protected $appends = ['liked'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(LikePost::class, 'post_id');
    }

    public function getLikedAttribute(): bool
    {
        return (bool) $this->likes()->where('post_id', $this->id)->where('user_id', auth()->id())->exists();
    }

    public function comment(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
