<?php

namespace Database\Seeders;

use App\EventTypesEnum;
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
        $events = [
            'birth' => EventTypesEnum::BIRTH->value,
            'death' => EventTypesEnum::DEATH->value,
            'wedding' => EventTypesEnum::WEDDING->value,
            'otherwedding' => EventTypesEnum::WEDDING->value,
            'military' => EventTypesEnum::MILITARY->value,
            'house' => EventTypesEnum::MOVE->value,
            'oldhouse' => EventTypesEnum::MOVE->value,
            'papers' => EventTypesEnum::OTHER->value,
            'otherpapers' => EventTypesEnum::OTHER->value,
            'deathchild' => EventTypesEnum::OTHER->value,
        ];

        foreach ($data as $key => $value) {
            foreach ($events as $event => $type) {
                if (isset($value[$event])) {
                    $this->setAllEvent(
                        [
                            'id' => $value['key'],
                            'date' => $value[$event],
                            'image' => $value[$event . '_img'] ?? '',
                            'city' => $value[$event . 'place'] ?? '',
                        ],
                        $type
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
