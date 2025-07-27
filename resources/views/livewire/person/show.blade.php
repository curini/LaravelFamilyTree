<x-layouts.app :title="__('See person')">
    <div class="container mx-auto p-6">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">{{ $person->getName() }}</h1>
            <a href="{{ route('persons.edit', $person->id) }}" class="text-blue-600 hover:underline text-sm" wire:navigate>{{ __('Edit') }}</a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="space-y-6">
                @isset($person->portrait)
                    <div class="[:where(&)]:w-64 bg-gray-100 overflow-hidden">
                        <img src="{{ $person->portrait->path }}" alt="Portrait" class="w-full h-full object-cover"/>
                    </div>
                @endisset

                <div class="p-6 space-y-4">
                    <h3 class="text-xl font-semibold">{{ __('Personal Information') }}</h3>

                    @isset($person->gender)
                        <p><strong>{{ __('Gender:') }}</strong> {{ $person->gender->name }}</p>
                    @endisset

                    @isset($person->age)
                        <p><strong>{{ __('Age:') }}</strong> {{ $person->age }} {{ __('years') }}</p>
                    @endisset

                    @isset($person->job)
                        <p><strong>{{ __('Job:') }}</strong> {{ $person->job }}</p>
                    @endisset

                    @isset($person->description)
                        <p><strong>{{ __('Description:') }}</strong> <span style="white-space: pre-wrap">{{ $person->description }}</span></p>
                    @endisset
                </div>

                <div class="p-6 space-y-4">
                    <h3 class="text-xl font-semibold">{{ __('Family & Group') }}</h3>

                    @isset($person->motherPerson)
                        <p><strong>{{ __('Mother:') }}</strong>
                            <flux:link href="{{ route('persons.show', $person->motherPerson->id) }}" wire:navigate>{{ $person->motherPerson->getName() }}</flux:link>
                        </p>
                    @endisset

                    @isset($person->fatherPerson)
                        <p><strong>{{ __('Father:') }}</strong>
                            <flux:link href="{{ route('persons.show', $person->fatherPerson->id) }}" wire:navigate>{{ $person->fatherPerson->getName() }}</flux:link>
                        </p>
                    @endisset

                    @isset($person->spousePerson)
                        <p><strong>{{ __('Spouse:') }}</strong>
                            <flux:link href="{{ route('persons.show', $person->spousePerson->id) }}" wire:navigate>{{ $person->spousePerson->getName() }}</flux:link>
                        </p>
                    @endisset

                    @if($person->group)
                        <p><strong>{{ __('Group:') }}</strong>
                            <flux:link href="{{ route('groups.show', $person->group) }}" wire:navigate>{{ $person->group->id }}</flux:link>
                        </p>
                    @endif

                    @php
                        $children = $person->childrenAsMother->merge($person->childrenAsFather);
                    @endphp
                    @if($children->isNotEmpty())
                        <p><strong>{{ __('Children:') }}</strong>
                            @foreach ($children as $key => $child)
                                @if ($key > 0), @endif
                                <flux:link href="{{ route('persons.show', $child->id) }}" wire:navigate>{{ $child->getName() }}</flux:link>
                            @endforeach
                        </p>
                    @endif
                </div>
            </div>


            <div class="space-y-6">
                <div class="flex-1 relative pl-6 border-l-4 border-zinc-300 space-y-8">
                    @foreach($person->events as $event)
                        <div class="relative">

                            <div class="date-marker"></div>

                            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
                                <flux:link href="{{ route('events.show', $event->id) }}" wire:navigate>
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
            </div>
        </div>
    </div>
</x-layouts.app>
