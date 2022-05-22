<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function pizza()
    {
        return $this->belongsTo(Pizza::class, 'pizza_id');
    }

    public static function subtotal()
    {
        return self::where('user_id', auth()->id())->whereHas('pizza', function ($pizza) {
            $pizza->where('status', 1);
        })->sum('total');
    }
}
