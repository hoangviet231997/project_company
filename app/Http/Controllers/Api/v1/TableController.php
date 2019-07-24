<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Models\table;
use App\Helpers\Util;

class TableController extends Controller
{
    public function getListTable(Request $request){
        $response = table::getTableByShopId($request->shop_id);
        return $this->respondSuccess($response);
    }

    public function getTableDetail(Request $request){
        if($request->id){
            $response = table::getTableById($request->shop_id, $request->id);
            return $this->respondSuccess($response);
        }
        else{
            return $this->respondMissingParam();
        }
    }

    public function newTable(Request $request){
        if($request->name && $request->area_id){
            $data = $request->except(['token', 'id']);
            $data['created_at'] = Util::getNow();
            $response = table::updateOrInsertTable($data);
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

    public function updateTable(Request $request){
        if($request->id){
            $data = $request->except(['token', 'id']);
            $id = $request->id;
            $data['updated_at'] = Util::getNow();
            $response = table::updateOrInsertTable($data, $id);
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

    public function deleteTable(Request $request){
        if($request->id){
            $response = table::deleteTable($request->shop_id, $request->id);
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
