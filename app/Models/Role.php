<?php

namespace App\Models;

use App\RolesEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function isAdmin(): bool
    {
        return $this->id == data_get(Role::where('name', RolesEnum::ADMIN)->first(), 'id');
    }
}
