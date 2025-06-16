<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use Illuminate\View\View;

class GroupController extends Controller
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
        
        $groups = Group::orderBy($sort, $direction)->paginate($perPage, ['*'], 'page', $page);

        return view('livewire.group.index', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('livewire.group.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Group::create($request->all());
        return redirect()->route('groups.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $group = Group::with('persons')->findOrFail($id);
        return view('livewire.group.show', compact('group'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $group = Group::findOrFail($id);
        return view('livewire.group.edit', compact('group'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $group = Group::findOrFail($id);
        $group->update($request->all());
        return redirect()->route('groups.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Group::destroy($id);
        return redirect()->route('groups.index');
    }
}
