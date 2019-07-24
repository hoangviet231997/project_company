<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\Util;
use App\Models\account_push;
use App\Models\order;
use Response;
use Validator;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function respond($data = null, $msg = null, $error_code = 0, $code_response = 200, $headers = []) {
		$data = is_null($data) ? '' : $data;
		$msg = is_null($msg) ? '' : $msg;

		$data_response = [
			'status' => 1,
			'error_code' => $error_code,
			'data' => $data,
			'msg' => $msg,
		];

        return Response::json($data_response, $code_response, $headers);
    }

    public function respondSuccess($data = null, $msg = null) {
		$msg = $msg ?? __('messages.success');
    	return $this->respond($data, $msg);
	}

	public function respondError($msg = null, $data = null) {
		$msg = $msg ?? __('messages.error');
		return $this->respond($data, $msg, 1);
	}

	public function respondMissingParam() {
    	return $this->respond(null, __('messages.missing_param'), 1);
	}

	public function respondInvalidToken() {
		return $this->respond(null, __('messages.invalid_token'), 1);
	}

	public function respondInvalidAccessToken() {
		return $this->respond(null, __('messages.invalid_access_token'), 1);
	}

	public function respondNotFound() {
    	return $this->respond(null, __('messages.canNotFoundResource'), 1);
	}

	public function respondInvalidChecksum() {
		return $this->respond(null, __('messages.invalid_checksum'), 1);
	}

	public function test() {
//    	echo md5(time());
//    	echo md5(time()).md5(time());

		//get checksum
		$app_id = 'a5e0f20501595bc56cead4429c94ce61';
		$send_date = '2019-06-12 15:59:41';
		$secret_token = 'ea4be2dbd8558d58e9f91a97533521e2ea4be2dbd8558d58e9f91a97533521e2';
		echo Util::getCheckSumPublicApp($app_id, $send_date, $secret_token);
	}
}
