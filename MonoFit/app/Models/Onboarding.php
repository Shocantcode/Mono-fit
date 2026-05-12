<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Onboarding extends Model
{
    protected $fillable = [
        'user_id', 'age', 'gender', 'height', 'weight', 'body_fat', 'activity_level', 'fitness_goal', 'equipment', 'bmi', 'bmr', 'tdee', 'somatotype'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
