<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Models\customer_supplier_group;
use App\Helpers\Util;

class AccountGroupController extends Controller
{
    public function getListAccountGroup(Request $request){
        $response = customer_supplier_group::getListAccountGroup($request->shop_id, $request->group_name);
        return $this->respondSuccess($response);
    }

    public function getAccountGroupDetail(Request $request){
        if($request->id){
            $response = customer_supplier_group::getAccountGroupById($request->id, $request->shop_id);
            return $this->respondSuccess($response);
        }
        else{
            return $this->respondMissingParam();
        }
    }

    public function newAccountGroup(Request $request){
        if($request->group_name){
            $request['account_flg'] = 1;
            $request['regdate'] = Util::getNow();
            $data = $request->except(['token', 'id']);

            $query = customer_supplier_group::updateOrInsertCustomerSupplierGroup($data);
            if(gettype($query) != 'string'){
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

    public function updateAccountGroup(Request $request){
        if($request->id){
            $request['account_flg'] = 1;
            $request['regdate'] = Util::getNow();
            $data = $request->except(['token', 'id']);
            $id = $request->id;
            $query = customer_supplier_group::updateOrInsertCustomerSupplierGroup($data, $id);
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

    public function deleteAccountGroup(Request $request){
        if($request->id){
            $query = customer_supplier_group::deleteCustomerSupplierGroup($request->shop_id, $request->id);
            if($query == 'messages.success'){
                return $this->respondSuccess();
            }
            return $this->respondError();
        }
        else{
            return $this->respondMissingParam();
        }
    }

    public function getThreeGroup (Request $request) {
        $response = customer_supplier_group::getThreeGroup($request->shop_id);
        return $this->respondSuccess($response);
    }
}
