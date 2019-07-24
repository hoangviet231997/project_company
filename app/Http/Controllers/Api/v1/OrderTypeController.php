<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Models\order_type_master;
use App\Helpers\Util;

class OrderTypeController extends Controller
{
    public function getListOrderType(Request $request){
        $response = order_type_master::getListOrderType($request->shop_id);
        return $this->respondSuccess($response);
    }

    public function getOrderTypeDetail(Request $request){
        if($request->id){
            $response = order_type_master::getOrderTypeById($request->shop_id, $request->id);
            return $this->respondSuccess($response);
        }
        else{
            return $this->respondMissingParam();
        }
    }
    public function newOrderType(Request $request){
        if($request->order_type){
            $data = $request->except(['token', 'id']);
            $data['regdate'] = Util::getNow();
            $query = order_type_master::updateOrInsertOrderType($data);
            if($query == 'messages.success'){
                return $this->respondSuccess();
            }
            return $this->respondError(__($query));
        }
        else{
            return $this->respondMissingParam();
        }
    }
    public function updateOrderType(Request $request){
        if($request->id){
            $data = $request->except(['token', 'id']);
            $id = $request->id;
            //$data['regdate'] = Util::getNow();
            $query = order_type_master::updateOrInsertOrderType($data, $id);
            if($query == 'messages.success'){
                return $this->respondSuccess();
            }
            return $this->respondError(__($query));
        }
        else{
            return $this->respondMissingParam();
        }
    }
    public function deleteOrderType(Request $request){
        if($request->id){
            $data = $request->except(['token', 'id']);
            $id = $request->id;
            //$data['regdate'] = Util::getNow();
            $query = order_type_master::deleteOrderType($data, $id);
            if($query){
                return $this->respondSuccess();
            }
            return $this->respondError();
        }
        else{
            return $this->respondMissingParam();
        }
    }
}
