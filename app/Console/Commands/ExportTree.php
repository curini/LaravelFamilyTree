<?php

namespace App\Console\Commands;

use App\Http\Resources\familyTreeResource;
use App\Services\PersonService;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

#[Signature('ft:export:tree')]
#[Description('Permet de créer un fichier TypeScript contenant les données pour la réalisation de l\'arbre.')]
class ExportTree extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Start of the export for tree');

        $person = new PersonService();
        $people = $person->getPersons();
        $families = familyTreeResource::collection(
            $people->map(function ($p) {
                if ($p->father_id === 44) {
                    $p->father_id = null;
                } else if ($p->id === 44) {
                    $p->first_name = 'Jean-Claude';
                    $p->spouse_id = null;
                } elseif ($p->spouse_id === 44) {
                    $p->spouse_id = null;
                }
                return $p;
            })
        );

        if (empty($families)) {
            $this->fail('There is no data in database!');
        }
        Storage::disk('local')->put('my-tree.ts', 'export const myTree = ' . json_encode($families));
        $this->info('End of the export');
    }
}
