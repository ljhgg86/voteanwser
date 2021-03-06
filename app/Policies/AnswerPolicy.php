<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Answer;

class AnswerPolicy extends Policy
{
    public function update(User $user, Answer $answer)
    {
        // return $answer->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, Answer $answer)
    {
        return true;
    }
}
