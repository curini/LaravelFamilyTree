<?php

namespace App\Livewire\Events;

use Livewire\Component;
use App\Models\Event;
use Illuminate\Support\Facades\Log;

class UpdateEvent extends Component
{
    public Event $event;
    public $cities;
    public $eventTypes;

    public $event_type_id;
    public $description;
    public $city_id;
    public $date;
    public $id;

    protected $casts = [
        'date' => 'date:Y-m-d',
    ];

    public function mount()
    {
        $this->event_type_id = $this->event->event_type_id;
        $this->date = $this->event->date->format('Y-m-d');
        $this->description = $this->event->description;
        $this->city_id = $this->event->city_id;
    }

    public function update(int $id)
    {
        $event = Event::findOrFail($id);
        $event->update([
            'event_type_id' => $this->event_type_id,
            'date' => $this->date,
            'description' => $this->description,
            'city_id' => $this->city_id,
        ]);
    }

    public function delete(int $id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
    }

    public function render()
    {
        return view('livewire.events.update-event');
    }
}
