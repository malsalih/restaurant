<?php

namespace Database\Seeders;

use App\Models\Bill;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Order::factory()->count(100)->create()->each(function ($order){
            $order->fill([
                'price'=>MenuItem::where('id',$order->menu_item_id)->first()->price,
                'done_by'=>User::where('user_type_id',4)->where('category_id',$order->category_id)->first()->id,
            ])
                ->save();
                
            
            });

        
    
    }
}
