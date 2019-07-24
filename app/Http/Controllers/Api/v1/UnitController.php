<?php

namespace App\Http\Controllers\Api\v1;

use Validator;
use App\Models\unit_master;
use Session;
use Illuminate\Http\Request;

class UnitController extends Controller {
	public function getListUnit(Request $request) {
		$data = unit_master::getListUnit($request->shop_id, $request->type);

		return $this->respondSuccess($data);
	}

    public function getUnitDetail(Request $request) {
        $data = unit_master::getUnitById($request->id, $request->shop_id);
        return $this->respondSuccess($data);
    }

    public function insertUnit(Request $request){
        if($request['unitname']){
            $data = $request->except(['token']);
            $query = unit_master::updateOrInsertUnitMaster($data);
            if(gettype($query) != 'string') {
                return $this->respondSuccess($query);
            }
            else{
                return $this->respondError(__($query));
            }
        }   
        else{
            return $this->respondMissingParam();
        }
    }

    public function updateUnit(Request $request){
        if($request['id']){
            $id = $request['id'];
            $data = $request->except(['token']);
            $query = unit_master::updateOrInsertUnitMaster($data, $id);
            if(gettype($query) != 'string') {
                return $this->respondSuccess($query);
            }
            else{
                return $this->respondError(__($query));
            }
        }   
        else{
            return $this->respondMissingParam();
        }
    }

    public function deleteUnit(Request $request){
        $id = $request['id'];
        $shop_id = $request['shop_id'];
        if($id){
            $query = unit_master::deleteUnitMaster($id, $shop_id);
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