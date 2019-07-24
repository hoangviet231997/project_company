<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Lang;

class inventory_transaction_master_search extends Model
{
    protected $table = 'inventory_transaction_master';
    public $timestamps = false;
    public function rules(Request $request)
    {
        return [
            "type" => "required|integer|in:1,2,3",
            "date_start" => "date|nullable",
            "date_end" => "date|nullable",
            "order_flag" => "boolean",
            "status" => "integer|in:0,1,2|nullable",
            //"order_status" => 'integer|in:0,1|nullable',
            "product_name" => 'max:255',
            "keyword" => 'max:255',
            "code" => 'max:255'
        ];
    }

    public function messages()
    {
        return Lang::get('validation');
    }
}