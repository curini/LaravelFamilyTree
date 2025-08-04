<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\EventTypesEnum;
use DateTime;

class Person extends Model
{
    protected $table = 'persons';

    protected $fillable = [
        'name',
        'job',
        'description',
        'gender_id',
        'spouse_id',
        'group_id',
        'mother_id',
        'father_id',
        'image_id',
        'position_id',
        'age',
    ];

    public static function boot()
    {
        parent::boot();

        self::saving(function ($model) {
            $model->age = $model->calculateAge($model->birth(), $model->death());
        });
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function spousePerson()
    {
        return $this->belongsTo(Person::class, 'spouse_id');
    }

    public function oldSpouses()
    {
        return $this->belongsToMany(Person::class, 'old_spouse_person', 'person_id', 'spouse_id');
    }

    public function motherPerson()
    {
        return $this->belongsTo(Person::class, 'mother_id');
    }

    public function fatherPerson()
    {
        return $this->belongsTo(Person::class, 'father_id');
    }

    public function childrenAsFather()
    {
        return $this->hasMany(Person::class, 'father_id');
    }

    public function childrenAsMother()
    {
        return $this->hasMany(Person::class, 'mother_id');
    }

    public function portrait()
    {
        return $this->belongsTo(Image::class, 'image_id');
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'person_id');
    }

    public function gender()
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

    public function getName()
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
