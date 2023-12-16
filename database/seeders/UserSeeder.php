<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create([
            "name"=> "mohammed",
            "phone"=>"07703988345",
            "email"=> "mohammed@gmail.com",
            "address"=>"karbala",
            "password"=> bcrypt("password"),
            "user_type_id"=> 1,
            "workStart"=>"8:00",
            "workEnd"=>"16:00",
            "isActive"=>1,
            "salary"=> "1000000",
        ]);

        User::create([
            "name"=> "ali",
            "phone"=>"07703988345",
            "email"=> "ali@gmail.com",
            "address"=>"karbala",
            "password"=> bcrypt("password"),
            "user_type_id"=> 2,
            "workStart"=>"8:00",
            "workEnd"=>"16:00",
            "isActive"=>1,
            "salary"=> "800000",
        ]);

        User::create([
            "name"=> "abbas",
            "phone"=>"07703988345",
            "email"=> "mohammedgalsalih@gmail.com",
            "address"=>"karbala",
            "password"=> bcrypt("password"),
            "user_type_id"=> 3,
            "workStart"=>"8:00",
            "workEnd"=>"16:00",
            "isActive"=>1,
            "salary"=> "1000000",
        ]);

        User::factory()->count(10)->create();

            



        

    }
}
