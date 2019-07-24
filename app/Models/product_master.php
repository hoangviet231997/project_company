<?php

namespace App\Models;

use App\Helpers\Util;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Lang;

class product_master extends Model
{
    protected $table = 'product_master';
    protected $primaryKey = 'product_master_id';
    protected $fillable = [
        'shop_id',
        'product_name',
        'product_code',
        'product_barcode',
        'feature',
        'rack_info',
        'info1',
        'info2',
        'info3',
        'info4',
        'info5',
        'info6',
        'description',
        'short_name',
        'available',
        'receiptflg',
        'product_category_id',
        'default_price',
        'product_tax',
        'primary_unit_id',
        'primary_unit_name',
        'product_price',
        'product_thumbnail1',
        'product_thumbnail2',
        'product_thumbnail3',
        'product_thumbnail4',
        'direct_sell_flg',
        'point_get_flg',
        'online_sell_flg',
        'reseller_flg',
        'bill_material',
        'product_material',
        'combo',
        'batch_flg',
        'last_update',
        'invalid',
        'nameSortproduct',
        'product_type',
        'product_unit_type',
        'place_tag',
        'supplier_id',
        'supplier_name'
    ];
    public $timestamps = false;

    public function rules(Request $request)
    {
        return [
            "owner_product_id" => 'integer',
            "owner_shop_id" => 'integer',
            "product_name" => 'required|max:255', // Tên thuốc
//            "product_code" => 'required|max:255', // Mã hàng hóa
            "product_barcode" => 'max:255',
            //"feature" => 'max:255',
            "rack_info" => 'max:255',
            "unit_list" => 'required|max:255',
            //"product_list" => 'max:255',
//            "info1" => 'required|max:255',
//            "info2" => 'required|max:255',
//            "info3" => 'required|max:255',
//            "info4" => 'required|max:255',
//            "info5" => 'required|max:255',
//            "info6" => 'required|max:255',
            "description" => 'max:255',
            "short_name" => 'max:255',
            "available" => 'boolean', // Kích hoạt
            "receiptflg" => 'boolean', //Được bán theo đơn
            "product_category_id" => 'integer|nullable',
            "default_price" => 'integer|nullable',
            "product_tax" => 'integer|nullable',
            "primary_unit_id" => 'required|integer',
            "primary_unit_name" => 'max:255',
            "product_price" => 'required|integer',
            "direct_sell_flg" => 'boolean',
            'batch_flg' => 'boolean',
            "point_get_flg" => 'boolean',
            "online_sell_flg" => 'boolean',
            "reseller_flg" => 'boolean',
            "elememt_type" => 'integer|nullable',
            "nameSortproduct" => 'max:255'
        ];
    }

    public function messages()
    {
        return Lang::get('validation');
    }

    public function findAll() {
        return $this->where('invalid',0)->get();
    }
    public function findById($id) {
        return $this->where('product_master_id',$id)
        ->where('invalid',0)
        ->first();
    }

    public static function updateAttributeById($product_master_id, $key, $value){
        product_master::where('product_master_id', $product_master_id)
                                ->update([ $key => $value ]);
        $model = new product_master();
        $response = $model->findById($product_master_id);
        return $response;
    }

    public function invalidById($id) {
        return $this->where('product_master_id',$id)->update(['invalid' => 1]);
    }

//    public function getList($filter){
//        $query = $this->select(
//            'product_master_id',
//            'product_code',
//            'product_name',
//            'default_price',
//            'product_price',
//            'product_tax',
//            'available')
//        ->where('invalid',0);
//
//        if( isset($filter["product_name"]) && $filter["product_name"] != "") {
//            $query->where(function ($q) use ($filter) {
//                $q->where('product_name','like','%'.$filter["product_name"].'%')
//                ->orWhere('short_name', 'like', '%'.$filter["product_name"].'%')
//                ->orWhere('product_code', 'like', '%'.$filter["product_name"].'%');
//            });
//        }
//        if( isset($filter["available"]) && $filter["available"] != "") {
//            $query = $query->where('available',$filter["available"]);
//        }
//        if( isset($filter["product_category_id"])) {
//            $query = $query->where('product_category_id',$filter["product_category_id"]);
//        }
//        return $query->get();
//    }

    public static function getListProductMaster($shop_id){
		$product_masters = product_master::where(['shop_id' => $shop_id , 'invalid' => 0])->get();
        foreach ($product_masters as &$product_master) {
			$product_master['image1'] = Util::getUrlFile($product_master['product_thumbnail1'], 'product');
			$product_master['image2'] = Util::getUrlFile($product_master['product_thumbnail2'], 'product');
			$product_master['image3'] = Util::getUrlFile($product_master['product_thumbnail3'], 'product');
			$product_master['image4'] = Util::getUrlFile($product_master['product_thumbnail4'], 'product');
		}
        return $product_masters;
    }

    public static function updatePriceProductMaster($shop_id, $product_id, $unit_id, $price) {
        $product_master_id = product::getProductMasterId($product_id, $shop_id);
        product_master::where([
            'product_master_id' => $product_master_id,
            'primary_unit_id' => $unit_id,
            'invalid' => 0
        ])->update(['product_price' => $price]);
    }
}
