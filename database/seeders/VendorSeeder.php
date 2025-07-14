<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Support\Facades\Hash;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create multiple vendor users if not exist
        $vendorUsers = User::where('role', 'vendor')->get();

        if ($vendorUsers->count() < 5) {
            $toCreate = 5 - $vendorUsers->count();
            for ($i = 1; $i <= $toCreate; $i++) {
                $vendorUsers[] = User::create([
                    'name' => 'Vendor User ' . ($vendorUsers->count() + $i),
                    'email' => 'vendor' . ($vendorUsers->count() + $i) . '@example.com',
                    'password' => Hash::make('password'),
                    'role' => 'vendor',
                ]);
            }
        }

        // For each vendor user, create one vendor record linked to user
        foreach ($vendorUsers as $user) {
            Vendor::create([
                'user_id' => $user->idUser,
                'namaVendor' => $user->name,
                'alamatVendor' => 'Default Address for ' . $user->name,
                'NPWP' => 'NPWP' . $user->idUser,
                'SPPKP' => 'SPPKP' . $user->idUser,
                'nomorIndukPerusahaan' => 'NIP' . $user->idUser,
                'jenisPerusahaan' => 'Default Type',
            ]);
        }
    }
}
