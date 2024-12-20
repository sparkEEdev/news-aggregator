<?php

namespace Database\Seeders;

use App\Enums\Roles;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = Roles::valuesToArray();

        foreach ($roles as $role) {
            Role::create([
                'name' => $role,
            ]);
        }
    }
}
