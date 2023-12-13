<?php

namespace Database\Seeders;

use App\Models\UserType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        UserType::create(['type'=>'مدير']);
        UserType::create(['type'=>'موظف']);
        UserType::create(['type'=>'كاشير']);
        UserType::create(['type'=>'طباخ']);
        UserType::create(['type'=>'مساعد طباخ']);
        UserType::create(['type'=>'خدمة توصيل']);
        UserType::create(['type'=>'عامل نظافة']);


    }
}
