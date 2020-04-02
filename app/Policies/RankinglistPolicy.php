<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Rankinglist;

class RankinglistPolicy extends Policy
{
    public function update(User $user, Rankinglist $rankinglist)
    {
        // return $rankinglist->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, Rankinglist $rankinglist)
    {
        return true;
    }
}
