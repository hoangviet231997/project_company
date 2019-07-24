<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Lang;

class product_category_search extends Model
{
    protected $table = 'product_category';

    public function rules(Request $request)
    {
        return [
            "category_name" => 'max:200',
            "status" => 'integer|between:0,1'
        ];
    }

    public function messages()
    {
        return Lang::get('validation');
    }
}