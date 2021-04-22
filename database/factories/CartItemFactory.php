<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\CartItem;
use Faker\Generator as Faker;

$factory->define(CartItem::class, function (Faker $faker) {
    return [
        'users_id' => $faker->numberBetween($min = 1, $max = 1),
        'sku_id' => $faker->numberBetween($min = 1, $max = 1),
        'amount' => $faker->numberBetween($min = 1, $max = 100),
    ];
});
