<?php

namespace App\Models;

class UserVote extends Model
{
    protected $fillable = ['correct'];

    protected $casts = [
        'correct' => 'boolean',
    ];

    public function option() {
        return $this->belongsTo(Option::class, 'option_id', 'id');
    }

    public function vote() {
        return $this->belongsTo(Vote::class, 'vote_id', 'id');
    }
}
