<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;
    protected $fillable = [
        "cashier_id","total_price","final_price","discount","order_type_id","is_paid_id",
    ];

    function order(){
        return $this->belongsTo(Order::class);
    }
}
