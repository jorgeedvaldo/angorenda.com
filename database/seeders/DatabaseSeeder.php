<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 1. Create a Primary Admin for management
        \App\Models\User::factory()->create([
            'name' => 'Admin Angorenda',
            'email' => 'admin@angorenda.com',
            'role' => 'admin',
        ]);

        // 2. Create 10 Owners and 100 Properties
        // Each owner will have roughly 10 properties
        \App\Models\User::factory(10)
            ->has(\App\Models\Property::factory()->count(10), 'properties')
            ->create();
    }
}
