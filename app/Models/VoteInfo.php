<?php

namespace App\Models;

class VoteInfo extends Model
{
    protected $table = 'votesinfo';

    protected $fillable = [ 'vote_id', 'info', 'thumbnail'];

    public function vote()
    {
        return $this->belongsTo(Vote::class, 'vote_id');
    }
}
