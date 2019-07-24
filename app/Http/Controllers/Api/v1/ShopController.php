<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Models\shop;
use App\Models\shop_setting;

class ShopController extends Controller
{
    //
    public function getPublicShop(Request $request){
        $data = $request->except(['token']);
        $response = shop::getPublicShop($data);

		return $this->respondSuccess($response);
    }

    public function updateShopSetting(Request $request){
        $data = $request->except(['token', 'id']);
        $id = $request->id;
        $response = shop_setting::updateShopSettingById($data, $id);
        if($response){
            return $this->respondSuccess();
        }
        return $this->respondError();
    }
}
