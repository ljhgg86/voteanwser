<?php

namespace App\Policies;

use App\Models\User;
use App\Models\VoteInfo;

class VoteInfoPolicy extends Policy
{
    public function update(User $user, VoteInfo $voteInfo)
    {
        // return $voteInfo->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, VoteInfo $voteInfo)
    {
        return true;
    }
}
