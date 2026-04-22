<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

#[Signature('ft:images:export')]
#[Description('Permet de créer un fichier TypeScript contenant toutes les images.')]
class images extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Start of the export for images');
        $images = Image::all()->toResourceCollection();
        if (empty($images)) {
            $this->fail('There is no image in database!');
        }
        Storage::disk('local')->put('my-images.ts', 'export const myImages = ' . json_encode($images));
        $this->info('End of the export');
    }
}
