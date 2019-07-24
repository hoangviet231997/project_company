<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class product_unit extends Model
{
    protected $table = 'product_master_unit';
    protected $fillable = [
        'shop_id',
        'product_master_id',
        'unit_id',
        'unit_name',
        'unit_exchange',
        'price',
        'alert_flg',
        'is_primary',
		'regdate',
        'invalid',
    ];
    public $timestamps = false;

    public function invalidById($id) {
        return $this->find($id)->update(['invalid' => 1]);
    }

    public function findById($id) {
        return $this->where('id',$id)
        ->where('invalid',0)
        ->first();
    }

    public function findByProductId($id) {
        return $this->where('product_master_id',$id)->where('invalid',0)->get();
    }

    public static function getProductUnit($shop_id, $product_ids = null){
        $query = product_unit::where(['shop_id' => $shop_id, 'invalid' => 0]);
        if(!is_null($product_ids)) {
            $query->whereIn('product_master_id', $product_ids);
        }
        $query = $query->get();
        return $query->makeHidden(['invalid']);
    }

    public static function getListProductUnitByProductMaster($master_id, $shop_id) {
        $query_units = product_unit::where([
            'product_master_id' => $master_id,
            'shop_id' => $shop_id,
            'invalid' => 0,
        ])->get();
        return $query_units->makeHidden(['invalid']);
    }

    public static function updatePriceUnit($shop_id, $product_id, $unit_id, $price) {
        $product_master_id = product::getProductMasterId($product_id, $shop_id);
        if($product_master_id) {
            product_unit::where([
                'product_master_id' => $product_master_id,
                'unit_id' => $unit_id,
                'shop_id' => $shop_id,
                'invalid' => 0
            ])->update(['price' => $price]);
        }
    }
}
