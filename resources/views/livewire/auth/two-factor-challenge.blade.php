<x-layouts.auth.simple>
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Two-Factor Challenge')" :description="__('Two-factor authentication is required. Please enter the code from your authenticator app.')" />

        <form action="{{ route('two-factor.login.store') }}" method="POST" class="flex flex-col gap-6">
            @csrf
            <flux:input name="code" :label="__('Code')" type="text" required autofocus autocomplete="off"
                :placeholder="__('Authentication code')" />

            <div class="flex items-center justify-end">
                <flux:button type="submit" variant="primary" class="w-full">
                    {{ __('Validate') }}
                </flux:button>
            </div>
        </form>
    </div>
</x-layouts.auth.simple>
