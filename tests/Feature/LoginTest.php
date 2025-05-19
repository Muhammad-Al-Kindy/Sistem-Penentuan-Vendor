<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_can_be_rendered()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    public function test_user_can_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'name' => 'testuser',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/', [
            'name' => 'testuser',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/kriteria');
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_login_with_invalid_credentials()
    {
        $user = User::factory()->create([
            'name' => 'testuser',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->from('/')->post('/', [
            'name' => 'testuser',
            'password' => 'wrongpassword',
        ]);

        $response->assertRedirect('/');
        $response->assertSessionHasErrors('username');
        $this->assertGuest();
    }
}