<?php

use App\Models\Sku;
use Illuminate\Database\Seeder;

class SkuSeeder extends Seeder
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
            Sku::create([
                'id' => $i ,
                'name' => $faker->word,
                'spu_id' => $faker->numberBetween($min = 1, $max = 15),
                'price' => $faker->numberBetween($min = 30, $max = 200),
                'specification' => $faker->word,
                'stock' => $faker->numberBetween($min = 0, $max = 50),
                'image' => '',
            ]);
        }
    }
}
