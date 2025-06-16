<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'wedding_act',
    ];

    public function persons()
    {
        return $this->hasMany(Person::class, 'group');
    }
}
