<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        OrderStatus::create(["status"=>"التهيئة"]);
        OrderStatus::create(["status"=>"في التوصيل"]);
        OrderStatus::create(["status"=>"ملغى"]);
        OrderStatus::create(["status"=>"كامل"]);

    }
}
