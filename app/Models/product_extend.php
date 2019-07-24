<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class product_extend extends Model
{
    protected $table = 'product_extend';
    protected $fillable = [
        'shop_id',
        'product_id',
        'extend_barcode',
        'batch_no',
        'batch_expire_date',
        'regdate',
        'invalid'
    ];
    public $timestamps = false;

    public static function getListProductExtend($shop_id){
        $query = product_extend::where(['shop_id' => $shop_id, 'invalid' => 0])->get();
        return $query->makeHidden(['invalid']);
    }

    public static function checkExistsProductExtend($product_id, $shop_id, $batch_no, $batch_expire_date) {
        $product_extend = product_extend::select('id')
            ->where([
                'shop_id' => $shop_id,
                'product_id' => $product_id,
                'batch_no' => trim($batch_no),
            ])
            ->first();
        if($product_extend) {
            return $product_extend->id;
        }
        else {
            $product_extend = new product_extend();
            $product_extend->shop_id = $shop_id;
            $product_extend->product_id = $product_id;
            $product_extend->batch_no = $batch_no;
            $product_extend->extend_barcode = self::genExtendBarCode($shop_id);
            $product_extend->batch_expire_date = $batch_expire_date;
            $product_extend->regdate = Carbon::now()->format('Y-m-d H:i:s');
            $product_extend->save();

            return $product_extend->id;
        }
    }

    public static function getListProductExtendByShopid($product_id = null, $shop_id, $product_ids = null) {
        $product_extend = product_extend::where([
            'product_extend.shop_id' => $shop_id,
            'product_extend.invalid' => 0
        ]);
        if(is_null($product_ids)) {
            $product_extend->where([
                'product_extend.product_id' => $product_id
            ]);
        }
        else{
            $product_extend->whereIn('product_extend.product_id', $product_ids);
        }

        $product_extend = $product_extend->leftJoin('inventory_master', function ($join) {
            $join->on('inventory_master.shop_id', '=', 'product_extend.shop_id')
                ->on('inventory_master.product_id', '=', 'product_extend.product_id')
                ->on('inventory_master.product_extend_id', '=', 'product_extend.id');
        })
        ->Join('product', function ($join) {
                $join->on('product.product_id', '=', 'product_extend.product_id');
        })
        ->select(
            'product_extend.product_id',
            'product.unit_name',
            'product.unit_id',
            'product_extend.batch_no',
            'product_extend.batch_expire_date',
            'inventory_master.total_balance as stock_quantity'
        )->get();
        
        return $product_extend;
    }
    protected static function genExtendBarCode($shop_id) {
        $arr_prefix = [
            1 => 'BCODE',
        ];
        $arr_limit = array(
            '10' => '000000',
            '100' => '00000',
            '1000' => '0000',
            '10000' => '000',
            '100000' => '00',
            '1000000' => '0',
            '10000000' => '',
        );

        $code = $arr_prefix[1];
        $query_count = product_extend::select('id')->where('shop_id', $shop_id)->count();
        $total_record = $query_count + 1;
        foreach ($arr_limit as $key => $value) {
            if ($total_record < $key) {
                return $code . $value . $total_record;
            }
        }
    }
    
    public static function getProductExtendByid($product_extend_id) {
        $data = product_extend::where(['id' => $product_extend_id, 'invalid' => 0])->first();
        return $data;
    }
}
