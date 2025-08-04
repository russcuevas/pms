<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Tenants;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(HostTableSeeder::class);
        $this->call(PropertiesTableSeeder::class);
        $this->call(UnitsTableSeeder::class);
        $this->call(AdminsTableSeeder::class);
        $this->call(TenantsTableSeeder::class);
    }
}
