<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "chef_id",
        "category_id",
        "price",
        "discounted_price",
        "offer",
        "image",
        "details",
        "available",
        "prep_time",
    ];
    

    function getImageAttribute($image)
    {
        if($image != null) {
            return asset('uploads/items/'.$image);
        }

        return null;
    }

    function order(){
        return $this->hasMany(Order::class);
    }

    function category(){
        return $this->belongsTo(Category::class);
    }
}
