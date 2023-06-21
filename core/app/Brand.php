<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];

    protected $casts = [
        'meta_keywords' => 'array'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
