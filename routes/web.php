<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{EventController, PersonController, GroupController, PageController};

Route::get('/', [PageController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('home');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    Route::get('familyTree', [PageController::class, 'familyTree'])->name('familyTree');

    Route::middleware(['admin'])->group(function () {
        Route::get('persons/json', [PersonController::class, 'json'])->name('persons.json');
        Route::resource('persons', PersonController::class)->except(['show']);
        Route::resource('events', EventController::class)->except(['show']);
        Route::resource('groups', GroupController::class)->except(['show']);
    });

    Route::get('persons/{person}', [PersonController::class, 'show'])->name('persons.show');
    Route::get('events/{event}', [EventController::class, 'show'])->name('events.show');
    Route::get('groups/{group}', [GroupController::class, 'show'])->name('groups.show');
});

require __DIR__ . '/auth.php';
