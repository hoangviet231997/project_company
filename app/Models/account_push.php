<?php

namespace App\Models;

use App\Helper\Constant;
use Illuminate\Database\Eloquent\Model;
use DB;

class account_push extends Model
{
    protected $table = 'account_push';
    const CREATED_AT = 'regdate';
    public $timestamps = false;

    public static function saveAccountPush($account_id, $shop_id, $push_id, $device_id, $device_type, $build_version = null, $device_name = null, $os_version = null, $app_type = null, $langcode = null) {
        self::deleteAccountPushByDeviceId($device_id, $app_type);
		$langcode = $langcode ? $langcode : Constant::DEFAULT_LANGCODE;
		$device_type = intval($device_type);

		$account_push = new account_push;
        $account_push->account_id = $account_id;
        $account_push->shop_id = $shop_id;
        $account_push->push_id = $push_id;
        $account_push->device_id = $device_id;
        $account_push->device_type = $device_type;
        if(!is_null($app_type))
            $account_push->app_type = $app_type;
        else {
            if($device_type == Constant::DEVICE_TYPE_ANDROID)
                $account_push->app_type = Constant::APP_TYPE_ANDROID_STAFF;
            else
                $account_push->app_type = Constant::APP_TYPE_IOS_USER;
        }
        $account_push->is_push = 1;
        $account_push->build_version = $build_version;
        $account_push->device_name = $device_name;
        $account_push->langcode = $langcode;
        $account_push->os_version = $os_version;
        $account_push->save();
    }

    public static function deleteAccountPushByDeviceId($device_id, $app_type = null) {
        if(!is_null($app_type)) {
			return account_push::where([
	            	'device_id' => $device_id,
					'app_type' => $app_type
				])->delete();
		}
        else {
			return account_push::where('device_id', $device_id)->delete();
		}
    }

    public static function getPushInfoShopByAccountServiceIds($account_service_ids, $shop_id, $device_id = '') {
    	$role_recevice_noti_order = Constant::ROLE_PERMISSION_RECEIVE_NOTI_ORDER;
    	$app_type_android_staff = Constant::APP_TYPE_ANDROID_STAFF;

    	$account_service_ids_sql = $account_service_ids ? "or a.id in ({$account_service_ids})" : '';

    	$sql = <<<EOD
select ap.push_id, ap.device_type, ap.app_type, ap.langcode
from account a
join account_shop ash on a.id = ash.account_id and ash.shop_id = '{$shop_id}' 
join account_push ap on a.id = ap.account_id
left join role_permission rp on ash.role_permission_id = rp.id and 
(
	role_permission like '{$role_recevice_noti_order},%' or 
	role_permission = '{$role_recevice_noti_order}' or 
	role_permission like '%,{$role_recevice_noti_order}' or
	role_permission like '%,{$role_recevice_noti_order},%'
)
where ap.shop_id = '{$shop_id}' and (rp.id is not null {$account_service_ids_sql}) and ap.device_id != '{$device_id}' and ap.is_push = 1
and ap.app_type = '{$app_type_android_staff}' 
EOD;
    	$account_pushs = DB::select($sql);
    	$push_infos = [];

    	foreach ($account_pushs as $account_push) {
    		if($account_push->device_type == Constant::DEVICE_TYPE_ANDROID) {
				$push_infos['android'][$account_push->langcode][] = $account_push->push_id;
			}
			else if($account_push->device_type == Constant::DEVICE_TYPE_IOS) {
				$push_infos['ios'][$account_push->langcode][] = $account_push->push_id;
			}
		}

		return $push_infos;
	}
}
