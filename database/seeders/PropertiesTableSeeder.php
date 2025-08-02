<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('properties')->insert([
            [
                'property_name' => 'huberts residence',
                'property_email' => 'russelhubertsresidence@gmail.com',
                'property_phone_number' => '09495748302',
            ],
            [
                'property_name' => 'jjs 1 bldg',
                'property_email' => 'russeljjs1@gmail.com',
                'property_phone_number' => '09495748301',
            ],
            [
                'property_name' => 'jjs 2 bldg',
                'property_email' => 'russeljjs2@gmail.com',
                'property_phone_number' => '09495748303',
            ],
        ]);
    }
}
