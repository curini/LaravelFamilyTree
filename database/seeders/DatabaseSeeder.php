<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(GroupSeeder::class);
        $this->call(EventTypeSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(GenderSeeder::class);
        $this->call(PersonSeeder::class);
    }
}
