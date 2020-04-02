<?php

use Illuminate\Database\Seeder;
use App\Models\Vote;
use App\Models\Option;

class VotesTableSeeder extends Seeder
{
    public function run()
    {
        $votes = factory(Vote::class,200)->create()->each(function ($vote) {
            $vote->options()->createMany(factory(Option::class, $vote->option_count)->make()->toArray());
        });
    }

}

