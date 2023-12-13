<?php

namespace Database\Seeders;

use App\Models\IsPaid;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IsPaidSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        IsPaid::create(['state'=>'قيد الانتظار']);
        IsPaid::create(['state'=>'تم الاستلام']);
        IsPaid::create(['state'=>'ملغى']);


    }
}
