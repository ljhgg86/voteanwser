<?php

use Illuminate\Database\Seeder;
use App\Models\Reward;

class RewardsTableSeeder extends Seeder
{
    public function run()
    {
        $rewards = factory(Reward::class)->times(50)->make()->each(function ($reward, $index) {
            if ($index == 0) {
                // $reward->field = 'value';
            }
        });

        Reward::insert($rewards->toArray());
    }

}

