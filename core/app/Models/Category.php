<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function pizza() {
        return $this->hasMany(Pizza::class, 'category_id');
    }

    public function scopeActive() {
        return $this->where('status', 1);
    }
}
