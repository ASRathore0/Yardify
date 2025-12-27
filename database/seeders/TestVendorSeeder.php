<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Support\Str;

class TestVendorSeeder extends Seeder
{
    public function run()
    {
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'Test User',
                'email' => 'test+vendor@example.com',
                'password' => bcrypt('password'),
            ]);
        }

        Vendor::create([
            'user_id' => $user->id,
            'service_name' => 'Test Plumber Service',
            'subtitle' => 'Fast & Reliable',
            'category' => 'Home Service',
            'service' => 'Plumber',
            'description' => 'Seeded test plumber for local testing',
            'pin_code' => '141401',
            'area' => 'Test Area',
            'city' => 'Ludhiana',
            'state' => 'Punjab',
            'street' => 'Seed Street',
            'base_price' => 250,
            'discount_percent' => 10,
            'contact_number' => '+911234567890',
            'email' => 'plumber@test.example',
        ]);
    }
}
