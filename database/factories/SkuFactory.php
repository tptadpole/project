<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Sku;
use Faker\Generator as Faker;

$factory->define(Sku::class, function (Faker $faker) {
    return [
        'users_id' => $faker->numberBetween($min = 1, $max = 1),
        'spu_id' => $faker->numberBetween($min = 1, $max = 1),
        'name' => $faker->word,
        'price' => $faker->numberBetween($min = 1, $max = 200),
        'specification' => $faker->word,
        'stock' => $faker->numberBetween($min = 0, $max = 50),
        'image' => '',
    ];
});
