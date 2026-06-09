<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    protected $table = 'exercises';

    protected $fillable = [
        'name',
        'category',
        'muscle',
        'difficulty',
        'equipment',
        'image_path',
        'description',
    ];

    protected $casts = [
        'name' => 'string',
        'category' => 'string',
        'muscle' => 'string',
        'difficulty' => 'string',
        'equipment' => 'string',
        'image_path' => 'string',
        'description' => 'string',
    ];
}
