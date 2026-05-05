<?php

namespace Database\Seeders;

use App\EventsEnum;
use App\Models\Gender;
use App\Models\Image;
use Illuminate\Database\Seeder;
use App\Models\Person;

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
        $spouses = [];

        foreach ($data as $key => $value) {
            $gender = Gender::where(['value' => $value['gender'] ?? 'M'])->firstOrFail();
            $image = isset($value['photo']) ? $this->updateOrCreateImage($value['photo'], 'portrait') : null;

            $this->setImages($value);

            $name = $this->setNames($value['name']);

            $default_image = isset($value['gender']) && $value['gender'] == 'F' ? $img_woman : $img_man;

            $person = Person::updateOrCreate(
                [
                    'id' => $value['key'],
                    'first_names' => $name['first_names'],
                    'last_name' => $name['last_name'],
                ],
                [
                    'first_name' => $name['first_name'],
                    'first_names' => $name['first_names'],
                    'last_name' => $name['last_name'],
                    'job' => $value['job'] ?? null,
                    'description' => $value['description'] ?? null,
                    'gender_id' => $gender->id,
                    'father_id' => $value['father'] ?? null,
                    'mother_id' => $value['mother'] ?? null,
                    'spouse_id' => $value['spouse'] ?? null,
                    'image_id' => isset($image) ? $image->id : $default_image->id,
                    'is_dead' => data_get($value, 'is_dead', 0)
                ]
            );

            $spouses[$value['key']] = ['model' => $person, 'oldspouse' => $value['oldspouse'] ?? []];
        }

        foreach ($spouses as $spouse) {
            $this->saveSpouses($spouse['model'], $spouse['oldspouse']);
        }
    }

    private function saveSpouses(Person $person, array $value): void
    {
        $person->oldSpouses()->sync($value);
    }

    private function setImages(array $value): void
    {
        $types = EventsEnum::cases();
        foreach ($types as $type) {
            if (isset($value[$type->name . '_img'])) {
                $this->updateOrCreateImage($value[$type->name . '_img'], $type->value);
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
        return [
            'first_name' => explode(' ', trim($name))[0],
            'first_names' => trim($name),
            'last_name' => trim($lastname),
        ];
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
