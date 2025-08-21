<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\TagsEnum;

class familyTreeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $birth = $this->birth();
        $death = $this->death();
        $gender = strtolower($this->gender->name);
        $spouse = $this->getSpouses();
        $attributes = [
            'id' => $this->id,
            'name' => $this->getName(),
            'gender' => $gender,
            'img' => $this->portrait->path,
            'tags' => [$this->getTags($gender)],
            'map' => route('persons.show', $this->id),
        ];

        $attributes = $this->addOptionalAttribute($attributes, 'mid', $this->mother_id);
        $attributes = $this->addOptionalAttribute($attributes, 'fid', $this->father_id);
        $attributes = $this->addOptionalAttribute($attributes, 'pids', $spouse);
        $attributes = $this->addOptionalAttribute($attributes, 'bdate', $birth ? $birth->format('d M Y') : null);
        $attributes = $this->addOptionalAttribute($attributes, 'ddate', $death ? $death->format('d M Y') : null);

        return $attributes;
    }

    private function getSpouses(): array
    {
        $spouses = [];

        if ($this->oldSpouses->isNotEmpty()) {
            foreach ($this->oldSpouses as $oldSpouse) {
                $pivotPersonId = data_get($oldSpouse, 'pivot.spouse_id');
                if ($pivotPersonId && $pivotPersonId !== $this->id) {
                    $spouses[] = $pivotPersonId;
                }
            }
        }

        if (!empty($this->spouse_id)) {
            $spouses[] = $this->spouse_id;
        }

        return array_unique($spouses);
    }

    private function addOptionalAttribute(array $array, string $attribute, mixed $value): array
    {
        if (!empty($value)) {
            $array[$attribute] = $value;
        }
        return $array;
    }

    private function getTags(string $gender): string
    {
        return match ($gender) {
            'male' => TagsEnum::MAIN_MALE_CHILD->value,
            'female' => TagsEnum::MAIN_FEMALE_CHILD->value,
            default => TagsEnum::MAIN_MALE_CHILD->value,
        };
    }
}
