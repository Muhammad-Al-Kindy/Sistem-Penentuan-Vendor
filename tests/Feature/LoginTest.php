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
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    public function test_user_can_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'name' => 'testuser',
            'email' => 'testuser@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->withMiddleware()->post('/login', [
            'email' => 'testuser@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/kriteria');
        $this->assertAuthenticated();
    }

    public function test_user_cannot_login_with_invalid_credentials()
    {
        $user = User::factory()->create([
            'name' => 'testuser',
            'email' => 'testuser@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->from('/')->post('/login', [
            'email' => 'testuser@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertRedirect('/');
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }
}
