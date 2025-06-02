<?php

namespace Database\Seeders;

use App\Models\User;
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
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'),
            'is_admin' => true,
        ]);

        // Create regular users
        User::create([
            'name' => 'Fathir',
            'email' => 'moh.faathirashshaff2@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('Fathir123'),
        ]);

        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);

        // Create additional users using factory
        User::factory(7)->create();
    }
}