<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@mail.com',
            'password' => Hash::make('12345678'),
            'user_type' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create customer user
        User::create([
            'name' => 'Customer User',
            'email' => 'customer@mail.com',
            'password' => Hash::make('12345678'),
            'user_type' => 'customer',
            'email_verified_at' => now(),
        ]);

        // Create additional customer users
        User::factory(5)->create([
            'user_type' => 'customer',
        ]);
    }
}
