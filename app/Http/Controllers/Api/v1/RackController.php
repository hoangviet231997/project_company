<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Validator;
use App\Models\rack_master;
use Session;
use Illuminate\Http\Request;

class RackController extends Controller {
	public function getListRack(Request $request) {
		$data = rack_master::getListRack($request->shop_id);

		return $this->respondSuccess($data);
	}

    public function getRackDetail(Request $request){
        $data = rack_master::getRackById($request->id, $request->shop_id);
        return $this->respondSuccess($data);
    }

    public function insertRack(Request $request){
        if($request['rack_name']){
            $data = $request->except(['token', 'id']);
            $query = rack_master::updateOrInsertRack($data);
            if($query){
                return $this->respondSuccess($query);
            }
            return $this->respondError();
        }   
        else{
            return $this->respondMissingParam();
        }
    }

    public function updateRack(Request $request){
        if($request['id']){
            $id = $request['id'];
            $data = $request->except(['token']);
            $query = rack_master::updateOrInsertRack($data, $id);
            if($query){
                return $this->respondSuccess();
            }
            return $this->respondError();
        }   
        else{
            return $this->respondMissingParam();
        }
    }

    public function deleteRack(Request $request){
        $id = $request['id'];
        $shop_id = $request['shop_id'];
        if($id){
            $query = rack_master::deleteRack($id, $shop_id);
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