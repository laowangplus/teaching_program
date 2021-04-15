<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \Illuminate\Support\Facades\DB::table('admins')->insert([
            'name' => 'root'.rand(1,100),
            'password' => md5('12345'),
            'sex' => 1,
            'phone' => rand(17800000000,17899999999),
            'number' => rand(100, 999),
            'age' => 18
        ]);
    }
}
