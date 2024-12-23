<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Enums\Roles;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $adminRole = Role::where('name', Roles::ADMIN)->first();
        $userRole = Role::where('name', Roles::USER)->first();

        $adminUser = User::updateOrCreate([
            'email' => 'foo@bar.com',
        ], [
            'name' => 'Admin',
            'email' => 'foo@bar.com',
            'password' => '123123123',
        ]);

        $adminUser->roles()->sync($adminRole);

        $user = User::updateOrCreate(
            [
                'email' => 'bar@foo.com',
            ],
            [
                'name' => 'Regular User',
                'email' => 'bar@foo.com',
                'password' => '123123123',
            ]
        );

        $user->roles()->sync($userRole);
    }
}
