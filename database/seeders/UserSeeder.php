<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //User::factory(10)->create();

        $myUser = User::factory()
            ->make([
                'email' => 'stefan92@example.com',
                'name' => 'Stefan Von Bronquost',
            ])
            ->toArray();

        $myUser['password'] = Hash::make('password');

        User::updateOrCreate(
            [
                'email' => 'stefan92@example.com',
            ],
            $myUser
        );
    }
}
