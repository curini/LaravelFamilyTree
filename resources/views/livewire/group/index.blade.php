<x-layouts.app :title="__('Persons')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <h1 class="text-2xl font-bold">{{ __('Groups list') }}</h1>
        <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
            <table>
                <thead>
                    <tr>
                        <th>{{ __('Id') }}</th>
                        <th>{{ __('Wedding act') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($groups as $group)
                        <tr>
                            <td>{{ $group->id }}</td>
                            <td>{{ $group->wedding_act }}</td>
                            <td class="text-center py-2">
                                <flux:link :href="route('groups.show', $group->id)" class="text-sm cursor-pointer rounded">{{ __('See') }}</flux:link>
                                <flux:link :href="route('groups.edit', $group->id)" class="bg-red-500 hover:bg-red-600 ms-2 rounded py-1 px-2">{{ __('Edit') }}</flux:link>
                            </td>
                        </tr>
                    @endforeach
                </tbody>    
            </table>
        </div>
        {{ $groups->links() }}
    </div>
</x-layouts.app>