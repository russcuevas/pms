<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('hosts')->insert([
            [
                'fullname' => 'Host Hubert',
                'username' => 'Host@hubert',
                'password' => bcrypt('Hubert@63'),
                'email' => 'hubert@gmail.com',
                'phone_number' => '09495748301',
                'address' => 'Sample Address Main',
            ],
            [
                'fullname' => 'Host Shen',
                'username' => 'Host@shen',
                'password' => bcrypt('Shen@31'),
                'email' => 'shen@gmail.com',
                'phone_number' => '09171234567',
                'address' => 'Sample Address 1',
            ],
            [
                'fullname' => 'Host Jeff',
                'username' => 'Host@jeff',
                'password' => bcrypt('jeff@27'),
                'email' => 'jeff@gmail.com',
                'phone_number' => '09281234567',
                'address' => 'Sample Address 2',
            ],
            [
                'fullname' => 'Host Jhonrell',
                'username' => 'Host@jhonrell',
                'password' => bcrypt('Jhon@33'),
                'email' => 'jhonrell@gmail.com',
                'phone_number' => '09391234567',
                'address' => 'Sample Address 3',
            ],
        ]);
    }
}
