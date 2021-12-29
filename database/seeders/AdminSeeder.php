<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'first_name' => 'Dana',
            'last_name' => 'Allam',
            'email' => 'dana@gmail.com',
            'password' => bcrypt('123'),
        ]);
    }
}
