<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['person_id', 'event_type_id', 'image_id', 'date', 'city_id'];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    public function eventType()
    {
        return $this->belongsTo(EventType::class);
    }
}
