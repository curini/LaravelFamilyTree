<?php

namespace App\Console\Commands;

use App\Ai\Agents\EmailGenerator;
use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('ft:make:email {subject} {tone?}')]
#[Description('Commande permettant de retourner le contenu d\'un email professionnel basé sur un {sujet} et un {ton} choisi. Par défaut, le ton choisi est professionnel.')]
class MakeEmail extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sujet = $this->argument('subject');
        $tone = $this->argument('tone') ?? '';
        $user = User::where('email', config('app.default_user.email'))->firstOrFail();
        $response = (new EmailGenerator())->tone($tone)->continueLastConversation($user)->prompt($sujet);
        $this->info((string)$response);
    }
}
