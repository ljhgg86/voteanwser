<?php

namespace App\Policies;

use App\Models\User;
use App\Models\RewardRecord;

class RewardRecordPolicy extends Policy
{
    public function update(User $user, RewardRecord $reward_record)
    {
        // return $reward_record->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, RewardRecord $reward_record)
    {
        return true;
    }
}
