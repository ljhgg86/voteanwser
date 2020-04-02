<?php

namespace App\Models;

class RewardLog extends Model
{
    protected $fillable = ['reward_id', 'user_id', 'reward_type', 'reward_count', 'remark'];

    public function reward()
    {
        return $this->belongsTo(Reward::class, 'reward_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
