<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Option::class, function (Faker $faker) {
    return [
        'option' => $faker->word,
        'thumbnail'=>$faker->imageUrl($width = 640, $height = 480),
        'vote_count'=> $faker->numberBetween($min = 300, $max = 900),
        'description'=> $faker->paragraph
    ];
});
