<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\account;
use Illuminate\Http\Request;

class StaffController extends Controller {
	public function getListStaff(Request $request) {
		$data = account::getListStaff($request->shop_id);

		return $this->respondSuccess($data);
	}
}
