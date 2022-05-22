<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    public function pizza(){
        return $this->belongsTo(Pizza::class,'pizza_id');
    }
    public function order(){
        return $this->belongsTo(Order::class,'order_id');
    }
}
