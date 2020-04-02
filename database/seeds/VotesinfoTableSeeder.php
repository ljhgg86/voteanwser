<?php

use Illuminate\Database\Seeder;
use App\Models\VoteInfo;

class VoteInfoTableSeeder extends Seeder
{
    public function run()
    {
        $voteInfos = factory(VoteInfo::class)->times(50)->make()->each(function ($voteInfo, $index) {
            if ($index == 0) {
                // $voteInfo->field = 'value';
            }
        });

        VoteInfo::insert($voteInfos->toArray());
    }

}

