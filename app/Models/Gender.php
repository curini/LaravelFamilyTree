<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    protected $fillable = ['name', 'value'];

    public function Person()
    {
        $this->belongsToMany(Person::class);
    }
}
