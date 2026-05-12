<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    protected $fillable = [
        'user_id', 'date', 'exercises', 'total_sets', 'total_reps', 'total_weight', 'completed', 'notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
