<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "phone",
        "address",
    ];


    function order(){
        return $this->hasMany(Order::class);
    }
    function bill(){
        return $this->hasMany(Bill::class);
    }

}
