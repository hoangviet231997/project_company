<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Lang;

class customer_supplier_search extends Model
{
    protected $table = 'customer_supplier';

    public function rules(Request $request)
    {
        return [
            "name" => 'max:255',
            "status" => 'integer|between:0,1'
        ];
    }

    public function messages()
    {
        return Lang::get('validation');
    }
}