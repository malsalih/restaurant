<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderType extends Model
{
    use HasFactory;

    function order(){
        return $this->hasMany(Order::class);
    }

    function bill(){
        return $this->hasMany(Bill::class);
    }
    
}
