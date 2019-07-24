<?php

namespace App\Models;

use App\Helpers\Util;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class shop_order_statistic extends Model {
	protected $table = 'shop_order_statistic';
	public $timestamps = false;

	public static function getOrderCodeByShopId($shop_id) {
		$shop_order_statistic = DB::table('shop_order_statistic')->where('shop_id', '=', $shop_id)->lockForUpdate()->first();
		$order_code = $shop_order_statistic->prefix_order_code ? $shop_order_statistic->prefix_order_code : Constant::PREFIX_ORDER_CODE_DEFAULT;
		$expire_date = $shop_order_statistic->expire_date;
		$now = Util::getNow();

		if($now < $expire_date) {
			$next_total_order = $shop_order_statistic->total_order + 1;
			DB::update('update shop_order_statistic set total_order = ? where shop_id = ?', [$next_total_order, $shop_id]);
		}
		else {
			$next_total_order = 1;
			$expire_order_code = $shop_order_statistic->expire_order_code;
			if($expire_order_code == 1) {//day
				$next_expire_date = date('Y-m-d', strtotime('+1 day'));
			}
			else if($expire_order_code == 2) { //month
				$next_expire_date = date('Y-m-01', strtotime('+1 month'));
			}
			else { //year default
				$next_expire_date = date('Y-01-01', strtotime('+1 year'));
			}

			DB::update('update shop_order_statistic set total_order = 1, expire_date = ? where shop_id = ?', [$next_expire_date, $shop_id]);
		}

		return $order_code.Util::getPrefixZero($next_total_order, 5);
	}

	public static function addDefaultShopOrderStatistic($shop_id) {
	    $shop = shop_order_statistic::where(['shop_id' => $shop_id])->first();
	    if(!$shop) {
            $data = [
                'shop_id' => $shop_id,
                'prefix_order_code' => 'BH',
                'expire_order_code' => 1,
                'expire_date' => date('Y-m-d H:i:s', strtotime('+1 days'))
            ];
            try {
                shop_order_statistic::insert($data);
            }
            catch (\Exception $e) {
                throw new \Exception($e->getMessage() . 'order_statis');
            }
        }
    }
}
