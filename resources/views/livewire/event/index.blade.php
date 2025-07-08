<x-layouts.app :title="__('Events')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <h1 class="text-2xl font-bold">{{ __('Events list') }}</h1>
        <div class="overflow-x-auto w-full">
            <table class="table-auto w-full text-sm border border-gray-200">
                <thead class="bg-gray-100 text-gray-700 uppercase tracking-wide">
                    <tr>
                        <th class="p-3 text-left">
                            <a href="{{ route('events.index', ['sort' => 'id', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                {{ __('Id') }}
                            </a>
                        </th>
                        <th class="p-3 text-left">
                            <a href="{{ route('events.index', ['sort' => 'event_type_id', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                {{ __('Type') }}
                            </a>
                        </th>
                        <th class="p-3 text-left">
                            <a href="{{ route('events.index', ['sort' => 'date', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                {{ __('Date') }}
                            </a>
                        </th>
                        <th class="p-3 text-left">
                            <a href="{{ route('events.index', ['sort' => 'city_id', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                {{ __('Ville') }}
                            </a>
                        </th>
                        <th class="p-3 text-center">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($events as $event)
                        <tr class="hover:bg-gray-50 border-t">
                            <td>{{ $event->id }}</td>
                            <td>{{ $event->event_type_id }}</td>
                            <td>{{ $event->date->format('d F Y') }}</td>
                            <td>{{ $event->city_id }}</td>
                            <td class="text-center py-2">
                                <flux:link :href="route('events.show', $event->id)" class="text-blue-600 hover:underline mr-3">{{ __('See') }}</flux:link>
                                <flux:link :href="route('events.edit', $event->id)" class="text-green-600 hover:underline mr-3">{{ __('Edit') }}</flux:link>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            {{ $events->links() }}
        </div>
    </div>
</x-layouts.app>
