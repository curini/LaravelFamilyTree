<?php

namespace Database\Seeders;

use App\EventTypesEnum;
use App\Models\City;
use App\Models\EventType;
use App\Models\Gender;
use App\Models\Image;
use Illuminate\Database\Seeder;
use App\Models\Person;
use App\Models\Event;
use App\Models\Position;
use DateTime;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = array_filter(json_decode(config('persons.data', []), true), function ($value) {
            return isset($value, $value['key'], $value['name']);
        });

        $img_man = $this->updateOrCreateImage(config('persons.portrait.M.src', ''), 'portrait');
        $img_woman = $this->updateOrCreateImage(config('persons.portrait.F.src', ''), 'portrait');
        $positions = [];
        $start = 0;

        foreach ($data as $key => $value) {
            if ($key == 0) {
                $start = $value['generation'];
            }
            if (empty($positions[$value['generation']])) {
                $positions[$value['generation']] = 100;
            }

            $gender = Gender::where(['value' => $value['gender'] ?? 'M'])->firstOrFail();
            $image = isset($value['photo']) ? $this->updateOrCreateImage($value['photo'], 'portrait') : null;
            $name = $this->setNames($value['name']);
            $y = ($value['generation'] - $start) * 70 + 40;
            $position = $this->setPosition($positions[$value['generation']], $y);
            $positions[$value['generation']] += 240;

            $default_image = isset($value['gender']) && $value['gender'] == 'F' ? $img_woman : $img_man;

            $person = Person::updateOrCreate(
                [
                    'id' => $value['key'],
                    'first_name' => $name['first_name'],
                    'last_name' => $name['last_name'],
                ],
                [
                    'id' => $value['key'],
                    'first_name' => $name['first_name'],
                    'last_name' => $name['last_name'],
                    'job' => $value['job'] ?? '',
                    'description' => $value['description'] ?? '',
                    'gender_id' => $gender->id,
                    'group_id' => $value['group'] ?? null,
                    'father_id' => $value['father'] ?? null,
                    'mother_id' => $value['mother'] ?? null,
                    'spouse_id' => $value['spouse'] ?? null,
                    'image_id' => isset($image) ? $image->id : $default_image->id,
                    'position_id' => $position->id,
                ]
            );

            if (isset($value['birth'])) {
                $this->setAllEvent(
                    $person->id,
                    $value['birth'],
                    $value['birthplace'] ?? '',
                    EventTypesEnum::BIRTH->value
                );
            }

            if (isset($value['death'])) {
                $this->setAllEvent(
                    $person->id,
                    $value['death'],
                    $value['deathplace'] ?? '',
                    EventTypesEnum::DEATH->value
                );
            }
        }
    }

    private function setNames(string $name): array
    {
        $names = explode(' ', $name);
        $lastname = '';

        foreach ($names as $value) {
            $clean_name = str_replace('-', '', $value);
            if (ctype_upper(trim($clean_name))) {
                $lastname .= $value . ' ';
                $name = str_replace($value, '', $name);
            }
        }
        return ['first_name' => trim($name), 'last_name' => trim($lastname)];
    }

    private function setPosition(float $x, float $y): Position
    {
        return Position::updateOrCreate(
            [
                'X' => $x,
                'y' => $y,
            ],
            [
                'X' => $x,
                'y' => $y,
            ]
        );
    }

    private function setAllEvent(int $person_id, string $date, string $city, string $type): void
    {
        $eventType = EventType::where(['name' => $type])->first();
        $city = City::where(['name' => $city])->first();

        Event::updateOrCreate(
            [
                'person_id' => $person_id,
                'image_id' => null,
                'event_type_id' => $eventType->id,
                'date' => new \DateTime($date),
            ],
            [
                'person_id' => $person_id,
                'image_id' => null,
                'event_type_id' => $eventType->id,
                'date' => new \DateTime($date),
                'city_id' => $city->id ?? null,
            ]
        );
    }

    private function updateOrCreateImage(string $path, string $name): Image
    {
        return Image::updateOrCreate(
            ['path' => asset($path)],
            [
                'path' => asset($path),
                'name' => $name,
            ]
        );
    }
}
