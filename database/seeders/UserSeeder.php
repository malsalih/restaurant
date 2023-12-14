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
            "name"=> "علي",
            "phone"=>"07823331432",
            "email"=> "abbas@gmail.coom",
            "address"=>"karbala",
            "password"=> bcrypt("password"),
            "user_type_id"=> 1,
            "workStart"=>"8:00",
            "workEnd"=>"14:00",
            "isActive"=>1,
            "salary"=> "1000000",
        ]);

    }
}
