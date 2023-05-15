<?php

namespace Database\Seeders;

use App\Models\Rol;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'first_name' => 'Admin',
            'last_name'  => 'Admin',
            'username'   => 'admin',
            'city_id'    => 1,
            'email'      => 'admin@gmail.com',
            'password'   => 'password',
        ]);

        $role = Rol::where('name', 'Admin')->first();
        $user->roles()->attach($role);
    }
}
