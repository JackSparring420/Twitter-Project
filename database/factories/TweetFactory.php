<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Tweet;
use Faker\Generator as Faker;

$factory->define(Tweet::class, function (Faker $faker) {
    return [
        'tweet_description' => $faker->text(),
        'tweet_img' => $faker->imageUrl(360, 360, 'animals', true, 'dogs', true),
        'tweet_date' => $faker->date(),
        "tweet_likes" => $faker -> randomFloat(1, 25, 50),
    ];
});
