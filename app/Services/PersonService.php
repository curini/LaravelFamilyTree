<?php

namespace App\Services;

use App\EventTypesEnum;
use App\GendersEnum;
use App\Models\City;
use App\Models\EventType;
use App\Models\Gender;
use App\Models\Person;
use Illuminate\Support\Facades\DB;

class PersonService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getPersontToEdit($id = null): array
    {
        $person = isset($id) ? Person::with('events')->findOrFail($id) : new Person();
        $femaleGender = Gender::where('value', GendersEnum::FEMALE)->first();
        $maleGender = Gender::where('value', GendersEnum::MALE)->first();

        $mothers = Person::where('gender_id', data_get($femaleGender, 'id'))->pluck('first_name', 'id');
        $fathers = Person::where('gender_id', data_get($maleGender, 'id'))->pluck('first_name', 'id');
        $spouses = Person::all()->pluck('first_name', 'id');
        $cities = City::all();
        $eventTypes = EventType::all();
        $title = isset($id) ? 'Edit person' : 'New person';

        return compact('person', 'mothers', 'fathers', 'spouses', 'cities', 'title', 'eventTypes');
    }

    public function getPersonsStats(): array
    {
        $younger_deceased = $this->getYounger(true);
        $older_deceased = $this->getOlder(true);
        $younger = $this->getYounger();
        $older = $this->getOlder();

        return [
            'nb_persons' => ['value' => $this->countPersons(), 'color' => 'text-red-800'],
            'nb_family_name' => ['value' => $this->countDistinctLastNames(), 'color' => 'text-gray-700'],
            'most_used_family_name' => [
                'value' => data_get($this->getMostFrequentLastName(), 'last_name'),
                'color' => 'text-green-600',
            ],
            'more_younger_deceased' => [
                'value' => data_get($younger_deceased, 'age'),
                'color' => 'text-purple-600',
                'person_id' => data_get($younger_deceased, 'id')
            ],
            'more_older_deceased' => [
                'value' => data_get($older_deceased, 'age'),
                'color' => 'text-blue-600',
                'person_id' => data_get($older_deceased, 'id')
            ],
            'more_younger' => [
                'value' => data_get($younger, 'age'),
                'color' => 'text-indigo-600',
                'person_id' => data_get($younger, 'id')
            ],
            'more_older' => [
                'value' => data_get($older, 'age'),
                'color' => 'text-orange-600',
                'person_id' => data_get($older, 'id')
            ],
        ];
    }

    public function getPersons(): mixed
    {
        return Person::select('persons.*')
            ->whereNotNull('persons.gender_id')
            ->whereNotNull('persons.image_id')
            ->with(['motherPerson', 'fatherPerson', 'spousePerson', 'portrait', 'oldSpouses', 'gender'])
            ->get();
    }

    private function countPersons(): mixed
    {
        return Person::count();
    }

    private function countDistinctLastNames(): mixed
    {
        return Person::distinct('last_name')->where('last_name', '!=', '')->count('last_name');
    }

    private function getMostFrequentLastName(): mixed
    {
        return Person::select('last_name', DB::raw('COUNT(*) as total'))
            ->where('last_name', '!=', '')
            ->groupBy('last_name')
            ->orderBy('total', 'desc')
            ->first();
    }

    private function getYounger(bool $is_deceased = false): mixed
    {
        return Person::select('age', 'id')
            ->whereHas('events', function ($query) {
                $query->whereHas('eventType', function ($q) {
                    $q->where('name', EventTypesEnum::BIRTH);
                });
            })
            ->when(
                $is_deceased,
                function ($query) {
                    $query->whereHas('events', function ($q) {
                        $q->whereHas('eventType', function ($sq) {
                            $sq->where('name', EventTypesEnum::DEATH);
                        });
                    });
                },
                function ($query) {
                    $query->whereDoesntHave('events', function ($q) {
                        $q->whereHas('eventType', function ($sq) {
                            $sq->where('name', EventTypesEnum::DEATH);
                        });
                    });
                }
            )
            ->orderBy('age', 'asc')
            ->first();
    }

    private function getOlder(bool $is_deceased = false): mixed
    {
        return Person::select('age', 'id')
            ->whereHas('events', function ($query) {
                $query->whereHas('eventType', function ($q) {
                    $q->where('name', EventTypesEnum::BIRTH);
                });
            })
            ->when(
                $is_deceased,
                function ($query) {
                    $query->whereHas('events', function ($q) {
                        $q->whereHas('eventType', function ($sq) {
                            $sq->where('name', EventTypesEnum::DEATH);
                        });
                    });
                },
                function ($query) {
                    $query->whereDoesntHave('events', function ($q) {
                        $q->whereHas('eventType', function ($sq) {
                            $sq->where('name', EventTypesEnum::DEATH);
                        });
                    });
                }
            )
            ->orderBy('age', 'desc')
            ->first();
    }
}
