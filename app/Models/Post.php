<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'title',
        'body',
        'type',
        'url',
        'user_id',
        'created_at',
        'updated_at',
        

    ];
}