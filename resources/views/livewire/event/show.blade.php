<x-layouts.app :title="__('Events')">
    <div class="container mx-auto p-6">
        @if ($event->eventType)
            <h1 class="text-2xl font-semibold mb-6">
                {{ $event->eventType->name }}
            </h1>
        @endif
         <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            @if ($event->image)
               <div class="space-y-6">
                    <img src="{{ $event->image->path }}" alt="">
                </div>
            @endif
            @if ($event->date)
                <div class="space-y-6">
                    <p>
                        {{ $event->date->format('l d F Y') }}
                        @if ($event->city)
                            {{ ' to ' . $event->city->name }}
                        @endif
                    </p>
                    @if ($event->person)
                        <p>
                            @if ($event->person instanceof \Illuminate\Support\Collection)
                                {{ 'Persons: ' }}
                                @foreach ($event->person as $person)
                                    <flux:link href="{{ route('persons.show', $person) }}" wire:navigate>
                                        {{ $person->getName() }}
                                    </flux:link>
                                @endforeach
                            @else
                                Person:
                                <flux:link href="{{ route('persons.show', $event->person) }}" wire:navigate>
                                    {{ $event->person->getName() }}
                                </flux:link>
                            @endif
                        </p>
                    @endif
                </div>
            @endif
         </div>
    </div>
</x-layouts.app>
