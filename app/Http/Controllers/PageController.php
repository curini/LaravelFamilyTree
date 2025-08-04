<?php

namespace App\Http\Controllers;

use App\EventTypesEnum;
use App\Services\PersonService;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\familyTreeResource;

class PageController extends Controller
{
    public function dashboard()
    {
        $person = new PersonService();
        $event = DB::table('events')
            ->join('cities', 'events.city_id', '=', 'cities.id')
            ->join('event_types', 'events.event_type_id', '=', 'event_types.id')
            ->whereIn('event_types.name', [EventTypesEnum::DEATH, EventTypesEnum::BIRTH])
            ->groupBy('cities.latitude', 'cities.longitude')
            ->select('cities.latitude', 'cities.longitude', DB::raw('COUNT(*) as total'))
            ->get();

        return view('dashboard', [
            'person' => $person->getPersonsStats(),
            'markers' => $event,
        ]);
    }

    public function familyTree()
    {
        $person = new PersonService();
        $people = $person->getPersons();
        $families = familyTreeResource::collection(
            $people->map(function ($person, $index) {
                $person->order_id = $index + 1;
                return $person;
            })
        );

        return view('familyTree', [
            'persons' => familyTreeResource::collection($families),
        ]);
    }
}
