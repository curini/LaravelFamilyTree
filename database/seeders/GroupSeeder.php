<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Group;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = array_filter(
            json_decode(config('persons.data',[]), true), function($value) {
                return isset($value, $value['key'], $value['isGroup']);
            });
        

        foreach($data as $value) {
            Group::updateOrCreate(['id' => $value['key']], []);
        }
    }
}
