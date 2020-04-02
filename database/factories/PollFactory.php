<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Poll::class, function (Faker $faker) {

    return [
         'title' => $faker->sentence,
         'thumbnail'=>$faker->imageUrl($width = 640, $height = 480),
         'description'=>$faker->paragraph,
         'rules'=>$faker->paragraph,
         'category_id'=>1,
         'vote_count'=>$faker->numberBetween($min = 0, $max = 9990),
         'show_votecount'=>$faker->boolean(),
         'createuser_id'=>1,
         'verifyuser_id'=>1,
         'verifyflag'=>$faker->boolean(),
         'endflag'=>$faker->boolean(),
         'delflag'=>$faker->boolean(),
    ];
});
