<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Onboarding extends Model
{
    protected $table = 'onboardings';

    protected $fillable = [
        'user_id', 'age', 'gender', 'height', 'weight', 'body_fat', 'activity_level', 'fitness_goal', 'equipment', 'bmi', 'bmr', 'tdee', 'somatotype'
    ];

    protected $casts = [
        'equipment' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getRecommendedCaloriesAttribute()
    {
        if (! $this->tdee || ! $this->fitness_goal) {
            return null;
        }

        switch ($this->fitness_goal) {
            case 'fat_loss':
                return max(0, round($this->tdee - 500));
            case 'muscle_gain':
                return round($this->tdee + 300);
            case 'maintenance':
            default:
                return round($this->tdee);
        }
    }
}
