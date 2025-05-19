<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Vendor;
use App\Models\User;

class VendorControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_stores_a_new_vendor()
    {
        $user = User::factory()->create();

        $data = [
            'namaVendor' => 'Test Vendor',
            'alamatVendor' => 'Test Address',
            'NPWP' => '123456789',
            'SPPKP' => '987654321',
            'nomorIndukPerusahaan' => '12345',
            'jenisPerusahaan' => 'PT',
        ];

        $response = $this->actingAs($user)->post(route('vendor.submit'), $data);

        $response->assertRedirect(route('vendor.index'));
        $this->assertDatabaseHas('vendors', [
            'namaVendor' => 'Test Vendor',
            'alamatVendor' => 'Test Address',
            'NPWP' => '123456789',
        ]);
    }
}
