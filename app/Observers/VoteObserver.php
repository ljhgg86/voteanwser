<?php

namespace App\Observers;

use App\Models\Vote;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class VoteObserver
{
    public function creating(Vote $vote)
    {
        //
    }

    public function updating(Vote $vote)
    {
        //
    }
}