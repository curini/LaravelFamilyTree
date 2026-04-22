<x-layouts.app>
    <section class="w-full">
        @include('partials.settings-heading')

        @if ($errors->confirmTwoFactorAuthentication->any())
            @foreach ($errors->confirmTwoFactorAuthentication->all() as $error)
                <div class="bg-red-200 w-full px-2 py-2 my-[5px] text-white">
                    Error - {{ $error }}
                </div>
            @endforeach
        @endif

        <x-settings.layout :heading="__('Two Factor Authentication')" :subheading="__('Manage your two factor authentication')">
            @if (session('status') == 'two-factor-authentication-enabled')
                <div class="mb-4 font-medium text-sm">
                    Please finish configuring two-factor authentication below.
                </div>
                {!! request()->user()->twoFactorQrCodeSvg() !!}
                <form action="{{ route('two-factor.confirm') }}" class="mt-6 space-y-6" method="POST">
                    @csrf
                    <div class=""></div>
                    <div class="flex gap-4 h-[70px]">
                        <div class="flex items-end h-full">
                            <flux:input :label="__('Code')" type="text" required autocomplete="off"
                                name="code" />
                        </div>
                        <div class="flex items-end h-full justify-end">
                            <flux:button variant="primary" type="submit" class="">{{ __('Vérifier') }}
                            </flux:button>
                        </div>
                    </div>
                </form>
            @elseif (session('status') == 'two-factor-authentication-confirmed' ||
                    request()->user()->hasEnabledTwoFactorAuthentication())
                <div class="mb-4 font-medium text-sm">
                    Two-factor authentication confirmed and enabled successfully.
                </div>
                <form action="{{ route('two-factor.disable') }}" class="mt-6 space-y-6" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex items-center gap-4">
                        <div class="flex items-center justify-end">
                            <flux:button variant="primary" type="submit" class="w-full">{{ __('Désactiver') }}
                            </flux:button>
                        </div>
                    </div>
                </form>
            @else
                <form action="{{ route('two-factor.enable') }}" class="mt-6 space-y-6" method="POST">
                    @csrf
                    <div class="flex items-center gap-4">
                        <div class="flex items-center justify-end">
                            <flux:button variant="primary" type="submit" class="w-full">{{ __('Activer') }}
                            </flux:button>
                        </div>
                    </div>
                </form>
            @endif

        </x-settings.layout>
    </section>
</x-layouts.app>
