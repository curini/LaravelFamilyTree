<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\RolesEnum;

class PersonTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_view_guests_are_redirected_to_login_page(): void
    {
        $response = $this->get('/persons/create');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_users_can_not_create_person(): void
    {
        $this->actingAs($user = User::factory()->create());

        $response = $this->get('/persons/create');

        $response->assertStatus(404);
    }

    public function test_admin_can_create_person(): void
    {
        $role = Role::factory()->create(['name' => RolesEnum::ADMIN]);
        $user = User::factory()->create(['role_id' => $role->id]);

        $this->actingAs($user);

        $response = $this->get('/persons/create');

        $response->assertStatus(200);
    }

    public function test_json_view_guests_are_redirected_to_login_page(): void
    {
        $response = $this->get('/persons/json');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_users_can_not_visit_json_page(): void
    {
        $this->actingAs($user = User::factory()->create());

        $response = $this->get('/persons/json');

        $response->assertStatus(404);
    }

    public function test_admin_can_visit_json_page(): void
    {
        $role = Role::factory()->create(['name' => RolesEnum::ADMIN]);
        $user = User::factory()->create(['role_id' => $role->id]);

        $this->actingAs($user);

        $response = $this->get('/persons/json');

        $response->assertStatus(200);
    }
}
