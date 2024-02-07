<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MenuItem>
 */
class MenuItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
                        
                "name"=>fake()->text(10),
                "category_id"=>rand(1,6),
                "price"=>rand(2,25),
                "discounted_price"=>rand(2,15),
                "offer"=>rand(0,1),
                "details"=>fake()->text(),
                "available"=>rand(0,1),
                "prep_time"=>fake()->time( 'H:i:s' ,'00:45:00'),
    
        ];
    }
}
