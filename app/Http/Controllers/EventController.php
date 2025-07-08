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

        $sort = request()->input('sort', 'id');

        $direction = request()->input('direction', 'asc');

        $events = Event::orderBy($sort, $direction)->paginate($perPage, ['*'], 'page', $page);

        return view('livewire.event.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('livewire.event.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Event::create($request->all());
        return redirect()->route('events.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $event = Event::with('person')->findOrFail($id);
        return view('livewire.event.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $event = Event::findOrFail($id);
        return view('livewire.event.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $event = Event::findOrFail($id);
        $event->update($request->all());
        return redirect()->route('events.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Event::destroy($id);
        return redirect()->route('events.index');
    }
}
