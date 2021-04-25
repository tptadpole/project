<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'users_id' => $faker->numberBetween($min = 1, $max = 1),
        'sku_id' => $faker->numberBetween($min = 1, $max = 1),
        'comment' => $faker->word,
    ];
});
