<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Util;

class app_identify extends Model
{
    protected $table = 'app_identify';

    public static function validateAccessToken($access_token, $send_date, $request_checksum) {
    	if(
    		$access_token && $send_date && $request_checksum &&
			($app_identify = app_identify::getAppIdentifyByAccessToken($access_token))
		) {
    		$app_id = $app_identify->app_id;
    		$secret_token = $app_identify->secret_token;
    		if($request_checksum == Util::getCheckSumPublicApp($app_id, $send_date, $secret_token)) {
    			return true;
			}
		}

		return false;
	}
    
    public static function getAccessToken($app_id, $send_date, $request_checksum, $type){
        $query = app_identify::where([
            'app_id' => $app_id,
            'type' => $type
        ]);

        if($query->count() > 0){
        	$app_identify = $query->first();
            $secret_token = $app_identify->secret_token;
            $expire_date = $app_identify->expire_date;

            if($request_checksum == Util::getCheckSumPublicApp($app_id, $send_date, $secret_token)) {
				if(strtotime($expire_date) < strtotime(Util::getNow())) {
					$new_expire_date = date("Y-m-d", strtotime("+1 month"));
					$generate_access_token = $query->update([
						'access_token' => Util::getAccessToken(),
						'expire_date' => $new_expire_date
					]);

					if(!$generate_access_token){
						return false;
					}
				}

				return $query->select(['access_token', 'expire_date'])->first();
			}

			return false;
        }
    }

    public static function getAppIdentifyByAccessToken($access_token) {
    	return app_identify::where([
			'access_token' => $access_token,
		])->where('expire_date', '>', Util::getNow())->first();
	}
}
