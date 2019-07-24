<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class customer_push extends Model
{
    protected $table = 'customer_push';

    public static function deleteCustomerPushByDeviceId($device_id, $app_type = null) {
        if(!is_null($app_type)) {
			return customer_push::where([
	            	'device_id' => $device_id,
					'app_type' => $app_type
				])->delete();
		}
        else {
			return customer_push::where('device_id', $device_id)->delete();
		}
	}
	
	public static function deleteCustomerPushByDeviceIdAndCustomerId($customer_id, $device_id, $app_type = null) {
        if(!is_null($app_type)) {
			return customer_push::where([
					'customer_id' => $customer_id,
	            	'device_id' => $device_id,
					'app_type' => $app_type
				])->delete();
		}
        else {
			return customer_push::where([
				'customer_id' => $customer_id,
				'device_id' => $device_id
			])->delete();
		}
    }
}
