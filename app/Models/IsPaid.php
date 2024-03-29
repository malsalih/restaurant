<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IsPaid extends Model
{
    use HasFactory;
    protected $fillable = [
        "state",
    ];

    function bill(){
        return $this->hasMany(IsPaid::class);
    }
}
