<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admins')->insert([
            [
                'fullname' => 'Admin Hubert',
                'username' => 'adminhubert',
                'password' => bcrypt('123456789'),
                'email' => 'russelcuevas01@gmail.com',
                'phone_number' => '09495748301',
                'address' => 'Manila',
                'property_id' => 1,
                'is_approved' => 1,
            ],
            [
                'fullname' => 'Admin Jjs1',
                'username' => 'adminjjs1',
                'password' => bcrypt('123456789'),
                'email' => 'russelcuevas011@gmail.com',
                'phone_number' => '09495748301',
                'address' => 'Manila',
                'property_id' => 2,
                'is_approved' => 1,
            ],
            [
                'fullname' => 'Admin Jjs2',
                'username' => 'adminjjs2',
                'password' => bcrypt('123456789'),
                'email' => 'russelcuevas0111@gmail.com',
                'phone_number' => '09495748301',
                'address' => 'Manila',
                'property_id' => 3,
                'is_approved' => 1,
            ],
        ]);
    }
}
