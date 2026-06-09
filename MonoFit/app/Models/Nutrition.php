<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nutrition extends Model
{
    protected $table = 'nutritions';

    protected $fillable = [
        'user_id',
        'date',
        'meals',
        'total_calories',
        'protein',
        'carbs',
        'fat',
        'water_intake',
    ];

    protected $casts = [
        'meals' => 'array',
        'date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
