<?php

namespace App\Models;

class RewardItem extends Model
{
    protected $fillable = ['reward_id', 'poll_id', 'vote_id'];

    public function reward()
    {
        return $this->belongsTo(Reward::class, 'reward_id');
    }

    public function poll()
    {
        return $this->belongsTo(Poll::class, 'poll_id');
    }

    public function vote()
    {
        return $this->belongsTo(Vote::class, 'vote_id');
    }
}
