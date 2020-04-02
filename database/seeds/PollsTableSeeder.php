<?php

use Illuminate\Database\Seeder;
use App\Models\Option;
use App\Models\Vote;
use App\Models\Poll;

class PollsTableSeeder extends Seeder
{
    public function run()
    {
        $polls = factory(Poll::class,10)->create()->each(function ($poll) {

            $votes = factory(Vote::class)->times(20)->make()->each(function ($vote) {
            });

            $poll->votes()->createMany($votes->toArray());

            $poll->votes()->each(function ($vote) {
                $vote->options()->createMany(factory(Option::class, $vote->option_count)->make()->toArray());
            });

            //$vote->options()->createMany(factory(Option::class, $vote->option_count)->make()->toArray());


        });


    }

}

