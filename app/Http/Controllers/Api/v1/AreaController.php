<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Models\area;
use App\Helpers\Util;

class AreaController extends Controller
{
    public function getListArea(Request $request){
        $response = area::getListArea($request->shop_id);
        return $this->respondSuccess($response);
    }

    public function getListAreaTable(Request $request){
        $response = area::getListAreaTable($request->shop_id);
        return $this->respondSuccess($response);
    }

    public function getAreaDetail(Request $request){
        $response = area::getAreaDetail($request->shop_id, $request->id);
        return $this->respondSuccess($response);
    }

    public function newArea(Request $request){
        if($request->name){
            $data = $request->except(['token', 'id']);
            $data['created_at'] = Util::getNow();
            $query = area::updateOrInsertArea($data);
            
            if($query == 'messages.success'){
                return $this->respondSuccess();
            }
            else{
                return $this->respondError(__($query));
            }
        }
        else{
            return $this->respondMissingParam();
        }
    }

    public function updateArea(Request $request){
        if($request->id){
            $id = $request->id;
            $data = $request->except(['token', 'id']);
            $data['updated_at'] = Util::getNow();
            $response = area::updateOrInsertArea($data, $id);
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

    public function deleteArea(Request $request){
        if($request->id){
            $response = area::deleteArea($request->shop_id, $request->id);
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
