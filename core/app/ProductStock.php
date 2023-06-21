<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    protected $guarded  = ['id'];

    public function stockLogs()
    {
        return $this->hasMany(StockLog::class, 'stock_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
