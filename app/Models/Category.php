<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        "category",
    ];

    function menu_item(){
        return $this->hasMany(MenuItem::class);
    }

    function user(){
        return $this->hasMany(User::class);
    }

    
}
