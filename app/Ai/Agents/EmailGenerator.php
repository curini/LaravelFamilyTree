<?php

namespace App\Ai\Agents;

use Laravel\Ai\Concerns\RemembersConversations;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Messages\Message;
use Laravel\Ai\Promptable;
use Stringable;

class EmailGenerator implements Agent, Conversational, HasTools
{
    use Promptable, RemembersConversations;

    private string $tone = 'professionnel';

    private function setTone(string $tone): void
    {
        if (!empty($tone)) {
            $this->tone = $tone;
        }
    }

    public function tone(string $tone): self
    {
        $this->setTone($tone);
        return $this;
    }

    /**
     * Get the instructions that the agent should follow.
     */
    public function instructions(): Stringable|string
    {
        return "Tu es responsable de la communication au sein de la société X.
        Pour la rédaction du message tu utilises un ton " . $this->tone . ".
        Tu rédiges des emails professionnels complets et finalisés.
        Tu dois conserver toutes les donnés fournies: noms, prénoms, coordonnées, date.
        Tu ne dois jamais les modifier, ni les corriger, ni les rendre plus formels, ni les interpréter.
        Tu dois choisir la date du jour " . date('d m Y') . " si la date ne t'a pas été donnée.
        Si aucune signature n'existe encore dans la conversation, tu en crées une.
        Une fois créée, elle devient définitive et immuable pour toute la conversation.
        Tu inventes librement toutes les informations manquantes, comme les noms, prénoms, coordonnées, même si elles ne sont pas réalistes.
        Tu n'utilises jamais de crochets, jamais de texte entre [ ] ou < >, jamais de zones à remplir.
        Tu fournis toujours un email entièrement rédigé, sans placeholder, sans mention générique, sans champ vide.";
    }

    /**
     * Get the tools available to the agent.
     *
     * @return Tool[]
     */
    public function tools(): iterable
    {
        return [];
    }
}
