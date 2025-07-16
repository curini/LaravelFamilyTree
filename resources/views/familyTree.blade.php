<x-layouts.app :title="__('Family Tree')">
    <div class="relative overflow-auto scrollable-x" style="width: 1200px; height: 800px;">
        <svg width="8500" height="800" xmlns="http://www.w3.org/2000/svg">
            @foreach ($persons as $person)
                @if ($person->motherPerson)
                    <line
                        x1="{{ $person->position->x + 110 }}" y1="{{ $person->position->y + 32 }}"
                        x2="{{ $person->motherPerson->position->x + 110 }}" y2="{{ $person->motherPerson->position->y + 32 }}"
                        stroke="green" stroke-width="2" />
                @endif
                @if ($person->fatherPerson)
                    <line
                        x1="{{ $person->position->x + 110 }}" y1="{{ $person->position->y + 32 }}"
                        x2="{{ $person->fatherPerson->position->x + 110 }}" y2="{{ $person->fatherPerson->position->y + 32 }}"
                        stroke="green" stroke-width="2" />
                @endif
                @if ($person->spousePerson)
                    <line
                        x1="{{ $person->position->x + 110 }}" y1="{{ $person->position->y + 32 }}"
                        x2="{{ $person->spousePerson->position->x + 110 }}" y2="{{ $person->spousePerson->position->y + 32 }}"
                        stroke="red" stroke-dasharray="15" stroke-width="2" />
                @endif
            @endforeach
            @foreach ($persons as $person)
                <a class="person-link" xlink:href="{{ route('persons.show', $person->id) }}" target="_blank">
                    <g>
                        <rect class="person-bg" x="{{ $person->position->x }}" y="{{ $person->position->y }}" width="220" height="66" rx="8" />
                        <image x="{{ $person->position->x + 10 }}" y="{{ $person->position->y + 8 }}" width="50" height="50" href="{{ $person->portrait->path }}" />
                        <text x="{{ $person->position->x + 70 }}" y="{{ $person->position->y + 25 }}" font-size="12" font-weight="bold">
                            {{ $person->first_name }}
                        </text>
                        <text x="{{ $person->position->x + 70 }}" y="{{ $person->position->y + 45 }}" font-size="12" fill="gray">
                            {{ $person->last_name }}
                        </text>
                    </g>
                </a>
            @endforeach
        </svg>
    </div>
</x-layouts.app>


<script>
document.querySelectorAll('.scrollable-x').forEach(el => {
    el.addEventListener('wheel', function(e) {
        if (e.deltaY !== 0) {
            e.preventDefault();
            el.scrollLeft += e.deltaY;
        }
    });
});
</script>
