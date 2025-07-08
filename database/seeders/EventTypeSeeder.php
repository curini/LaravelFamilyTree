<?php

namespace Database\Seeders;

use App\EventTypesEnum;
use App\Models\EventType;
use Illuminate\Database\Seeder;

class EventTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = EventTypesEnum::cases();

        foreach ($types as $key => $type) {
            EventType::updateOrCreate(
                [
                    'name' => $type,
                ],
                ['name' => $type]
            );
        }
    }
}
