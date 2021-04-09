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
        $faker = Faker\Factory::create();
        for ($i = 1; $i <= 5; $i++) {
            Spu::create([
                'id' => $i ,
                'users_id' => $faker->numberBetween($min = 1, $max = 15),
                'name' => $faker->word,
                'description' => $faker->word,
                'image' => '',
            ]);
        }
    }
}
