<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class product_feature extends Model
{
    protected $table = 'product_feature';
    protected $fillable = [
        'shop_id',
        'product_id',
        'feature_id',
        'feature_name',
        'feature_value',
        'invalid',
        'regdate'
    ];
    public $timestamps = false;
}