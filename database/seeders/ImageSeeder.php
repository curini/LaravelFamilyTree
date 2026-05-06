<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\Image;
use App\EventsEnum;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = array_filter(json_decode(config('persons.data', []), true), function ($value) {
            return isset($value, $value['key'], $value['name']);
        });

        foreach ($data as $key => $value) {
            $this->setImages($value);
        }
    }

    protected function setImages(array $value): void
    {
        $types = EventsEnum::cases();
        foreach ($types as $type) {
            if (isset($value[$type->name . '_img'])) {
                $this->updateOrCreateImage($value[$type->name . '_img'], $type->value);
            }
        }
    }

    protected function updateOrCreateImage(string $path, string $name): Image
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
