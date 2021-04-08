<?php

use App\Models\Comment;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
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
            Comment::create([
                'id' => $i ,
                'users_id' => $faker->numberBetween($min = 1, $max = 15),
                'spu_id' => $faker->numberBetween($min = 1, $max = 15),
                'comment' => $faker->word,
            ]);
        }
    }
}
