<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            BloodtypeSeeder::class,
            CitiesSeeder::class,  // Cities must be seeded before any users
        ]);
        
        // Now create the test user after cities exist
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call([
            UserSeeder::class,
            DonationCenterSeeder::class,  // This should run after users since it uses user_id
        ]);
    }
}
