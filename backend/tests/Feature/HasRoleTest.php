<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Enums\Roles;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HasRoleTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Role $adminRole;
    private Role $editorRole;
    private Role $userRole;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleSeeder::class);

        $this->user = User::factory()->create();

        $this->adminRole = Role::where('name', Roles::ADMIN->value)->first();
        $this->userRole = Role::where('name', Roles::USER->value)->first();
    }

    public function test_user_has_role(): void
    {
        $this->user->roles()->attach($this->adminRole);

        $this->assertTrue($this->user->hasRole(Roles::ADMIN->value));
    }

    public function test_user_does_not_have_role(): void
    {
        $this->user->roles()->attach($this->adminRole);

        $this->assertFalse($this->user->hasRole(Roles::USER->value));
    }

    public function test_user_has_multiple_roles(): void
    {
        $this->user->roles()->sync([
            $this->adminRole->id,
            $this->editorRole->id,
        ]);

        $this->assertTrue($this->user->hasRole(Roles::ADMIN->value, Roles::USER->value));
    }

    public function test_user_has_any_role(): void
    {
        $this->user->roles()->attach($this->adminRole);

        $this->assertTrue($this->user->hasRole(Roles::USER->value, Roles::ADMIN->value));
    }
}
