<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table = 'persons';

    protected $fillable = [
        'name',
        'job',
        'gender',
        'birth',
        'birthplace',
        'birthcountry',
        'death',
        'deathplace',
        'deathcountry',
        'spouse',
        'group',
        'generation',
        'mother',
        'father',
        'photo',
        'age',
        'birth_act',
        'death_act',
        'other_img'
    ];

    // force display date like dd mm yyyy
    protected $casts = [
        'birth' => 'date',
        'death' => 'date'
    ];

    public static $isoMap = [
        'FRA' => 'France',
        'PRT' => 'Portugal',
        'TUN' => 'Tunisie',
        'SWE' => 'Suède',
        'GER' => 'Allemagne',
        'ESP' => 'Espagne',
        'GBR' => 'Angleterre',
        'ITA' => 'Italie',
        'USA' => 'Etats-Unis'
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->birthcountry = $model->birthcountry ?? 'FRA';
            $model->age = $model->age ?? $model->calculateAge($model->birth, $model->death);
            $model->photo = $model->photo ?? '/img/portraits/default.PNG';
        });
        self::updating(function ($model) {
            $model->birthcountry = $model->birthcountry ?? 'FRA';
            $model->age = $model->age  ?? $model->calculateAge($model->birth, $model->death);
            $model->photo = $model->photo ?? '/img/portraits/default.PNG';
        });
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group');
    }

    public function spousePerson()
    {
        return $this->belongsTo(Person::class, 'spouse');
    }

    public function motherPerson()
    {
        return $this->belongsTo(Person::class, 'mother');
    }

    public function fatherPerson()
    {
        return $this->belongsTo(Person::class, 'father');
    }

    public function childrenAsFather()
    {
        return $this->hasMany(Person::class, 'father');
    }

    public function childrenAsMother()
    {
        return $this->hasMany(Person::class, 'mother');
    }

    public function getBirthcountryNameAttribute(): ?string
    {
        if (!$this->birthcountry) return null;
        return $this->isoMap[$this->birthcountry] ?? $this->birthcountry;
    }

    public function getDeathcountryNameAttribute(): ?string
    {
        if (!$this->deathcountry) return null;
        return $this->isoMap[$this->deathcountry] ?? $this->deathcountry;
    }

    private function calculateAge(?DateTime $birth, ?DateTime $death): int
    {
        if (!$birth) {
            return 0;
        }
        $end = $death ?? new DateTime();
        return $end->diff($birth)->y;
    }
}
