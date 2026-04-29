<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('ft:export')]
#[Description('Permet de lancer tous les exports.')]
class Export extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('ft:export:persons');
        $this->call('ft:export:cities');
        $this->call('ft:export:images');
        $this->call('ft:export:stats');
        $this->call('ft:export:events');
        $this->call('ft:export:tree');
    }
}
