<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Validator;
use App\Models\feature_master;
use Session;
use Illuminate\Http\Request;

class FeatureController extends Controller {
	public function getListFeature(Request $request) {
		$data = feature_master::getListFeature($request->shop_id);

		return $this->respondSuccess($data);
	}

    public function getFeatureDetail(Request $request){
        $data = feature_master::getFeatureById($request->id, $request->shop_id);
        return $this->respondSuccess($data);
    }

    public function insertFeature(Request $request){
        if($request['name'] && $request['type']){
            $data = $request->except(['token']);
            $query = feature_master::updateOrInsertFeature($data);
            return $this->respondSuccess(null, __($query));
        }   
        else{
            return $this->respondMissingParam();
        }
    }

    public function updateFeature(Request $request){
        if($request['id']){
            $id = $request['id'];
            $data = $request->except(['token']);
            $query = feature_master::updateOrInsertFeature($data, $id);
            return $this->respondSuccess(null, __($query));
        }   
        else{
            return $this->respondMissingParam();
        }
    }

    public function deleteFeature(Request $request){
        $id = $request['id'];
        $shop_id = $request['shop_id'];
        if($id){
            $query = feature_master::deleteFeature($id, $shop_id);
            if($query){
                return $this->respondSuccess();
            }
            else{
                return $this->respondError();
            }
        }
        else{
            return $this->respondMissingParam();
        }
    }
}