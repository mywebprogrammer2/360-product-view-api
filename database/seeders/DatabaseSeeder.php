<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
{

    $this->call(PermissionsSeeder::class); // Call PermissionsSeeder next
    $this->call(RolesSeeder::class); // Call RolesSeeder first
}

}
