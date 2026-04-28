<?php

namespace App\Console\Commands;

use App\EventTypesEnum;
use App\Models\Event;
use App\Services\PersonService;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

#[Signature('ft:export:stats')]
#[Description('Permet de créer un fichier TypeScript contenant toutes les stats.')]
class ExportStats extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Start of the export for stats');

        $person = new PersonService();
        $event = Event::join('cities', 'events.city_id', '=', 'cities.id')
            ->join('event_types', 'events.event_type_id', '=', 'event_types.id')
            ->whereIn('event_types.name', [EventTypesEnum::DEATH, EventTypesEnum::BIRTH])
            ->groupBy('cities.latitude', 'cities.longitude')
            ->select('cities.latitude', 'cities.longitude', DB::raw('COUNT(*) as total'))
            ->get();

        $stats = [
            'person' => $person->getPersonsStats(),
            'markers' => $event,
        ];

        if (empty($stats['person']) || empty($stats['markers'])) {
            $this->fail('There is no stats in database!');
        }
        Storage::disk('local')->put('my-stats.ts', 'export const myStats = ' . json_encode($stats));
        $this->info('End of the export');
    }
}
