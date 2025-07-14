<?php

namespace App\Services;

use App\EventTypesEnum;
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

    public function getPersonsStats()
    {
        return [
            'nb_persons' => ['value' => $this->countPersons(), 'color' => 'text-red-800'],
            'nb_family_name' => ['value' => $this->countDistinctLastNames(), 'color' => 'text-gray-700'],
            'most_used_family_name' => [
                'value' => data_get($this->getMostFrequentLastName(), 'last_name'),
                'color' => 'text-green-600',
            ],
            'more_younger_deceased' => [
                'value' => data_get($this->getYounger(true), 'age'),
                'color' => 'text-purple-600',
            ],
            'more_older_deceased' => ['value' => data_get($this->getOlder(true), 'age'), 'color' => 'text-blue-600'],
            'more_younger' => ['value' => data_get($this->getYounger(), 'age'), 'color' => 'text-indigo-600'],
            'more_older' => ['value' => data_get($this->getOlder(), 'age'), 'color' => 'text-orange-600'],
        ];
    }

    public function getPersons()
    {
        return Person::with('position', 'motherPerson', 'fatherPerson', 'spousePerson')->has('position')->get();
    }

    private function countPersons()
    {
        return Person::count();
    }

    private function countDistinctLastNames()
    {
        return Person::distinct('last_name')->where('last_name', '!=', '')->count('last_name');
    }

    private function getMostFrequentLastName()
    {
        return Person::select('last_name', DB::raw('COUNT(*) as total'))
            ->where('last_name', '!=', '')
            ->groupBy('last_name')
            ->orderBy('total', 'desc')
            ->first();
    }

    private function getYounger(bool $is_deceased = false)
    {
        return Person::select('age')
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

    private function getOlder(bool $is_deceased = false)
    {
        return Person::select('age')
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
