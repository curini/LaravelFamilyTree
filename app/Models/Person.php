<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\EventTypesEnum;
use DateTime;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Person extends Model
{
    protected $table = 'persons';

    protected $fillable = [
        'last_name',
        'first_name',
        'first_names',
        'job',
        'description',
        'gender_id',
        'spouse_id',
        'mother_id',
        'father_id',
        'image_id',
        'age',
    ];

    public static function boot()
    {
        parent::boot();

        self::saving(function ($model) {
            $model->age = $model->calculateAge($model->birth(), $model->death());
        });
    }

    public function brothers(): HasMany
    {
        $select = ['id', 'last_name', 'first_name', 'mother_id', 'father_id'];
        return $this->brothersFromFather()->select($select)->union($this->brothersFromMother()->select($select));
    }

    public function brothersFromMother(): HasMany
    {
        return $this->hasMany(Person::class, 'mother_id', 'mother_id');
    }

    public function brothersFromFather(): HasMany
    {
        return $this->hasMany(Person::class, 'father_id', 'father_id');
    }

    public function spousePerson(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'spouse_id');
    }

    public function oldSpouses(): BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'old_spouse_person', 'person_id', 'spouse_id');
    }

    public function motherPerson(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'mother_id');
    }

    public function fatherPerson(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'father_id');
    }

    public function childrenAsFather(): HasMany
    {
        return $this->hasMany(Person::class, 'father_id');
    }

    public function childrenAsMother(): HasMany
    {
        return $this->hasMany(Person::class, 'mother_id');
    }

    public function portrait(): BelongsTo
    {
        return $this->belongsTo(Image::class, 'image_id');
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'person_id');
    }

    public function gender(): BelongsTo
    {
        return $this->belongsTo(Gender::class);
    }

    public function birth(): ?DateTime
    {
        return data_get($this->getEvent(EventTypesEnum::BIRTH, false), 'date');
    }

    public function death(): ?DateTime
    {
        return data_get($this->getEvent(EventTypesEnum::DEATH, false), 'date');
    }

    public function getEvent(EventTypesEnum $type = EventTypesEnum::BIRTH, bool $withImage = true): ?Event
    {
        $event = $this->events();

        if ($withImage) {
            $event = $event->select('image_id')->with('image:id,path,name');
        }

        return $event
            ->whereHas('eventType', function ($query) use ($type) {
                $query->where('name', $type);
            })
            ->first();
    }

    public function getName(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    private function calculateAge(?DateTime $birth, ?DateTime $death): int
    {
        if (!isset($birth)) {
            return 0;
        }
        $end = $death ?? new DateTime();
        return $end->diff($birth)->y;
    }
}
