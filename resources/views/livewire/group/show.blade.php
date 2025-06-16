<x-layouts.app :title="__('Groups')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <h1>
                {{ __('See group') }} 
                <a href="{{ route('groups.edit', $group->id) }}" class="text-sm cursor-pointer rounded" wire:navigate>
                    {{ __('Edit') }}
                </a>
            </h1>
            <div class="p-4">
                @foreach ($group->persons as $key => $person)
                    @if ($key > 0) - @endif
                    <flux:link href="{{ route('persons.show', $person->id) }}" wire:navigate>
                        {{ $person->name }}
                    </flux:link>
                @endforeach
            </div>
            <div class="p-4">
                <p>
                    @isset($group->wedding_act) 
                        <img src="{{ $group->wedding_act }}" alt="" class="unded" /> 
                    @endisset
                </p>
            </div>
        </div>
    </div>
</x-layouts.app>
