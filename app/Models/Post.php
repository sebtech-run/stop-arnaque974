<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'slug', 'image_path', 'content', 'is_published'];

    protected $casts = [
        'is_published' => 'boolean',
    ];
}
