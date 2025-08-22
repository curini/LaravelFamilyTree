<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OldSpousePerson extends Model
{
    protected $fillable = ['person_id', 'spouse_id'];
}
