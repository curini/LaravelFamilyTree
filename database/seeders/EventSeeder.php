<?php

namespace Database\Seeders;

use App\EventsEnum;
use App\Models\City;
use App\Models\Event;
use App\Models\EventType;
use App\Models\Image;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = array_filter(json_decode(config('persons.data', []), true), function ($value) {
            return isset($value, $value['key'], $value['name']);
        });

        $events = EventsEnum::cases();

        foreach ($data as $key => $value) {
            foreach ($events as $type) {
                if (isset($value[$type->name])) {
                    $this->setAllEvent(
                        [
                            'id' => $value['key'],
                            'date' => $value[$type->name],
                            'image' => $value[$type->name . '_img'] ?? '',
                            'city' => $value[$type->name . 'place'] ?? '',
                            'description' => $value[$type->name . 'description'] ?? '',
                        ],
                        $type->value
                    );
                }
            }
        }
    }

    private function setAllEvent(array $person, string $type): void
    {
        $eventType = EventType::where(['name' => $type])->first();
        $city = City::where(['name' => $person['city']])->first();
        $image = Image::where(['path' => asset($person['image'])])->first();

        Event::updateOrCreate(
            [
                'person_id' => $person['id'],
                'event_type_id' => $eventType->id,
                'date' => new \DateTime($person['date']),
            ],
            [
                'person_id' => $person['id'],
                'image_id' => $image->id ?? null,
                'event_type_id' => $eventType->id,
                'date' => new \DateTime($person['date']),
                'city_id' => $city->id ?? null,
            ]
        );
    }
}
