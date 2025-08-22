<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['name', 'latitude', 'longitude', 'department_id'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
