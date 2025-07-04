<x-layouts.app :title="__('Groups')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <h1>{{ __('Edit group') }}</h1>
            <form class="mb-4" method="POST" action="{{ route('groups.update', $group->id) }}">
                @csrf
                @method('PUT')
                <div class="p-4">
                    <label for="wedding_act">
                        {{ __('Wedding act') }}
                    </label>
                    <input class="input w-full border border-zinc-200" type="text" name="wedding_act" value="{{ $group->wedding_act }}">
                </div>
                <div class="p-4">
                    <button type="submit" class="bg-blue-500 hover:bg-zinc-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('Save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
