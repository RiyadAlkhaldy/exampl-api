<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'comment',
        'post_id',
        'user_id',
        'created_at',
        'updated_at',
        
    ];

    public function posts(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
