<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chef extends Model
{
    use HasFactory;

    // protected $primaryKey = 'category_id';
    // public $incrementing = false;


    protected $fillable = [
        "chef",
        "category_id",
    ];

    

   

    // function menuItem()
    // {
    //     return $this->belongsToMany(Category::class, 'menu_items')
    //     ->withPivot('id', 'chef_id', 'category_id','price')
    //     // ->as(Test::class)
    //     ->withTimestamps();
    // }

    // // function category() {
    // //     return $this->belongsTo(Category::class);
    // // }

    // function user() {
    //     return $this->belongsTo(User::class);
    // }
}
