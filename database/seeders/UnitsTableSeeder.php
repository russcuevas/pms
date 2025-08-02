<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [];

        for ($i = 201; $i <= 215; $i++) {
            $units[] = [
                'property_id' => '1',
                'units_name' => (string)$i,
                'status' => 'vacant',
            ];
        }

        for ($i = 201; $i <= 207; $i++) {
            $units[] = [
                'property_id' => '2',
                'units_name' => (string)$i,
                'status' => 'vacant',
            ];
        }

        for ($i = 301; $i <= 309; $i++) {
            $units[] = [
                'property_id' => '3',
                'units_name' => (string)$i,
                'status' => 'vacant',
            ];
        }

        DB::table('units')->insert($units);
    }
}
