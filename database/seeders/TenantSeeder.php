<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tenants')->insert([
            'slug' => 'tenant01',
            'name' => 'Tenant 01',
            'email' => 'tenant01@mail.com',
            'password' => Hash::make('password'),
        ]);
    }
}
