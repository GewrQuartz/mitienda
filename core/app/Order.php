<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = ['id'];

    public function appliedCoupon()
    {
        return $this->hasOne(AppliedCoupon::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deposit()
    {
        return $this->hasOne(Deposit::class, 'order_id', 'id')->latest()->withDefault();;
    }

    public function products()
    {
        return $this->hasManyThrough(Product::class, OrderDetail::class, 'order_id', 'id');
    }


    public function orderDetail()
    {
        return $this->hasMany(OrderDetail::class);
    }


    public function getAmountAttribute()
    {
        return $this->total_amount - $this->shipping_charge;
    }

    public function scopePending()
    {
        return $this->where('status', 0)->where('payment_status',1);
    }
}
