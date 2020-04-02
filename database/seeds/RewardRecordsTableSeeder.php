<?php

use Illuminate\Database\Seeder;
use App\Models\RewardRecord;

class RewardRecordsTableSeeder extends Seeder
{
    public function run()
    {
        $reward_records = factory(RewardRecord::class)->times(50)->make()->each(function ($reward_record, $index) {
            if ($index == 0) {
                // $reward_record->field = 'value';
            }
        });

        RewardRecord::insert($reward_records->toArray());
    }

}

