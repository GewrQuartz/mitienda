<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssignProductAttribute extends Model
{
    protected $guarded  = ['id'];


    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function productAttribute()
    {
        return $this->belongsTo(ProductAttribute::class, 'product_attribute_id');
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class, 'assign_product_attribute_id');
    }

}
