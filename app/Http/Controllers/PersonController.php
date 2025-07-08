<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Country, Person, Group};
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        // get the page number from the request
        $page = $request->input('page', 1);

        // get the number of items per page from the request
        $perPage = $request->input('per_page', 10);

        // get the search term from the request
        $search = $request->input('search', '');

        // get the sort order from the request
        $sort = $request->input('sort', 'id');

        // get the sort direction from the request
        $direction = $request->input('direction', 'asc');

        // get the data from the database
        $data = Person::where('first_name', 'like', '%' . $search . '%')
            ->orWhere('last_name', 'like', '%' . $search . '%')
            ->orderBy($sort, $direction)
            ->paginate($perPage, ['*'], 'page', $page)
            ->withQueryString();

        return view('livewire.person.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $mothers = Person::where('gender', 'F')->pluck('name', 'id');
        $fathers = Person::where('gender', 'M')->pluck('name', 'id');
        $spouses = Person::all()->pluck('name', 'id');
        $groups = Group::all()->pluck('id', 'id');
        $countries = Country::all();
        return view('livewire.person.create', compact('mothers', 'fathers', 'spouses', 'groups', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Person::create($request->all());

        return redirect()->route('persons.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $person = Person::with([
            'motherPerson',
            'fatherPerson',
            'spousePerson',
            'childrenAsMother',
            'childrenAsFather',
        ])->findOrFail($id);
        $countries = Country::all();
        $slides = [];
        if ($person->birth_act) {
            $slides[] = $person->birth_act;
        }
        if ($person->other_img) {
            $slides[] = $person->other_img;
        }
        if ($person->death_act) {
            $slides[] = $person->death_act;
        }

        return view('livewire.person.show', compact('person', 'countries', 'slides'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $person = Person::findOrFail($id);
        $mothers = Person::where('gender', 'F')->pluck('name', 'id');
        $fathers = Person::where('gender', 'M')->pluck('name', 'id');
        $spouses = Person::all()->pluck('name', 'id');
        $groups = Group::all()->pluck('id', 'id');
        $countries = Country::all();
        return view('livewire.person.edit', compact('person', 'mothers', 'fathers', 'spouses', 'groups', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        Person::findOrFail($id)->update($request->all());

        return redirect()->route('persons.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        Person::destroy($id);

        return redirect()->route('persons.index');
    }

    public function json()
    {
        $person = Person::all()->toArray();
        $group = Group::all()->toArray();

        return response()->json(array_merge($person, $group));
    }
}
