<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'admin',
            'editor',
            'viewer',
            'guest',
        ];

        foreach ($roles as $roleName) {
            $role = Role::firstOrCreate([
                'slug' => $roleName,
            ], [
                'name' => ucfirst($roleName), 
            ]);

            $user = User::create([
                'name' => ucfirst($roleName) . ' User',
                'email' => strtolower($roleName) . '@example.com',
                'password' => Hash::make('password'), 
            ]);

            $user->roles()->attach($role);
        }
    }
}
