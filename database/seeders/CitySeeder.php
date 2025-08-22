<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use App\Models\Department;
use App\Models\Region;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = config('localities.countries', []);
        $regions = config('localities.regions', []);
        $departments = config('localities.departments', []);
        $cities = config('localities.cities', []);

        $this->updateOrCreate(Country::class, $countries);
        $this->updateOrCreate(Region::class, $regions);
        $this->updateOrCreate(Department::class, $departments);
        $this->updateOrCreate(City::class, $cities);
    }

    private function updateOrCreate(string $model, array $values): void
    {
        foreach ($values as $value) {
            $update = [
                'name' => $value['name'],
            ];

            if ($model != City::class) {
                $update = [
                    'name' => $value['name'],
                    'id' => $value['id'],
                ];
            }

            if (isset($value['logo_url'])) {
                $value['logo_url'] = asset($value['logo_url']);
            }

            $model::updateOrCreate($update, $value);
        }
    }
}
