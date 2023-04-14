<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'content',
        'type',
        'url',
        'user_id',
        'section_id',
        'colloge_id',
        'created_at',
        'updated_at',
        

    ];
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    

}