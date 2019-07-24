<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class shop_setting extends Model {
	protected $table = 'shop_setting';
	public $timestamps = false;

	public static function getShopSettingByShopId($shop_id) {
		return shop_setting::where('shop_id', $shop_id)->first();
	}

	public static function updateShopSettingById($data, $id=null){
		$query = shop_setting::updateOrInsert([ 'id' => $id ], $data);
		if($query){
			return true;
		}
		return false;
	}

	public static function addShopSettingDefault($shop_id) {
	    $shop = shop_setting::where(['shop_id' => $shop_id])->first();
	    if(!$shop) {
            $data = [
                'shop_id' => $shop_id,
                'order_flg' => 1,
                'print_column_amount_temp_flg' => 1
            ];
            try {
                shop_setting::insert($data);
            }
            catch (\Exception $e) {
                throw new \Exception(__($e->getMessage() . 'cant save shopsetting'), 1);
            }
        }
    }
}
