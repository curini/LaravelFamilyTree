<x-layouts.app :title="__('Groups')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <h1 class="text-2xl font-bold">{{ __('Groups list') }}</h1>
        <div class="overflow-x-auto w-full">
            <table class="table-auto w-full text-sm border border-gray-200">
                <thead class="bg-gray-100 text-gray-700 uppercase tracking-wide">
                    <tr>
                        <th class="p-3 text-left">{{ __('Id') }}</th>
                        <th class="p-3 text-center">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($groups as $group)
                        <tr class="hover:bg-gray-50 dark:hover:bg-white/[7%] border-t">
                            <td>{{ $group->id }}</td>
                            <td class="text-center py-2">
                                <flux:link :href="route('groups.show', $group->id)" class="text-blue-600 hover:underline mr-3">{{ __('See') }}</flux:link>
                                <flux:link :href="route('groups.edit', $group->id)" class="text-green-600 hover:underline mr-3">{{ __('Edit') }}</flux:link>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            {{ $groups->links() }}
        </div>
    </div>
</x-layouts.app>
