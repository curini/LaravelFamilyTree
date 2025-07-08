<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['name', 'region', 'latitude', 'longitude', 'department', 'country_id'];

    public function Country()
    {
        $this->belongsTo(Country::class);
    }
}
