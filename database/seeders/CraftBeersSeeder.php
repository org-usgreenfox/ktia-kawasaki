<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CraftBeersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('craft_beers')->insert([
            'store_name' => Str::random(10),
            'address' => Str::random(10).'@gmail.com',
            'sns' => Str::random(10),
            'comments' => Str::random(10),
        ]);    }
}
