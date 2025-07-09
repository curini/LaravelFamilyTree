<x-layouts.app :title="__('Family Tree')">
    <div class="relative w-[1000px] h-[800px] border border-gray-300 overflow-auto">
        @foreach ($persons as $person)
            <a href="{{ route('persons.show', $person->id) }}">
            <div
                class="absolute w-[220px] h-16 p-2 bg-white rounded shadow text-center border border-blue-500 text-xs"
                style="left: {{ $person->position->x }}px; top: {{ $person->position->y }}px;"
            >
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <img src="{{ $person->portrait->path }}" alt="" style="width: 50px;height: 50px">
                    </div>
                    <div>
                        <strong class="my-text-ellipsis">
                            {{ $person->first_name }}
                        </strong>
                        <span class="text-gray-500 my-text-ellipsis">
                            {{ $person->last_name }}
                        </span>
                    </div>
                </div>
            </div>
            </a>
        @endforeach
    </div>
</x-layouts.app>
