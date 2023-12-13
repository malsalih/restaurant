<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Category::create(['category'=>'تمن ومرق']);
        Category::create(['category'=>'بيتزا']);
        Category::create(['category'=>'ساندويجات']);
        Category::create(['category'=>'مشويات']);
        Category::create(['category'=>'مشروبات']);
        Category::create(['category'=>'مقبلات']);


    }
}
