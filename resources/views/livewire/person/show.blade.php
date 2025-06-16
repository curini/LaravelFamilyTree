<x-layouts.app :title="__('See person')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <h1 class="text-2xl font-bold">
            {{ $person->name ?? '' }} 
            <a href="{{ route('persons.edit', $person->id) }}" class="text-sm cursor-pointer rounded" wire:navigate>{{ __('Edit') }}</a>
        </h1>
        <div class="flex h-full w-full space-x-4">
            <div class="p-4 flex-1">
                @isset($person->photo)
                    <img src="{{ $person->photo ?? '' }}" alt="" class="[:where(&)]:w-64" />
                @endisset
            </div>
            <div class="p-4 flex-1">
                <p>{{ __('Gender:') }}
                    {{ $person->gender == 'M' ? __('Male') : __('Female') }}
                </p>

                <p>
                    {{ __('Age:')}}
                    {{ $person->age ?? '' }}
                    {{ __('years') }}
                </p>

                <p>{{ __('Job:') }} {{ $person->job ?? ''}}</p>

                <p>
                    {{ __('Mother:') }} 
                    @isset($person->motherPerson)    
                        <flux:link href="{{ route('persons.show', $person->motherPerson['id']) }}" wire:navigate>
                            {{ $person->motherPerson['name'] }}
                        </flux:link>
                    @endisset
                </p>
                <p>
                    {{ __('Father:') }}
                    @isset($person->fatherPerson)
                        <flux:link href="{{ route('persons.show', $person->fatherPerson['id']) }}" wire:navigate>
                            {{ $person->fatherPerson['name'] }}   
                        </flux:link>
                    @endisset
                </p>
                
                <p>
                    {{ __('Birthday:') }} 
                    {{ $person->birth ? $person->birth->format('d F Y') : '' }}
                    {{ $person->birthplace ? ' to ' . $person->birthplace . '' : '' }}
                    {{ $person->birthcountry_name ? ' (' . $countries[$person->birthcountry] . ')' : '' }}
                </p>
                
                <p>
                    {{ __('Deathday:') }} {{ $person->death ? $person->death->format('d F Y') : '' }}
                    {{ $person->deathplace ? ' to ' . $person->deathplace . '' : '' }}
                    {{ $person->deathcountry_name ? '(' . $countries[$person->deathcountry] . ')' : '' }}
                </p>

                <p>
                    {{ __('Spouse:') }} 
                    @isset($person->spousePerson)
                        <flux:link href="{{ route('persons.show', $person->spousePerson['id']) }}" wire:navigate>
                            {{ $person->spousePerson['name'] }}
                        </flux:link>
                    @endisset
                </p>

                <p>
                    @if($person->group) 
                    {{ __('Group:') }} 
                    <flux:link href="{{ route('groups.show', $person->group) }}" wire:navigate>
                        {{ $person->group }}
                    </flux:link>
                    @endif
                </p>

                <p>{{ __('Children:') }}
                    @isset($person->childrenAsMother)
                        @foreach ($person->childrenAsMother as $key => $child)
                            @if ($key > 0) {{ ', ' }} @endif
                            <flux:link href="{{ route('persons.show', $child['id']) }}" wire:navigate>
                                {{ $child['name'] }}
                            </flux:link>
                        @endforeach
                    @endisset
                    @isset($person->childrenAsFather)
                        @foreach ($person->childrenAsFather as $key => $child)
                            @if ($key > 0) {{ ', ' }} @endif
                            <flux:link href="{{ route('persons.show', $child['id']) }}" wire:navigate>
                                {{ $child['name'] }}
                            </flux:link>
                        @endforeach
                    @endisset
                </p>
            </div>
        </div>
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

    </div>
</x-layouts.app>
