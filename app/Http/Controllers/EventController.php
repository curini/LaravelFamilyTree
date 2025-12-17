<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $page = request()->input('page', 1);

        $perPage = request()->input('per_page', 10);

        $sort = request()->input('sort', 'date');

        $direction = request()->input('direction', 'asc');

        $events = Event::orderBy($sort, $direction)->paginate($perPage, ['*'], 'page', $page);

        return view('livewire.event.index', compact('events'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $event = Event::with('person', 'image', 'city', 'eventType')->findOrFail($id);
        return view('livewire.event.show', compact('event'));
    }
}
