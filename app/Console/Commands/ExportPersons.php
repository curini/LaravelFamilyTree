<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Person;
use Illuminate\Support\Facades\Storage;


class ExportPersons extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ft:export:persons';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Permet de créer un fichier TypeScript contenant toutes les personnes.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Start of the export for persons');
        $persons = $this->getPersons();
        if (empty($persons)) {
            $this->fail('There is no persons in database!');
        }
        Storage::disk('local')->put('my-persons.ts', 'export const myPersons = ' . json_encode($persons));
        $this->info('End of the export');
    }

    private function getPersons(): array
    {
        return Person::with([
            'motherPerson:id,first_name,last_name',
            'fatherPerson:id,first_name,last_name',
            'spousePerson:id,first_name,last_name',
            'childrenAsMother:id,first_name,last_name,mother_id',
            'childrenAsFather:id,first_name,last_name,father_id',
            'brothers',
            'events' => function ($query) {
                $query->select('id', 'person_id', 'date')
                    ->orderBy('date', 'asc');
            },
        ])
            ->select(
                'id',
                'first_name',
                'first_names',
                'last_name',
                'job',
                'description',
                'age',
                'gender_id',
                'image_id',
                'mother_id',
                'father_id',
                'spouse_id'
            )->get()->each(function ($item) {
                $item->setRelation(
                    'brothers',
                    $item->brothers->where('id', '!=', $item->id)->values()
                );
            })->toArray();
    }
}
