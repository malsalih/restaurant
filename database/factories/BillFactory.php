<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bill>
 */
class BillFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        return [
            //
            "user_id"=>rand(6,20),
            "total_price",
            "final_price",
            "discount",
            "order_type_id",
            "is_paid_id",
            "customer_id",
            "preparation_time",



        ];
    }
}
