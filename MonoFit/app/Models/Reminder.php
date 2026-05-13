<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    protected $table = 'reminders';

    protected $fillable = [
        'user_id', 'type', 'time', 'message', 'sent_at'
    ];

    protected $casts = [
        'time' => 'datetime:H:i',
        'sent_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
