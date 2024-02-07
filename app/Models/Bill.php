<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Bill extends Model
{
    use HasFactory,Notifiable;
    protected $fillable = [
        "user_id","total_price","final_price","discount","order_type_id","is_paid_id","customer_id","preparation_time",
    ];

    function order(){
        return $this->belongsTo(Order::class);
    }

    function order_type(){
        return $this->belongsTo(OrderType::class);
    }
    function user(){
        return $this->belongsTo(User::class);
    }

    function customer(){
        return $this->belongsTo(Customer::class);
    }

    function is_paid(){
        return $this->belongsTo(IsPaid::class);
    }
}
