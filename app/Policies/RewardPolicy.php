<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reward;

class RewardPolicy extends Policy
{
    public function update(User $user, Reward $reward)
    {
        // return $reward->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, Reward $reward)
    {
        return true;
    }
}
