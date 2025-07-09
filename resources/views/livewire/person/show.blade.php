<x-layouts.app :title="__('See person')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <h1 class="text-2xl font-bold">
            {{ $person->getName() }}
            <a href="{{ route('persons.edit', $person->id) }}" class="text-sm cursor-pointer rounded" wire:navigate>{{ __('Edit') }}</a>
        </h1>
        <div class="flex h-full w-full space-x-4">
            @isset($person->portrait)
                <div class="p-4 flex-1">
                    <img src="{{ $person->portrait->path }}" alt="" class="[:where(&)]:w-64" />
                    @isset($person->gender)
                        <p>
                            {{ __('Gender:') }}
                            {{ $person->gender->name }}
                        </p>
                    @endisset

                    @isset($person->age)
                        <p>
                            {{ __('Age:')}}
                            {{ $person->age }}
                            {{ __('years') }}
                        </p>
                    @endisset

                    @isset($person->job)
                        <p>
                            {{ __('Job:') }}
                            {{ $person->job }}
                        </p>
                    @endisset

                    @isset($person->motherPerson)
                        <p>
                            {{ __('Mother:') }}
                            <flux:link href="{{ route('persons.show', $person->motherPerson->id) }}" wire:navigate>
                                {{ $person->motherPerson->getName() }}
                            </flux:link>
                        </p>
                    @endisset

                    @isset($person->fatherPerson)
                        <p>
                            {{ __('Father:') }}
                            <flux:link href="{{ route('persons.show', $person->fatherPerson->id) }}"
                                wire:navigate>
                                {{ $person->fatherPerson->getName() }}
                            </flux:link>
                        </p>
                    @endisset

                    @isset($person->spousePerson->name)
                        <p>
                            {{ __('Spouse:') }}
                            <flux:link href="{{ route('persons.show', $person->spousePerson->id) }}"
                                wire:navigate>
                                {{ $person->spousePerson->getName() }}
                            </flux:link>
                        </p>
                    @endisset

                    @if($person->group)
                        <p>
                            {{ __('Group:') }}
                            <flux:link href="{{ route('groups.show', $person->group) }}"
                                wire:navigate>
                                {{ $person->group->id }}
                            </flux:link>
                        </p>
                    @endif

                    @isset($person->childrenAsMother[0])
                        <p>
                            {{ __('Children:') }}
                            @foreach ($person->childrenAsMother as $key => $child)
                                @if ($key > 0) {{ ', ' }} @endif
                                <flux:link href="{{ route('persons.show', $child->id) }}" wire:navigate>
                                    {{ $child->getName() }}
                                </flux:link>
                            @endforeach
                        </p>
                    @endisset
                    @isset($person->childrenAsFather[0])
                        <p>
                            {{ __('Children:') }}
                            @foreach ($person->childrenAsFather as $key => $child)
                                @if ($key > 0) {{ ', ' }} @endif
                                <flux:link href="{{ route('persons.show', $child->id) }}" wire:navigate>
                                    {{ $child->getName()  }}
                                </flux:link>
                            @endforeach
                        </p>
                @endisset
                </div>
            @endisset
            <div class="flex-1 relative pl-6 border-l-4 border-blue-500 space-y-8">
                @foreach($person->events as $event)
                    <div class="relative">
                        {{-- Point sur le fil --}}
                        <div class="absolute -left-3 top-2 w-6 h-6 bg-white border-2 border-blue-500 rounded-full"></div>

                        {{-- Carte événement --}}
                        <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
                            @if (!empty($event->image->path))
                                <img src="{{ $event->image->path }}"
                                    alt="Event image"
                                    class="w-full h-48 object-cover" />
                            @endif

                            <div class="p-4 text-sm space-y-2">
                                <div class="flex items-center justify-between text-gray-600">
                                    <span>{{ $event->date->format('d M Y') }}</span>
                                    <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded">
                                        {{ $event->eventType->name ?? 'Type inconnu' }}
                                    </span>
                                </div>
                                <h2 class="font-semibold text-lg text-gray-800 truncate">
                                    {{ $event->title ?? $event->eventType->name ?? 'Nom de l’évènement' }}
                                </h2>
                                <p class="text-gray-600">📍 {{ $event->city->name ?? 'Ville inconnue' }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-layouts.app>
