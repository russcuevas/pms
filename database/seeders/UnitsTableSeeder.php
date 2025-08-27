<?php

namespace Database\Seeders;

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

        // Units for property_id = 1 (201–215, 301–315, 401–415, 501–515)
        foreach ([200, 300, 400, 500] as $base) {
            for ($i = 1; $i <= 15; $i++) {
                $unitNumber = $base + $i;
                $units[] = [
                    'property_id' => 1,
                    'units_name' => (string)$unitNumber,
                    'status' => 'vacant',
                ];
            }
        }

        // Units for property_id = 2 (301–307, 401–407, 501–507)
        foreach ([300, 400, 500] as $base) {
            for ($i = 1; $i <= 7; $i++) {
                $unitNumber = $base + $i;
                $units[] = [
                    'property_id' => 2,
                    'units_name' => (string)$unitNumber,
                    'status' => 'vacant',
                ];
            }
        }

        // Add Commercial units for property_id = 2
        $units[] = [
            'property_id' => 2,
            'units_name' => 'Commercial 1',
            'status' => 'vacant',
        ];

        // Units for property_id = 3 (301–309, 401–409, 501–509, 601–609)
        foreach ([300, 400, 500, 600] as $base) {
            for ($i = 1; $i <= 9; $i++) {
                $unitNumber = $base + $i;
                $units[] = [
                    'property_id' => 3,
                    'units_name' => (string)$unitNumber,
                    'status' => 'vacant',
                ];
            }
        }

        // Add Commercial units for property_id = 3
        $units[] = [
            'property_id' => 3,
            'units_name' => 'Commercial ground',
            'status' => 'vacant',
        ];

        $units[] = [
            'property_id' => 3,
            'units_name' => 'Commercial 2nd',
            'status' => 'vacant',
        ];

        DB::table('units')->insert($units);
    }
}
