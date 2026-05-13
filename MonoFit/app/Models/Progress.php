<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    protected $table = 'progresses';

    protected $fillable = [
        'user_id', 'date', 'weight', 'calories', 'workout_completed', 'streak', 'notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
