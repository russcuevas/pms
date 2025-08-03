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
            'fullname' => 'Admin Sample',
            'username' => 'adminhubert',
            'password' => bcrypt('123456789'),
            'email' => 'russelcuevas01@gmail.com',
            'phone_number' => '09495748301',
            'address' => 'Manila',
            'property_id' => 1,
            'is_approved' => 1,
        ]);
    }
}
