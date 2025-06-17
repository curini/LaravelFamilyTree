<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{PersonController, GroupController};

Route::view('/', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('home');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
    Route::get('persons/json', [ PersonController::class, 'json'])->name('persons.json');
    Route::resource('persons', PersonController::class);

    Route::resource('groups', GroupController::class);
});

require __DIR__.'/auth.php';
