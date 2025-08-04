<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TenantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tenants')->insert([
            [
                'fullname' => 'Russel Huberts Tenant',
                'username' => 'russeltenant1',
                'password' => Hash::make('123456789'),
                'email' => 'russelhubertstenant@gmail.com',
                'phone_number' => '09123456789',
                'address' => 'Calingatan Mataasnakahoy Batangas',
                'move_in_date' => '2025-08-04',
                'move_out_date' => '2025-09-04',
                'unit_id' => 1,
                'property_id' => 1,
                'otp_code' => null,
                'is_approved' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fullname' => 'Russel JJS1 Tenant',
                'username' => 'russeltenant2',
                'password' => Hash::make('123456789'),
                'email' => 'russeljjs1tenant@gmail.com',
                'phone_number' => '09495748312',
                'address' => 'Sample lang jjs1',
                'move_in_date' => '2025-08-15',
                'move_out_date' => '2025-09-15',
                'unit_id' => 16,
                'property_id' => 2,
                'otp_code' => null,
                'is_approved' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fullname' => 'Russel JJS2 Tenant',
                'username' => 'russeltenant3',
                'password' => Hash::make('123456789'),
                'email' => 'russeljjs3tenant@gmail.com',
                'phone_number' => '09495748315',
                'address' => 'Sample lang jjs2',
                'move_in_date' => '2025-08-25',
                'move_out_date' => '2025-09-25',
                'unit_id' => 24,
                'property_id' => 3,
                'otp_code' => null,
                'is_approved' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
