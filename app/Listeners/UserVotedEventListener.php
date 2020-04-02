<?php

namespace App\Listeners;

use App\Events\UserVotedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Answer;
use App\Models\Rankinglist;

Use Carbon\Carbon;

class UserVotedEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserVotedEvent  $event
     * @return void
     */
    public function handle(UserVotedEvent $event)
    {
        $answer_ids = Answer::where('vote_id', $event->vote->id)->get()->pluck('option_id');
        //根据用户投票的正确与否处理rankinglists表

        if ($answer_ids->diff($event->option_ids)->isEmpty()) {
            $rankinglist =Rankinglist::firstOrCreate( ['user_id' => $event->user->id], ['poll_id' => $event->vote->poll_id]);
            $rankinglist->increment('correct_num', 1, ['last_correct_time' => Carbon::now()]);
        }

    }
}
