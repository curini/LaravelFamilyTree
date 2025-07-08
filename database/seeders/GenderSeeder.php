<?php

namespace Database\Seeders;

use App\Models\Gender;
use Illuminate\Database\Seeder;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genders = config('genders.values', []);

        foreach ($genders as $gender) {
            Gender::updateOrCreate(['value' => $gender['value']], $gender);
        }
    }
}
