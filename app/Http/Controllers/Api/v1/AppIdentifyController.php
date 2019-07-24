<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Models\app_identify;

class AppIdentifyController extends Controller
{
    public function getAccessToken(Request $request){
        if($request->app_id && $request->send_datetime && $request->checksum && $request->type){
            $response = app_identify::getAccessToken($request->app_id, $request->send_datetime, $request->checksum, $request->type);

            if($response) {
				return $this->respondSuccess($response);
			}
			else {
				return $this->respondInvalidChecksum();
			}
        }
        else{
            return $this->respondMissingParam();
        }
    }
}
