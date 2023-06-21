<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $guarded  = ['id'];
    protected $casts    = ['attributes'=>'array'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function attributes()
    {
        return $this->belongsTo(AssignProductAttribute::class, 'attributes');
    }
}
