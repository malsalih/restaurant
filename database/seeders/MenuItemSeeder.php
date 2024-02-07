<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        MenuItem::create([            
            "name"=>"مندي",
            "category_id"=>1,
            "price"=>18,
            "discounted_price"=>15,
            "offer"=>1,
            "details"=>"مندي يمني",
            "available"=>"1",
            "prep_time"=>"00:45",

        ]);


        MenuItem::create([            
            "name"=>"بيتزا كبيره",
            "category_id"=>2,
            "price"=>12,
            "discounted_price"=>8,
            "offer"=>0,
            "details"=>"بيتزا",
            "available"=>1,
            "prep_time"=>'00:30',
        ]);

        MenuItem::create([            
            "name"=>"بيتزا صغيره",
            "category_id"=>2,
            "price"=>6,
            "discounted_price"=>4,
            "offer"=>0,
            "details"=>"بيتزا",
            "available"=>1,
            "prep_time"=>'00:20',
        ]);

        MenuItem::create([            
            "name"=>"همبركر",
            "category_id"=>3,
            "price"=>6,
            "discounted_price"=>4,
            "offer"=>0,
            "details"=>"همبركر",
            "available"=>1,
            "prep_time"=>'00:20',
        ]);

        MenuItem::create([            
            "name"=>"كباب",
            "category_id"=>4,
            "price"=>10,
            "discounted_price"=>8,
            "offer"=>0,
            "details"=>"كباب",
            "available"=>1,
            "prep_time"=>'00:25',
        ]);
        MenuItem::factory()->count(20)->create();
    }
}
