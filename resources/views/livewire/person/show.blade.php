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
                </div>
            @endisset
            <div class="p-4 flex-1">
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

                @if($person->birth() !== null)
                    <p>
                        {{ __('Birthday:') }}
                        {{ $person->birth()->format('d F Y') }}
                        {{ $person->birthplace ? ' to ' . $person->birthplace . '' : '' }}
                        {{ $person->birthcountry_name ? ' (' . $countries[$person->birthcountry] . ')' : '' }}
                    </p>
                @endif

                @if($person->death())
                    <p>
                        {{ __('Deathday:') }}
                        {{ $person->death()->format('d F Y') }}
                        {{ $person->deathplace ? ' to ' . $person->deathplace . '' : '' }}
                        {{ $person->deathcountry_name ? '(' . $countries[$person->deathcountry] . ')' : '' }}
                    </p>
                @endif

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
        </div>

        @if(!empty($slides))
        <!--  Carousel of my images -->
        <div class="relative w-full h-64 overflow-hidden"
            x-data="{ currentSlide: 0, slides: {{ json_encode($slides) }} }">

            <!-- Slides -->
            <div
                class="flex transition-transform duration-500 ease-in-out h-full"
                :style="'transform: translateX(-' + (currentSlide * 100) + '%)'"
            >
                <template x-for="(slide, index) in slides" :key="index">
                    <div class="w-full flex-shrink-0">
                        <img :src="slide" :alt="'Slide ' + (index + 1)" class="w-full h-64 object-cover" />
                    </div>
                </template>
            </div>

            <!-- Bouton gauche -->
            <button
                style="margin-top: calc(var(--spacing)* (-28));"
                class="absolute text-black p-2 rounded-full z-10"
                @click="currentSlide = (currentSlide === 0) ? slides.length - 1 : currentSlide - 1"
            >
                &#10094;
            </button>

            <!-- Bouton droit -->
            <button
                style="margin-top: calc(var(--spacing)*(-28));right: 0"
                class="absolute text-black p-2 rounded-full z-10"
                @click="currentSlide = (currentSlide === slides.length - 1) ? 0 : currentSlide + 1"
            >
                &#10095;
            </button>
        </div>
        @endif
    </div>
</x-layouts.app>
