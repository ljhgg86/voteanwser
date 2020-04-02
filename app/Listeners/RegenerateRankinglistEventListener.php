<?php

namespace App\Listeners;

use App\Events\RegenerateRankinglistEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\UserVote;
use App\Models\Vote;
use App\Models\Rankinglist;
use App\Models\Option;
use App\Models\Answer;
Use Carbon\Carbon;

class RegenerateRankinglistEventListener
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
     * @param  RegenerateRankinglistEvent  $event
     * @return void
     */
    public function handle(RegenerateRankinglistEvent $event)
    {
        $poll_id = $event->poll_id;
        $rl=Rankinglist::where('poll_id', $poll_id)->get();

        if ($rl->isEmpty()) {
            return true;
        }

        //重置rankinglist
        Rankinglist::where('poll_id', $poll_id)->update(['correct_num'=>0]);

        //获取poll下的所有vote
        $votes = Vote::where('poll_id', $poll_id)
            ->where('delflag',false)
            ->orderBy('id', 'asc')
            ->get();


        $votes->each(function($vote) {
            //获取vote的answer ids
            $answer_ids=Answer::where('vote_id', $vote->id)->get()->pluck('option_id');
            //所有用户的投票列表
            $userVotes = UserVote::where('vote_id',$vote->id)
                            ->where('correct', true)
                            ->select('user_id','option_id')
                            ->get()->groupBy('user_id')
                            ->map(function($userVote) {
                                return $userVote->pluck('option_id');
                            });
            //对比answer和uservote，更新rankinglist
            foreach ($userVotes as $user_id => $option_ids) {
                if ($answer_ids->diff($option_ids)->isEmpty()) {
                    $rankinglist =Rankinglist::firstOrCreate( ['user_id' => $user_id], ['poll_id' => $vote->poll_id]);
                    $rankinglist->increment('correct_num', 1, ['last_correct_time' => Carbon::now()]);
                }
            }

        });


    }
}
