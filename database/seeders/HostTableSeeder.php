<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            'fullname' => 'Host Sample',
            'username' => 'host',
            'password' => bcrypt('123456789'),
            'email' => 'russelcuevas0@gmail.com',
            'phone_number' => '09495748302',
            'address' => '#83 Calingatan Mataasnakahoy Batangas',
        ]);
    }
}
