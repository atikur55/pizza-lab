<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }
    public function deposit()
    {
        return $this->hasOne(Deposit::class, 'order_id');
    }
    public function orderDetail()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    public function scopePending()
    {
        return $this->where('status', 2);
    }

    public function scopeProcessing()
    {
        return $this->where('status', 3);
    }

    public function scopeDelivered()
    {
        return $this->where('status', 1);
    }

    public function scopeCancelled()
    {
        return $this->where('status', 4);
    }

    public function statusBadge(): Attribute
    {
        return new Attribute(
            get:fn () => $this->badgeData(),
        );
    }

    public function badgeData(){
        $html = '';
        if($this->status == 0){
            $html = '<span class="badge badge--dark">'.trans('Initiated').'</span>';
        }elseif($this->status == 1){
            $html = '<span><span class="badge badge--success">'.trans('Delivered').'</span><br>'.diffForHumans($this->updated_at).'</span>';
        }elseif($this->status == 2){
            $html = '<span><span class="badge badge--warning">'.trans('Pending').'</span><br>'.diffForHumans($this->updated_at).'</span>';
        }elseif($this->status == 3){
            $html = '<span><span class="badge badge--primary">'.trans('Processing').'</span><br>'.diffForHumans($this->updated_at).'</span>';
        }elseif($this->status == 4){
            $html = '<span><span class="badge badge--danger">'.trans('Cancelled').'</span><br>'.diffForHumans($this->updated_at).'</span>';
        }
        return $html;
    }
}
