<?php

namespace App\Policies;

use App\Models\User;
use App\Models\RewardLog;

class RewardLogPolicy extends Policy
{
    public function update(User $user, RewardLog $reward_log)
    {
        // return $reward_log->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, RewardLog $reward_log)
    {
        return true;
    }
}
