<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(SpuSeeder::class);
        $this->call(SkuSeeder::class);
        $this->call(CommentSeeder::class);
        $this->call(VoteSeeder::class);
    }
}
