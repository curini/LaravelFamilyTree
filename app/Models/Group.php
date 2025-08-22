<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public function persons()
    {
        return $this->hasMany(Person::class, 'group_id');
    }
}
