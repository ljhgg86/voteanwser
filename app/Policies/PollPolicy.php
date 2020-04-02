<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Poll;

class PollPolicy extends Policy
{
    public function update(User $user, Poll $poll)
    {
        // return $poll->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, Poll $poll)
    {
        return true;
    }
}
