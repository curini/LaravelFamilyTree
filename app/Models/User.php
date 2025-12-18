<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\RolesEnum;
use Curini\Password\Models\User as UserPassword;
use Illuminate\Support\Str;

class User extends UserPassword
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = ['name', 'email', 'password', 'role_id'];


    public static function boot()
    {
        parent::boot();

        self::saving(function ($model) {
            $model->role_id = $model->role_id ?? Role::where('name', RolesEnum::USER)->first();
        });
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)->explode(' ')->map(fn(string $name) => Str::of($name)->substr(0, 1))->implode('');
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
