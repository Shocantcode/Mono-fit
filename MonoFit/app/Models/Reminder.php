<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    protected $table = 'reminders';

    protected $fillable = [
        'user_id', 'type', 'message', 'scheduled_at', 'sent'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
