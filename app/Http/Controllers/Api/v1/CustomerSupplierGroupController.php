<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\shop;
use Validator;
use Illuminate\Http\Request;
use App\Models\customer_supplier_group;
use Session;
use Illuminate\Support\Facades\Schema;
use App\Helpers\Util;
use App\Models\customer_supplier;

class CustomerSupplierGroupController extends Controller {
    public function getListSupplierGroup(Request $request)
    {
		$data = customer_supplier_group::getListSupplierGroup($request->shop_id, $request->group_name);

		return $this->respondSuccess($data);
    }

    public function getListCustomerGroup(Request $request)
    {
		$data = customer_supplier_group::getListCustomerGroup($request->shop_id, $request->group_name);

		return $this->respondSuccess($data);
    }

    public function insertCustomerSupplierGroup(Request $request, $is_customer = null)
    {
        if ($request['group_name']) {
            $is_customer ? $request['customer_flg'] = 1 : $request['supplier_flg'] = 1;
            $request['regdate'] = Util::getNow();
            //$id = $request['id'] ? $request['id'] : null;
            $data = $request->except(['token', 'id']);

            $query = customer_supplier_group::updateOrInsertCustomerSupplierGroup($data);
            //dd($query);
            if(gettype($query) != 'string'){
                return $this->respondSuccess($query);
            }
            else{
                return $this->respondError(__($query));
            }
        } else {
            return $this->respondMissingParam();
        }
    }

    public function updateCustomerSupplierGroup(Request $request, $is_customer = null)
    {
        if ($request['id']) {
            $is_customer ? $request['customer_flg'] = 1 : $request['supplier_flg'] = 1;
            $request['regdate'] = Util::getNow();
            $id = $request['id'];
            $data = $request->except(['token', 'id']);

            $query = customer_supplier_group::updateOrInsertCustomerSupplierGroup($data, $id);
            if($query == 'messages.success'){
                return $this->respondSuccess();
            }
            else{
                return $this->respondError(__($query));
            }
        } else {
            return $this->respondMissingParam();
        }
    }

    public function deleteCustomerSupplierGroup(Request $request)
    {
        $id = $request->input('id');
        $shop_id = $request->input('shop_id');
        if ($id) {
            $delete = customer_supplier_group::deleteCustomerSupplierGroup($shop_id, $id);
            if($delete != 'messages.success'){
                return $this->respondError();
            }

            return $this->respondSuccess();
        } else {
            return $this->respondMissingParam();
        }
    }

    public function getCustomerSupplierGroupDetail(Request $request)
    {
        if($request->id){
            $data = customer_supplier_group::getCustomerSupplierGroupById($request->id, $request->shop_id);
            return $this->respondSuccess($data);
        }
        else{
            return $this->respondMissingParam();
        }
    }
    public function getDefaultAgencyGroup () {
        $shop_id = shop::getShopParentAgency();
        $data = customer_supplier_group::getDefaultAgencyGroup($shop_id);
        return $this->RespondSuccess($data);
    }
}
