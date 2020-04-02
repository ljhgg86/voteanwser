<?php

namespace App\Models;

class Reward extends Model
{
    protected $fillable = ['title', 'description', 'condition', 'delflag'];

    protected $casts = [
        'delflag' => 'boolean',
    ];

    public function rewardItems()
    {
        return $this->hasMany(RewardItem::class, 'reward_id');
    }

    public function rewardLogs()
    {
        return $this->hasMany(RewardLog::class, 'reward_id');
    }

    public function rewardRecords()
    {
        return $this->hasMany(RewardRecord::class, 'reward_id');
    }
}
