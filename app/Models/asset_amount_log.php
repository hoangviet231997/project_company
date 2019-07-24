<?php

namespace App\Models;

use App\Helper\Constant;
use App\Helpers\Util;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class asset_amount_log extends Model
{
    protected $table = 'asset_amount_log';
    public $timestamps = false;

	public static function updateAssetAmountLog($asset_id, $shop_id, $asset_total, $business_date_timestamp, $type) {
		$asset_amount_log = asset_amount_log::where([
			'asset_id' => $asset_id,
			'shop_id' => $shop_id,
			'datelog_business_date_timestamp' => $business_date_timestamp,
		])->first();

		if(!$asset_amount_log) {
			$pre_asset_amount_log = asset_amount_log::getPreAssetAmountLogByAssetId($asset_id, $shop_id, $business_date_timestamp);
			$pre_asset_total = $pre_asset_amount_log ? $pre_asset_amount_log->after_asset_total : 0;

			$asset_amount_log = new asset_amount_log();
			$asset_amount_log->asset_id = $asset_id;
			$asset_amount_log->shop_id = $shop_id;
			$asset_amount_log->pre_asset_total = $pre_asset_total;
			$asset_amount_log->asset_total = 0; //initial
			$asset_amount_log->datelog_business_date = date('Y-m-d', $business_date_timestamp);
			$asset_amount_log->datelog_business_date_timestamp = $business_date_timestamp;
		}

		if($type == Constant::TRASACTION_TYPE_IMPORT) {
			$asset_amount_log->asset_total += $asset_total;
		}
		else {
			$asset_amount_log->asset_total -= $asset_total;
		}

		$asset_amount_log->after_asset_total = $asset_amount_log->pre_asset_total + $asset_amount_log->asset_total;
		$asset_amount_log->lastupdate = Util::getNow();
		$asset_amount_log->save();

		//update pre, after asset total after asset amount log
		asset_amount_log::updatePreAfterAssetTotalAfterAssetAmountLog($asset_id, $shop_id, $type, $asset_total, $business_date_timestamp);
	}

	public static function getPreAssetAmountLogByAssetId($asset_id, $shop_id, $business_date_timestamp) {
		return asset_amount_log::where([
			'asset_id' => $asset_id,
			'shop_id' => $shop_id,
		])->where('datelog_business_date_timestamp', '<', $business_date_timestamp)
		  ->orderByRaw('datelog_business_date_timestamp desc, id desc')
		  ->first();
	}

	public static function updatePreAfterAssetTotalAfterAssetAmountLog($asset_id, $shop_id, $type, $asset_total, $business_date_timestamp) {
		$operator = $type == 1 ? '+' : '-';
		$sql = <<<EOD
update `asset_amount_log` 
set pre_asset_total = pre_asset_total {$operator} {$asset_total}, 
after_asset_total = after_asset_total {$operator} {$asset_total} 
where shop_id = '{$shop_id}' and datelog_business_date_timestamp > '{$business_date_timestamp}' and asset_id = '{$asset_id}'
EOD;
		DB::update($sql);
	}
}
