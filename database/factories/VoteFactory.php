<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Vote::class, function (Faker $faker) {

    return [
        'title'=> $faker->sentence,
        'thumbnail'=> $faker->imageUrl($width = 640, $height = 480),
        'start_at'=>$faker->dateTimeBetween($startDate = '-1 months', $endDate = '1 months', $timezone = 'Asia/Shanghai'),
        'end_at'=>$faker->dateTimeBetween($startDate = '1 months', $endDate = '6 months', $timezone = 'Asia/Shanghai'),
        'view_end_at'=>$faker->dateTimeBetween($startDate = '6 months', $endDate = '7 months', $timezone = 'Asia/Shanghai'),
        'option_count'=>$faker->numberBetween($min=1, $max=6),
        'option_type'=>1,
        'vote_type'=>1,
        'vote_count'=> $faker->numberBetween($min = 100, $max = 900),
        'show_votecount'=> $faker->boolean(),
        'description'=> $faker->paragraph,
        'delflag' => $faker->boolean()
    ];
});
