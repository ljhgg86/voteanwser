<?php

namespace App\Models;

class RewardRecord extends Model
{
    protected $fillable = ['reward_id', 'user_id', 'reward_type', 'redeem_code', 'redeemflag', 'redeem_at', 'sendsms_flag', 'sendsms_at', 'remark'];

    protected $casts = [
        'redeemflag' => 'boolean',
        'sendsms_flag' => 'boolean',
    ];

    public function reward()
    {
        return $this->belongsTo(Reward::class, 'reward_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
