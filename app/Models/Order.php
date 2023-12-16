<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Order extends Model
{
    use HasApiTokens,HasFactory;
    protected $fillable = [
        'customer_id',
        'bill_id',
        'user_id',
        'category_id',
        'menu_item_id',
        'item_count',
        'price',
        'order_type_id',
        'desk_id',
        'order_status_id',
        'done_by',
        'notes',
    ];




    function menu_item(){
        return $this->belongsTo(MenuItem::class);
    }

    function order_type(){
        return $this->belongsTo(OrderType::class);
    }

    function order_status(){
        return $this->belongsTo(OrderStatus::class);
    }

    function customer(){
        return $this->belongsTo(Customer::class);
    }

    function desk(){
        return $this->belongsTo(desk::class);
    }

    function bill(){
        return $this->hasMany(Bill::class);
    }



}
