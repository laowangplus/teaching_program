<?php

use Illuminate\Database\Seeder;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = new \Faker\Generator();
        \Illuminate\Support\Facades\DB::table('books')->insert([
            'name' => 'root'.rand(1,100),
            'password' => md5('12345'),
            'sex' => 1,
            'phone' => rand(17800000000,17899999999),
            'number' => rand(100, 999),
            'age' => 18,
            'jurisdiction' => 0,
        ]);
    }
}
