<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class PageTest extends TestCase
{
    use RefreshDatabase;

    public function test_familyTree_view_guests_are_redirected_to_login_page(): void
    {
        $response = $this->get('/familyTree');

        $response->assertRedirect('/login');
    }

    public function test_familyTree_view_authenticated_users_can_visit(): void
    {
        $this->actingAs($user = User::factory()->create());

        $response = $this->get('/familyTree');

        $response->assertStatus(200);
    }
}
