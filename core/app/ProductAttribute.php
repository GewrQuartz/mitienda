<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    protected $guarded = ['id'];

    public function assignAttributes()
    {
        return $this->hasMany(AssignProductAttribute::class, 'product_attribute_id');
    }
}
