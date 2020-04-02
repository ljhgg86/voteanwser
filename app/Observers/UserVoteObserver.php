<?php

namespace App\Observers;

use App\Models\UserVote;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class UserVoteObserver
{
    public function creating(UserVote $user_vote)
    {
        //
    }

    public function updating(UserVote $user_vote)
    {
        //
    }
}