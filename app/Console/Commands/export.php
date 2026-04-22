<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('ft:all:export')]
#[Description('Permet de lancer tous les exports.')]
class export extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('ft:persons:export');
        $this->call('ft:cities:export');
        $this->call('ft:images:export');
        $this->call('ft:stats:export');
        $this->call('ft:tree:export');
    }
}
