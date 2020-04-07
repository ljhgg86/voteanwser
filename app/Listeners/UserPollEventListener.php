<?php

namespace App\Listeners;

use App\Events\UserPollEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\Rankinglist;

Use Carbon\Carbon;

class UserPollEventListener
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
     * @param  UserPollEvent  $event
     * @return void
     */
    public function handle(UserPollEvent $event)
    {
        $rankinglist =Rankinglist::firstOrCreate( ['user_id' => $event->user->id], ['poll_id' => $event->poll->id]);
        $rankinglist->increment('correct_num', $event->correctNum, ['last_correct_time' => Carbon::now()]);
    }
}
