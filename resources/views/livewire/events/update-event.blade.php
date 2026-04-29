<div class="bg-neutral-100 p-4 mt-4">
    <h2>{{ __('Event') }}</h2>
    <div class="flex gap-4 mt-4">
        <label>
            {{ __('Date') }}
        </label>
        <input class="input w-full border border-zinc-200" type="date" wire:model="date">
    </div>
    <div class="flex gap-4 mt-4">
        <label>
            {{ __('City') }}
        </label>
        <select class="input w-full border border-zinc-200" wire:model="city_id">
            <option value="">{{ __('None') }}</option>
            @foreach($cities as $code => $city)
                <option value="{{ $code }}">
                    {{ $city->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="flex gap-4 mt-4">
        <label>
            {{ __('Description') }}
        </label>
        <input class="input w-full border border-zinc-200" type="text" wire:model="description">
    </div>
    <div class="flex gap-4 mt-4">
        <label>
            {{ __('Event type') }}
        </label>
        <select class="input w-full border border-zinc-200" wire:model="event_type_id">
            @foreach($eventTypes as $type => $eventType)
                <option value="{{ $eventType->id }}">
                    {{ $eventType->name }}
                </option>
            @endforeach
        </select>
    </div>
    <button
    class="bg-green-500 hover:bg-zinc-700 text-white font-bold py-2 px-4 rounded"
    type="button"
    wire:click="update({{ $event->id }})"
    >
        {{ __('Save event') }}
    </button>
    <button
    class="bg-red-500 hover:bg-zinc-700 text-white font-bold py-2 px-4 rounded"
    type="button"
    wire:click="delete({{ $event->id }})"
    wire:confirm="Are you sure you want to delete this event?"
    >
        {{ __('Delete event') }}
    </button>
</div>
