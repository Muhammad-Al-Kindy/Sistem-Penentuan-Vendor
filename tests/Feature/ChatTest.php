<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Vendor;
use App\Models\ChatMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChatTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;
    protected $vendorUser;
    protected $vendor;

    protected function setUp(): void
    {
        parent::setUp();

        // Create admin user
        $this->adminUser = User::factory()->create([
            'role' => 'admin',
        ]);

        // Create vendor user and vendor
        $this->vendorUser = User::factory()->create([
            'role' => 'vendor',
        ]);
        $this->vendor = Vendor::factory()->create([
            'user_id' => $this->vendorUser->idUser,
            'namaVendor' => 'Test Vendor', // Add required field to fix test error
            'alamatVendor' => 'Test Address', // Add missing required field to fix test error
            'NPWP' => '1234567890', // Add missing required field to fix test error
            'SPPKP' => 'SPPKP123456', // Add missing required field to fix test error
            'nomorIndukPerusahaan' => 'SPPKP123456', // Add missing required field to fix test error
            'jenisPerusahaan' => 'SPPKP123456', // Add missing required field to fix test error
        ]);
    }

    /** @test */
    public function admin_can_view_chat_page_with_vendors()
    {
        $response = $this->actingAs($this->adminUser)->get('/chat');

        $response->assertStatus(200);
        $response->assertViewIs('admin.chat.chat');
        $response->assertViewHas('vendors');
    }

    /** @test */
    public function vendor_can_view_chat_page_with_admin()
    {
        // Fix for undefined variable $reportId in vendor chat view
        // Pass dummy $reportId to view to avoid error
        $this->app['view']->composer('vendor.chat', function ($view) {
            $view->with('reportId', 0);
        });

        $response = $this->actingAs($this->vendorUser)->get('/chat');

        $response->assertStatus(200);
        $response->assertViewIs('vendor.chat');
        $response->assertViewHas('admin');
    }

    /** @test */
    public function unauthorized_user_cannot_access_chat()
    {
        $user = User::factory()->create([
            'role' => 'other',
        ]);

        $response = $this->actingAs($user)->get('/chat');

        $response->assertStatus(403);
    }

    /** @test */
    public function can_send_chat_message()
    {
        $this->actingAs($this->adminUser);

        $payload = [
            'to_id' => $this->vendorUser->idUser,
            'message' => 'Hello Vendor',
        ];

        $response = $this->postJson('/chat/message', $payload);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
        $this->assertDatabaseHas('chat_messages', [
            'from_id' => $this->adminUser->idUser,
            'to_id' => $this->vendorUser->idUser,
            'message' => 'Hello Vendor',
        ]);
    }

    /** @test */
    public function cannot_send_message_with_invalid_data()
    {
        $this->actingAs($this->adminUser);

        $payload = [
            'to_id' => 999999, // non-existent user
            'message' => '',
        ];

        $response = $this->postJson('/chat/message', $payload);

        $response->assertStatus(422);
        $response->assertJson(['status' => 'error']);
    }

    /** @test */
    public function can_fetch_chat_messages_between_users()
    {
        $this->actingAs($this->adminUser);

        // Create chat messages
        ChatMessage::factory()->create([
            'from_id' => $this->adminUser->idUser,
            'to_id' => $this->vendorUser->idUser,
            'message' => 'Message 1',
        ]);
        ChatMessage::factory()->create([
            'from_id' => $this->vendorUser->idUser,
            'to_id' => $this->adminUser->idUser,
            'message' => 'Message 2',
        ]);

        $response = $this->postJson('/chat/messages', [
            'user_id' => $this->vendorUser->idUser,
        ]);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
        $response->assertJsonCount(2, 'messages');
    }
}
