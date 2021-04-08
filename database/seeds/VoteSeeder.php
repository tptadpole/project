<?php

use App\Models\Vote;
use Illuminate\Database\Seeder;

class VoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for ($i = 1; $i <= 5; $i++) {
            Vote::create([
                'id' => $i ,
                'users_id' => $faker->numberBetween($min = 1, $max = 15),
                'spu_id' => $faker->numberBetween($min = 1, $max = 15),
                'vote' => $faker->boolean($chanceOfGettingTrue = 100),
            ]);
        }
    }
}
