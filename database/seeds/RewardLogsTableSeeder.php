<?php

use Illuminate\Database\Seeder;
use App\Models\RewardLog;

class RewardLogsTableSeeder extends Seeder
{
    public function run()
    {
        $reward_logs = factory(RewardLog::class)->times(50)->make()->each(function ($reward_log, $index) {
            if ($index == 0) {
                // $reward_log->field = 'value';
            }
        });

        RewardLog::insert($reward_logs->toArray());
    }

}

