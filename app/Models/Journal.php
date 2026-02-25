<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $fillable = [
        'title',
        'author',
        'summary',
        'status',
        'published_at',
        'pdf_path',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];
}
