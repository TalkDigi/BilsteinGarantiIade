<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $users = [
            "name" => "John Doe",
            "email"=> "umut.yilmaz@talk.com.tr",
            "password"=> bcrypt("test"),
            "created_at"=> now(),
        ];
        \DB::table('users')->insert($users);
    }
}
