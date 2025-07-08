<x-layouts.app :title="__('Persons')">
    <div class="p-6 bg-white shadow rounded-xl">
        <h1 class="text-2xl font-semibold mb-6 text-gray-800">{{ __('Persons list') }}</h1>

        <form class="mb-6" method="GET" action="{{ route('persons.index') }}">
            @csrf
            <div class="flex flex-wrap gap-3 items-center">
                <input
                    class="flex-1 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                    type="text"
                    name="search"
                    placeholder="🔍 {{ __('Search by name') }}"
                >
                <button
                    class="cursor-pointer flex items-center gap-2 bg-white border border-gray-300 text-gray-800 hover:text-zinc-800 dark:hover:text-white dark:hover:bg-white/[7%] hover:bg-zinc-800/5 font-semibold px-4 py-2 rounded-md transition shadow-sm"
                    type="submit"
                >
                    <span>Search</span>
                </button>
                <a
                    target="_blank"
                    href="{{ route('persons.json') }}"
                    class="flex items-center gap-2 bg-white border border-gray-300 text-gray-800 hover:text-zinc-800 dark:hover:text-white dark:hover:bg-white/[7%] hover:bg-zinc-800/5 font-semibold px-4 py-2 rounded-md transition shadow-sm"
                >
                    ⬇️ <span>Download</span>
                </a>
            </div>
        </form>

        <div class="overflow-x-auto w-full">
            <table class="table-auto w-full text-sm border border-gray-200">
                <thead class="bg-gray-100 text-gray-700 uppercase tracking-wide">
                    <tr>
                        <th class="p-3 text-left">
                            <a href="{{ route('persons.index', ['sort' => 'last_name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                {{ __('Last name') }}
                            </a>
                        </th>
                        <th class="p-3 text-left">
                            <a href="{{ route('persons.index', ['sort' => 'first_name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                {{ __('First name') }}
                            </a>
                        </th>
                        <th class="p-3 text-left">
                            <a href="{{ route('persons.index', ['sort' => 'age', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                {{ __('Age') }}
                            </a>
                        </th>
                        <th class="p-3 text-center">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $person)
                        <tr class="hover:bg-gray-50 border-t">
                            <td class="p-3">{{ $person->last_name }}</td>
                            <td class="p-3">{{ $person->first_name }}</td>
                            <td class="p-3">{{ $person->age }}</td>
                            <td class="p-3 text-center">
                                <flux:link class="text-blue-600 hover:underline mr-3" :href="route('persons.show', $person->id)" wire:navigate>
                                    {{ __('Show') }}
                                </flux:link>
                                <flux:link class="text-green-600 hover:underline mr-3" :href="route('persons.edit', $person->id)" wire:navigate>
                                    {{ __('Edit') }}
                                </flux:link>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-4 text-center text-gray-500">{{ __('No persons found.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $data->links() }}
        </div>
    </div>
</x-layouts.app>
