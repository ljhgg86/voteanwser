<?php

namespace App\Listeners;

use App\Events\InputAnswerEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\UserVote;
use App\Models\Vote;
use App\Models\Rankinglist;
Use Carbon\Carbon;

class InputAnswerEventListener
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
     * @param  InputAnswerEvent  $event
     * @return void
     */
    public function handle(InputAnswerEvent $event)
    {
        //修改userVote表
        $answer_ids = $event->answer_ids;

        $answer_ids->each(function($answer_id) use ($event) {
            $inputed=$event->vote->answers()->toggle($answer_id, ['vote_id' => $event->vote->id]);

            if (count($inputed['attached']) > 0) {
                UserVote::where('vote_id', $event->vote->id)->where('option_id', $answer_id)->update(['correct'=>true]);
            }
            if (count($inputed['detached']) > 0) {
                UserVote::where('vote_id', $event->vote->id)->where('option_id', $answer_id)->update(['correct'=>false]);
            }
        });

        $userVotes = UserVote::where('vote_id',$event->vote->id)
                            ->where('correct', true)
                            ->select('user_id','option_id')
                            ->get()->groupBy('user_id')
                            ->map(function($userVote) {
                                return $userVote->pluck('option_id');
                            });

        foreach ($userVotes as $user_id => $option_ids) {
            if ($event->answer_ids->diff($option_ids)->isEmpty()) {
                $rankinglist =Rankinglist::firstOrCreate(['user_id' => $user_id,'poll_id' => $event->vote->poll_id]);
                $uv=UserVote::where('user_id', $user_id)->where('vote_id', $event->vote->id)->first();
                $rankinglist->increment('correct_num', 1, ['last_correct_time' => $uv->created_at]);
            }
        }

    }
}
