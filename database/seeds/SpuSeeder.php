<?php

use App\Models\Spu;
use Illuminate\Database\Seeder;

class SpuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker\Factory::create();
        for ($i = 1; $i <= 5; $i++) {
            Spu::create([
                'id' => $i ,
                'seller_id' => $faker->numberBetween($min = 1, $max = 10),
                'name' => $faker->word,
                'amount' => $faker->numberBetween($min = 1, $max = 100),
                'vote' => $faker->numberBetween($min = 0, $max = 20),
                'comment' => $faker->word,
                'stock' => $faker->numberBetween($min = 0, $max = 20),
            ]);
        }
    }
}
