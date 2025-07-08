<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Services\PersonService;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function dashboard()
    {
        $person = new PersonService();
        return view('dashboard', [
            'person' => $person->getPersonsStats(),
            'markers' => City::select('latitude', 'longitude', DB::raw('COUNT(*) as total'))
                ->groupBy('latitude', 'longitude')
                ->get(),
        ]);
    }

    public function familyTree()
    {
        return view('familyTree');
    }
}
