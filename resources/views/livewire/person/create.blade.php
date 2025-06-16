<x-layouts.app :title="__('Create person')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <h1>{{ __('Create a new person') }}</h1>
        <form class="mb-4" method="POST" action="{{ route('persons.store') }}">
            @csrf
            <div class="flex gap-4 mt-4">
                <label for="name">
                    {{ __('Name') }}
                </label>
                <input class="input w-full border border-zinc-200" type="text" name="name">
            </div>
            <div class="flex gap-4 mt-4">
                <label for="father">
                    {{ __('Father') }}
                </label>
                <select class="input w-full border border-zinc-200" name="father">
                    <option value="">{{ __('None') }}</option>
                    @foreach ($fathers as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-4 mt-4">
                <label for="mother">
                    {{ __('Mother') }}
                </label>
                <select class="input w-full border border-zinc-200" name="mother">
                    <option value="">{{ __('None') }}</option>
                    @foreach ($mothers as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-4 mt-4">
                <label for="gender">
                    {{ __('Gender') }}
                </label>
                <select class="input w-full border border-zinc-200" name="gender">
                    <option value="M">{{ __('Male') }}</option>
                    <option value="F">{{ __('Female') }}</option>
                </select>               
            </div>
            <div class="flex gap-4 mt-4">
                <label for="job">
                    {{ __('Job') }}
                </label>
                <input class="input w-full border border-zinc-200" type="text" name="job">
            </div>
            <div class="flex gap-4 mt-4">
                <label for="birth">
                    {{ __('Birthday') }}
                </label>
                <input class="input w-full border border-zinc-200" type="date" name="birth">
            </div>
            <div class="flex gap-4 mt-4">
                <label for="birthplace">
                    {{ __('Birthplace') }}
                </label>
                <input class="input w-full border border-zinc-200" type="text" name="birthplace">
            </div>
            <div class="flex gap-4 mt-4">
                <label for="birthcountry">
                    {{ __('Birthcountry') }}
                </label>
                <select class="input w-full border border-zinc-200" name="birthcountry">
                    <option value="">{{ __('None') }}</option>
                    @foreach($countries as $code => $name)
                        <option value="{{ $code }}">{{ $name }}</option>    
                    @endforeach
                </select>
            </div>
            <div class="flex gap-4 mt-4">
                <label for="death">
                    {{ __('Deathday') }}
                </label>
                <input class="input w-full border border-zinc-200" type="date" name="death">
            </div>
            <div class="flex gap-4 mt-4">
                <label for="deathplace">
                    {{ __('Deathplace') }}
                </label>
                <input class="input w-full border border-zinc-200" type="text" name="deathplace">
            </div>
            <div class="flex gap-4 mt-4">
                <label for="deathcountry">
                    {{ __('Deathcountry') }}
                </label>
                <select class="input w-full border border-zinc-200" name="deathcountry">
                    <option value="">{{ __('None') }}</option>
                    @foreach($countries as $code => $name)
                        <option value="{{ $code }}">{{ $name }}</option>    
                    @endforeach
                </select>
            </div>
            <div class="flex gap-4 mt-4">
                <label for="spouse">
                    {{ __('Spouse') }}
                </label>
                <select class="input w-full border border-zinc-200" name="spouse">
                    <option value="">{{ __('None') }}</option>
                    @foreach ($spouses as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-4 mt-4">
                <label for="photo">
                    {{ __('Photo') }}
                </label>
                <input class="input w-full border border-zinc-200" type="text" name="photo">
            </div>
            <div class="flex gap-4 mt-4">
                <label for="age">    
                    {{ __('Age') }}
                </label>
                <input class="input w-full border border-zinc-200" type="number" name="age">
            </div>
            <div class="flex gap-4 mt-4">
                <label for="birth_act">    
                    {{ __('Birth Act') }}    
                </label>    
                <input class="input w-full border border-zinc-200" type="text" name="birth_act">    
            </div>
            <div class="flex gap-4 mt-4">
                <label for="death_act">    
                    {{ __('Death Act') }}    
                </label>    
                <input class="input w-full border border-zinc-200" type="text" name="death_act">    
            </div>
            <div class="flex gap-4 mt-4">
                <label for="group">    
                    {{ __('Group') }}    
                </label>
                <select class="input w-full border border-zinc-200" name="group">
                    <option value="">{{ __('None') }}</option>    
                    @foreach ($groups as $id => $name)    
                        <option value="{{ $id }}">{{ $name }}</option>    
                    @endforeach    
                </select>    
            </div>
            <div class="flex gap-4 mt-4">
                <label for="other_img">    
                    {{ __('Other Image') }}    
                </label>    
                <input class="input w-full border border-zinc-200" type="text" name="other_img">    
            </div>
            <div class="mt-4">
                <button class="bg-blue-500 hover:bg-zinc-700 text-white font-bold py-2 px-4 rounded" type="submit">Save</button>
            </div>
        </form>
    </div>
</x-layouts.app>
