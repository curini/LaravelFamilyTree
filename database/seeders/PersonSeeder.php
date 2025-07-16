<?php

namespace Database\Seeders;

use App\Models\Gender;
use App\Models\Image;
use Illuminate\Database\Seeder;
use App\Models\Person;
use App\Models\Position;

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

            $this->setImages($value);

            $name = $this->setNames($value['name']);
            $y = ($value['generation'] - $start) * 75 + 40;
            $position = $this->setPosition($value['x'] ?? $positions[$value['generation']], $y);
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
        }
    }

    private function setImages(array $value): void
    {
        $types = [
            'birth_img' => 'birth',
            'death_img' => 'death',
            'house_img' => 'house',
            'oldhouse_img' => 'house',
            'wedding_img' => 'wedding',
            'otherwedding_img' => 'wedding',
            'papers_img' => 'papers',
            'otherpapers_img' => 'papers',
            'deathchild_img' => 'death',
            'military_img' => 'military',
        ];
        foreach ($types as $key => $type) {
            if (isset($value[$key])) {
                $this->updateOrCreateImage($value[$key], $type);
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
