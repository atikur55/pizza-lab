<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pizza extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function pizzaGallery()
    {
        return $this->hasMany(PizzaGallery::class, 'pizza_id');
    }

    public function pizzaSize()
    {
        return $this->hasMany(PizzaSize::class, 'pizza_id');
    }

    public function pizzaPrice()
    {
        return $this->hasOne(PizzaSize::class)->orderBy('price', 'asc');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'pizza_id');
    }

    public function scopeActive()
    {
        return $this->where('status', 1)
            ->whereHas('category', function ($query) {
                $query->where('status', 1);
            });
    }
}
