<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Person;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = array_filter(
            json_decode(config('persons.data',[]), true), function($value) {
                return isset($value, $value['key'], $value['name']);
            });
        

        foreach($data as $value) {
            $id = $value['key'];
            unset($value['key']);
            Person::updateOrCreate(['id' => $id], $value);
        }
    }
}
