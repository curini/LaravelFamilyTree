<x-layouts.app :title="__('Persons')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <h1>{{ __('Persons list') }}</h1>
        <form class="mb-4" method="GET" action="{{ route('persons.index') }}">
            @csrf
            <div class="flex gap-4">
                <input class="input w-full border border-zinc-200" type="text" name="search">
                <button class="bg-blue-500 hover:bg-zinc-700 text-white font-bold py-2 px-4" type="submit">Search</button>
            </div>
        </form>

        <table class="table w-full mt-4">
            <thead>    
                <tr class="text-left text-sm">                    
                    <th>
                        <a href="{{ route('persons.index', ['sort' => 'name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                            Name
                        </a>
                    </th>
                    <th>
                        <a href="{{ route('persons.index', ['sort' => 'age', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                            Age
                        </a>
                    </th>
                    <th>
                        <a href="{{ route('persons.index', ['sort' => 'birth', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                            Birth
                        </a>
                    </th>
                    <th>
                        <a href="{{ route('persons.index', ['sort' => 'death', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                        Death
                        </a>
                    </th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $person)
                    <tr class="text-sm">
                        <td>{{ $person->name }}</td>
                        <td>{{ $person->age }}</td>
                        <td>{{ $person->birth ? $person->birth->format('d F Y') : '' }}</td>
                        <td>{{ $person->death  ? $person->death->format('d F Y') : '' }}</td>
                        <td class="text-center py-2">
                            <flux:link class="hover:!bg-blue-500 me-2 rounded" :href="route('persons.show', $person->id)" wire:navigate>{{ __('Show') }}</flux:link>
                            <flux:link class="hover:!bg-blue-500 me-2 rounded" :href="route('persons.edit', $person->id)" wire:navigate>{{ __('Edit') }}</flux:link>                            
                            <!-- 
                            <flux:link class="bg-red-500 hover:bg-red-600 ms-2 rounded py-1 px-2" :href="route('persons.destroy', $person->id)" wire:navigate>{{ __('Delete') }}</flux:link>
                            -->
                        </td>   
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $data->links() }}
</x-layouts.app>
