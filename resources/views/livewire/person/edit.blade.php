<x-layouts.app :title="__($title)">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <h1 class="text-3xl font-bold">{{ __($title) }}</h1>
        <form class="mb-4" method="POST" action="{{ isset($person->id) ? route('persons.update', $person) : route('persons.store', $person) }}">
            @csrf
            @method('PUT')
            <div class="flex gap-4 mt-4 p-4">
                <label for="first_name">
                    {{ __('First name') }}
                </label>
                <input class="input w-full border border-zinc-200" type="text" name="first_name" value="{{ $person->first_name }}">
            </div>
            <div class="flex gap-4 mt-4 p-4">
                <label for="last_name">
                    {{ __('Last name') }}
                </label>
                <input class="input w-full border border-zinc-200" type="text" name="last_name" value="{{ $person->last_name }}">
            </div>
            <div class="flex gap-4 mt-4 p-4">
                <label for="father">
                    {{ __('Father') }}
                </label>
                <select class="input w-full border border-zinc-200" name="father">
                    <option value="">{{ __('None') }}</option>
                    @foreach ($fathers as $id => $name)
                        <option value="{{ $id }}" @if (isset($person->father_id) && $person->father_id == $id) selected @endif>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-4 mt-4 p-4">
                <label for="mother">
                    {{ __('Mother') }}
                </label>
                <select class="input w-full border border-zinc-200" name="mother">
                    <option value="">{{ __('None') }}</option>
                    @foreach ($mothers as $id => $name)
                        <option value="{{ $id }}" @if ( isset($person->mother_id) && $person->mother_id == $id) selected @endif>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-4 mt-4 p-4">
                <label for="gender">
                    {{ __('Gender') }}
                </label>
                <select class="input w-full border border-zinc-200" name="gender">
                    <option value="M" @if ($person->gender == 'M') selected @endif>{{ __('Male') }}</option>
                    <option value="F" @if ($person->gender == 'F') selected @endif>{{ __('Female') }}</option>
                </select>
            </div>
            <div class="flex gap-4 mt-4 p-4">
                <label for="job">
                    {{ __('Job') }}
                </label>
                <input class="input w-full border border-zinc-200" type="text" name="job" value="{{ $person->job }}">
            </div>

            @if ($person->has('events'))
                @foreach ($person->events as $event)
                    <livewire:events.update-event :event="$event"
                    :cities="$cities" :eventTypes="$eventTypes" />
                @endforeach
            @endif

            <div class="flex gap-4 mt-4 p-4">
                <label for="spouse">
                    {{ __('Spouse') }}
                </label>
                <select class="input w-full border border-zinc-200" name="spouse">
                    <option value="">{{ __('None') }}</option>
                    @foreach ($spouses as $id => $name)
                        <option value="{{ $id }}" @if (isset($person->spouse_id) && $person->spouse_id == $id) selected @endif>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
            </div>

            @if ($person->portrait)
                <div class="flex gap-4 mt-4 p-4">
                    <label for="portrait.path">
                        {{ __('Photo') }}
                    </label>
                    <input class="input w-full border border-zinc-200" type="text" name="portrait.path" value="{{ $person->portrait->path }}">
                </div>
            @endif

            <div class="flex gap-4 mt-4 p-4">
                <label for="age">
                    {{ __('Age') }}
                </label>
                <input class="input w-full border border-zinc-200" type="number" name="age" value="{{ $person->age }}">
            </div>

            <div class="mt-4 p-4">
                <button class="bg-blue-500 hover:bg-zinc-700 text-white font-bold py-2 px-4 rounded" type="submit">
                    {{ __('Save') }}
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>
