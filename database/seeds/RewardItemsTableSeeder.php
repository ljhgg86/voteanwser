<?php

use Illuminate\Database\Seeder;
use App\Models\RewardItem;

class RewardItemsTableSeeder extends Seeder
{
    public function run()
    {
        $reward_items = factory(RewardItem::class)->times(50)->make()->each(function ($reward_item, $index) {
            if ($index == 0) {
                // $reward_item->field = 'value';
            }
        });

        RewardItem::insert($reward_items->toArray());
    }

}

