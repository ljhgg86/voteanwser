<?php

namespace App\Models;

class Rankinglist extends Model
{
    protected $fillable = ['user_id', 'poll_id', 'correct_num', 'last_correct_time'];

    public function user()
    {
        return $this->belongsTo(user::class, 'user_id');
    }

    public function poll()
    {
        return $this->belongsTo(Poll::class, 'poll_id');
    }
}
