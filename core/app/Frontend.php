<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Frontend extends Model
{
    protected $guarded = ['id'];

    protected $table = "frontends";
    protected $casts = [
        'data_values' => 'object'
    ];

    public function labelText($color_name)
    {
        if($color_name == 'Red'){
            return 'danger';
        }elseif($color_name == 'Green'){

            return 'success';
        }elseif($color_name == 'Blue'){
            return 'primary';
        }elseif($color_name == 'Yellow'){
            return 'warning';
        }elseif($color_name == 'Gray'){
            return 'secondary';
        }else{
            return 'dark';
        }
    }

    public static function scopeGetContent($data_keys)
    {
        return Frontend::where('data_keys', $data_keys);
    }
}
