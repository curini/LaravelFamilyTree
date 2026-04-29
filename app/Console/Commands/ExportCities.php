<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Models\City;
use Illuminate\Support\Facades\Storage;

#[Signature('ft:export:cities')]
#[Description('Permet de créer un fichier TypeScript contenant toutes les villes.')]
class ExportCities extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Start of the export for cities');
        $cities = City::with(['department' => function ($query) {
            $query->with(['region' => function ($query) {
                $query->with('country:id,name')->select('id', 'name', 'country_id');
            }])->select('id', 'name', 'region_id');
        }])->select('id', 'name', 'department_id')->get();

        if (empty($cities)) {
            $this->fail('There is no city in database!');
        }
        Storage::disk('local')->put('my-cities.ts', 'export const myCities = ' . json_encode($cities));
        $this->info('End of the export');
    }
}
