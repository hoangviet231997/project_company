<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Models\app_shop;

class AppShopController extends Controller
{
    public function getListCategory(Request $request) {
		$response = app_shop::getListCategory($request->access_token);
		return $this->respondSuccess($response);
    }

    public function getListProduct(Request $request){
		$response = app_shop::getListProduct($request->access_token, $request->page, $request->category_id, $request->product_type);
		return $this->respondSuccess($response);
    }
}
