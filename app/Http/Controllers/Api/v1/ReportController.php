<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\asset;
use App\Models\order;
use Illuminate\Http\Request;

class ReportController extends Controller{
	public function index(Request $request) {
		if($request->split_asset) {
			$data = [];
			$assets = asset::getAssetByShopId($request->shop_id);
			foreach ($assets as $asset) {
				$data_report = order::getReport($request->date_from, $request->date_to, $request->shop_id, $asset->id);
				$data_report['asset_id'] = $asset->id;
				$data_report['asset_name'] = $asset->name;

				$data[] = $data_report;
			}
		}
		else {
			$data = order::getReport($request->date_from, $request->date_to, $request->shop_id);

			if($request->v2) {
				$data = [$data];
			}
		}

		return $this->respondSuccess($data);
	}
}