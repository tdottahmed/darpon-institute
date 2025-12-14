<?php

namespace Database\Seeders;

use App\Models\ShippingMethod;
use Illuminate\Database\Seeder;

class ShippingMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $methods = [
            [
                'name' => 'Inside Dhaka',
                'price' => 70.00,
                'duration' => '2-3 Days',
                'status' => true,
            ],
            [
                'name' => 'Sub City',
                'price' => 100.00,
                'duration' => '2-3 Days',
                'status' => true,
            ],
            [
                'name' => 'Outside Dhaka',
                'price' => 110.00,
                'duration' => '3-4 Days',
                'status' => true,
            ],
        ];

        foreach ($methods as $method) {
            ShippingMethod::create($method);
        }

        $this->command->info('Shipping methods seeded successfully.');
    }
}
