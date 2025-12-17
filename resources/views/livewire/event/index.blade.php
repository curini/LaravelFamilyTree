<x-layouts.app :title="__('Events')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <h1 class="text-2xl font-bold">{{ __('Events list') }}</h1>
        <div class="overflow-x-auto w-full">

            @foreach ($events as $event)
                <div class="relative pl-6 border-l-4 border-zinc-300 pb-4">
                    <div class="date-marker"></div>

                    <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
                        <flux:link href="{{ route('events.show', $event->id) }}" variant="subtle" wire:navigate>
                            @if (!empty($event->image->path))
                                <img src="{{ $event->image->path }}"
                                    alt="Event image"
                                    class="w-full h-48 object-cover" />
                            @endif

                            <div class="p-4 text-sm space-y-2">
                                <div class="flex items-center justify-between text-gray-600">
                                    <span>{{ $event->date->format('d M Y') }}</span>
                                    <span class="px-2 py-1 bg-zinc-400/15 text-zinc-800 text-xs rounded">
                                        {{ $event->eventType->name ?? 'Type inconnu' }}
                                    </span>
                                </div>
                                <h2 class="font-semibold text-lg text-gray-800 truncate">
                                    {{ $event->title ?? $event->eventType->name ?? 'Nom de l’évènement' }}
                                </h2>
                                @php
                                    $city = $event->city;
                                    $department = $city->department ?? null;
                                    $region = $department->region ?? null;
                                    $country = $region->country ?? null;
                                @endphp

                                <p class="text-gray-600">
                                    📍 {{ $city->name ?? 'Ville inconnue' }}
                                    @if($department)
                                        - {{ $department->name }}
                                    @endif
                                    @if($region)
                                        - {{ $region->name }}
                                    @endif
                                    @if($country)
                                        ({{ $country->name }})
                                    @endif
                                </p>
                            </div>
                        </flux:link>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-6">
            {{ $events->links() }}
        </div>
    </div>
</x-layouts.app>
