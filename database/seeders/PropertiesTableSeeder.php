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
                'property_name' => 'Huberts Residence',
                'property_email' => 'noreply.hubertresidences@gmail.com',
                'property_phone_number' => '09188100393',
            ],
            [
                'property_name' => 'JJS 1 Bldg',
                'property_email' => 'noreply.lavismin@gmail.com',
                'property_phone_number' => '09188100393',
            ],
            [
                'property_name' => 'JJS 2 Bldg',
                'property_email' => 'noreply.jjsandhproperty@gmail.com',
                'property_phone_number' => '09188100393',
            ],
        ]);
    }
}
