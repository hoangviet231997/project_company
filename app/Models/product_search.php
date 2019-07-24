<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Lang;

class product_search extends Model
{
    protected $table = 'product';
    protected $primaryKey = 'product_id';

    public function rules(Request $request)
    {
        return [
            "product_name" => 'max:200',
            "available" => 'boolean',
            "product_category_id" => 'integer|nullable',
        ];
    }

    public function messages()
    {
        return Lang::get('validation');
    }
}