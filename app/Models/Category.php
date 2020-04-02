<?php

namespace App\Models;

class Category extends Model
{
    protected $fillable = ['title', 'description'];

    protected $casts = [
        'delflag' => 'boolean',
    ];
}
