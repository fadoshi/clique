<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Tenant 01',
            'email' => 'tenant01@mail.com',
            'admin' => true,
        ]);

        User::factory()->create([
            'name' => 'User1 T01',
            'email' => 'user1t01@mail.com',
        ]);
    }
}
