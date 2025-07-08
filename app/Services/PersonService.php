<?php

namespace App\Services;

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
            'most_used_family_name' => ['value' => $this->getMostFrequentLastName(), 'color' => 'text-green-600'],
            'more_younger_deceased' => ['value' => $this->getYounger(true), 'color' => 'text-purple-600'],
            'more_older_deceased' => ['value' => $this->getOlder(true), 'color' => 'text-blue-600'],
            'more_younger' => ['value' => $this->getYounger(), 'color' => 'text-indigo-600'],
            'more_older' => ['value' => $this->getOlder(), 'color' => 'text-orange-600'],
        ];
    }

    private function countPersons()
    {
        return Person::count();
    }

    private function countDistinctLastNames()
    {
        return Person::distinct('last_name')->count('last_name');
    }

    private function getMostFrequentLastName()
    {
        return Person::select('last_name', DB::raw('COUNT(*) as total'))
            ->groupBy('last_name')
            ->orderBy('total', 'desc')
            ->first();
    }

    private function getYounger(bool $is_deceased = false)
    {
        return Person::select('age')
            ->where(function ($query) use ($is_deceased) {
                if ($is_deceased) {
                    $query->whereNotNull('death');
                } else {
                    $query->whereNull('death');
                }
            })
            ->orderBy('age', 'asc')
            ->first();
    }

    private function getOlder(bool $is_deceased = false)
    {
        return Person::select('age')
            ->where(function ($query) use ($is_deceased) {
                if ($is_deceased) {
                    $query->whereNotNull('death');
                } else {
                    $query->whereNull('death');
                }
            })
            ->orderBy('age', 'desc')
            ->first();
    }
}
