<?php

namespace Database\Factories;

use App\Models\MenuItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'bill_id'=> rand(1,40),
                'customer_id'=>rand(1,20),
                'order_type_id'=>rand(1,3),
                'desk_id'=> rand(1,50),
                'order_status_id'=> rand(1,4),
                'notes'=> fake()->text(7),
                'menu_item_id'=>rand(1,25),
                'item_count'=>rand(1,4),
                'category_id'=>rand(1,6),
                
        ];
    }
}
