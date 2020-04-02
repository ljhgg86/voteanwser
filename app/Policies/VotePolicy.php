<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vote;

class VotePolicy extends Policy
{
    public function update(User $user, Vote $vote)
    {
        // return $vote->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, Vote $vote)
    {
        return true;
    }
}
