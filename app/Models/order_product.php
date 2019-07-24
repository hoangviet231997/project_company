<?php

namespace App\Models;

use App\Helper\Constant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class order_product extends Model
{
    protected $table = 'order_product';
	public $timestamps = false;
	protected $casts = ['id' => 'string'];
	public $incrementing = false;

	public static function updateInpriceInProductOrder($product_id, $shop_id, $in_price) {
        $update_inprice = order_product::where(['shop_id' => $shop_id, 'product_id' => $product_id])->update([
            'order_product_inprice' => $in_price,
        ]);

        return $update_inprice;
    }

    public static function updateInventoryFlag($product_id, $shop_id) {
	    $data = order_product::where(['shop_id' => $shop_id, 'product_id' => $product_id])->update(['inventory_created_flg' => 1]);
	    return $data;
    }

    public static function reportTopSaleProduct($shop_ids) {
	    $data = order_product::select(
	        'product_name', DB::raw('sum(number)as number')
        )
            ->whereIn('shop_id', $shop_ids)
            ->where(['order_product_invalid' => 0, 'status' => 1])
            ->groupBy('product_id')
            ->orderBy('number', 'desc')
            ->limit(Constant::LIMIT_TOP_SALE_PRODUCT)
            ->get();
	    $data_product = [];
	    foreach ($data as $item) {
            $data_product['quantity'][] = $item->number;
            $data_product['product'][] = $item->product_name;
        }
	    return $data_product;
    }
}
