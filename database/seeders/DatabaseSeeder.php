<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CustomerSeeder::class,
            IsPaidSeeder::class,
            MenuItemSeeder::class,
            DeskSeeder::class,
            OrderStatusSeeder::class,
            OrderTypeSeeder::class,
            CategorySeeder::class,
            UserTypeSeeder::class,
            UserSeeder::class,
            OrderSeeder::class,
        ]);
    }
}
