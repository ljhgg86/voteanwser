<?php

namespace App\Policies;

use App\Models\User;
use App\Models\RewardItem;

class RewardItemPolicy extends Policy
{
    public function update(User $user, RewardItem $reward_item)
    {
        // return $reward_item->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, RewardItem $reward_item)
    {
        return true;
    }
}
