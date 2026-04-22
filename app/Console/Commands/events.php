<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Support\Facades\Storage;

#[Signature('ft:events:export')]
#[Description('Permet de créer un fichier TypeScript contenant tous les évènements.')]
class events extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Start export events');
        $events = Event::all();
        if (empty($events)) {
            $this->fail('There is no events in database!');
        }
        Storage::disk('local')->put('my-events.ts', 'export const myEvents = ' . json_encode($events));
        $this->info('End export events');
    }
}
