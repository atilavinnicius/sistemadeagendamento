<?php

namespace Database\Seeders;

use Database\Factories\AdminUserFactory;
use Database\Factories\ClientUserFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         AdminUserFactory::new()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);

        ClientUserFactory::new()->create([
            'name' => 'Client User',
            'email' => 'client@example.com',
        ]);
    }
}
