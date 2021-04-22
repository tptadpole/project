<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\OrderItem;
use Faker\Generator as Faker;

$factory->define(OrderItem::class, function (Faker $faker) {
    return [
        'users_id' => $faker->numberBetween($min = 1, $max = 1),
        'order_id' => $faker->numberBetween($min = 1, $max = 1),
        'sku_id' => $faker->numberBetween($min = 1, $max = 1),
        'amount' => $faker->numberBetween($min = 1, $max = 100),
        'price' => $faker->numberBetween($min = 1, $max = 100000),
        'status' => '出貨',
    ];
});
