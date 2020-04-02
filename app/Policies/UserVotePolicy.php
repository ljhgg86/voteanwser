<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserVote;

class UserVotePolicy extends Policy
{
    public function update(User $user, UserVote $user_vote)
    {
        // return $user_vote->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, UserVote $user_vote)
    {
        return true;
    }
}
