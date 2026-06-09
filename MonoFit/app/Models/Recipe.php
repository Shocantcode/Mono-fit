<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $table = 'recipes';

    protected $fillable = [
        'name',
        'goal',
        'description',
        'image_url',
        'ingredients',
        'steps',
        'calories',
        'protein',
        'carbs',
        'fat',
    ];

    protected $casts = [
        'ingredients' => 'array',
        'steps' => 'array',
    ];
}
