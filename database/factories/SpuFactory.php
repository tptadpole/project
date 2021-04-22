<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Spu;
use Faker\Generator as Faker;

$factory->define(Spu::class, function (Faker $faker) {
    return [
        'users_id' => $faker->numberBetween($min = 1, $max = 1),
        'name' => $faker->word,
        'description' => $faker->word,
        'image' => '',
    ];
});
