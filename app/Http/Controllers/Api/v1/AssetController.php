<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Models\asset;
use App\Helpers\Util;

class AssetController extends Controller
{
    public function getListAsset(Request $request){
        $response = asset::getAssetByShopId($request->shop_id, null, $request->name);
        return $this->respondSuccess($response);
    }

    public function getAssetDetail(Request $request){
        if($request->id){
            $response = asset::getAssetById($request->id, $request->shop_id);
            return $this->respondSuccess($response);
        }
        else{
            return $this->respondMissingParam();
        }
    }

    public function newAsset(Request $request){
        if($request->name){
            $data = $request->except(['token', 'id']);
            $data['regdate'] = Util::getNow();
            $response = asset::updateOrInsertAsset($data);
            if($response == 'messages.success'){
                return $this->respondSuccess();
            }
            else{
                return $this->respondError(__($response));
            }
        }
        else{
            return $this->respondMissingParam();
        }
    }

    public function updateAsset(Request $request){
        if($request->id){
            $id = $request->id;
            $data = $request->except(['token', 'id']);
            $data['update'] = Util::getNow();
            $response = asset::updateOrInsertAsset($data, $id);
            if($response == 'messages.success'){
                return $this->respondSuccess();
            }
            else{
                return $this->respondError(__($response));
            }
        }
        else{
            return $this->respondMissingParam();
        }
    }

    public function deleteAsset(Request $request){
        if($request->id){
            $id = $request->id;
            $shop_id = $request->shop_id;
            $response = asset::deleteAsset($shop_id, $id);
            if($response){
                return $this->respondSuccess();
            }
            return $this->respondError();
        }
        else{
            return $this->respondMissingParam();
        }
    }
}
