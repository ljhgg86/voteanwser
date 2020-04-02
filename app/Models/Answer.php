<?php

namespace App\Models;

class Answer extends Model
{
    protected $fillable = ['vote_id', 'option_id'];

    public function vote()
    {
        $this->belongsTo(Vote::class, 'vote_id');
    }

    public function option()
    {
        return $this->belongsTo(Option::class, 'option_id');
    }
}
