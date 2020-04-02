<?php

use Illuminate\Database\Seeder;
use App\Models\Rankinglist;

class RankinglistsTableSeeder extends Seeder
{
    public function run()
    {
        $rankinglists = factory(Rankinglist::class)->times(50)->make()->each(function ($rankinglist, $index) {
            if ($index == 0) {
                // $rankinglist->field = 'value';
            }
        });

        Rankinglist::insert($rankinglists->toArray());
    }

}

