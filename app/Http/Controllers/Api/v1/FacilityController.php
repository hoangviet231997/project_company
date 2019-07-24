<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Models\facility;
use App\Helpers\Util;

class FacilityController extends Controller
{
    public function getListFacility(Request $request){
        $response = facility::getListFacilityByShopId($request->shop_id, $request->facility_name);
        return $this->respondSuccess($response);
    }

    public function getFacilityDetail(Request $request){
        if($request->id){
            $response = facility::getFacilityById($request->id, $request->shop_id);
            return $this->respondSuccess($response);
        }
        else{
            return $this->respondMissingParam();
        }
    }

    public function newFacility(Request $request){
        if($request->facility_name){
            $data = $request->except(['token', 'id']);
            $data['regdate'] = Util::getNow();
            $response = facility::updateOrInsertFacility($data);

            if(gettype($response) != 'string'){
                return $this->respondSuccess($response); 
            }
            else{
                if($response == 'messages.success'){
                    return $this->respondSuccess();
                }
                else{
                    return $this->respondError(__($response));
                }
            }
            
        }
        else{
            return $this->respondMissingParam();
        }
    }

    public function updateFacility(Request $request){
        if($request->id){
            $id = $request->id;
            $data = $request->except(['token', 'id']);
            $data['regdate'] = Util::getNow();
            $response = facility::updateOrInsertFacility($data, $id);
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

    public function deleteFacility(Request $request){
        if($request->id){
            $id = $request->id;
            $shop_id = $request->shop_id;
            $response = facility::deleteFacility($shop_id, $id);
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
