<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Order;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'users_id' => $faker->numberBetween($min = 1, $max = 1),
        'name' => $faker->word,
        'address' => $faker->word,
        'phone' => '0912345678',
        'total_amount' => $faker->numberBetween($min = 1, $max = 100000),
        'payment' => 'cash',
    ];
});
