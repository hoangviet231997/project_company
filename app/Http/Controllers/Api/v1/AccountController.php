<?php

namespace App\Http\Controllers\Api\v1;

use App\Helper\Constant;
use App\Models\account_shop;
use App\Models\facility;
use Illuminate\Http\Request;

use Validator;
use App\Models\account;
use App\Models\account_push;
use App\Models\role_permission;
use App\Models\asset;
use App\Helpers\Util;

class AccountController extends Controller {
	public function getAccountDetail(Request $request){
        if($request['id']){
            $data = account::getAccountById($request->id, $request->shop_id);
            return $this->respondSuccess($data);
        }
        else{
            return $this->respondMissingParam();
        }
    }

    public function updateOrInsertAccount(Request $request, $is_update = null){
        if($is_update && !isset($request['id'])){
            return $this->respondMissingParam();
        }
        if(is_null($is_update) && !isset($request['username']) && !isset($request['email']) && !isset($request['password'])){//insert situtation
            return $this->respondMissingParam();
        }
        $id = $request['id'] ? $request['id'] : null;
        $request['main_shopid'] = $request['shop_id'];
        $data = $request->except(['shop_id', 'push_id', 'device_id', 'device_type', 'token', 'role_permission_id']);

        $query = account::updateOrInsertAccount($data, $request['role_permission_id'], $request['push_id'], $request['device_id'], $request['device_type'], $id);
        if(gettype($query) != 'string') {
            return $this->respondSuccess(($query));
        }
        else{
            if($query == 'messages.success'){
                return $this->respondSuccess(null, __($query));
            }
            else {
                return $this->respondError(__($query));
            }
        }
    }

    public function deleteAccount(Request $request){
        if($request['id']){
            $query = account::deleteAccount($request->id);
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

    public function checkPermissionCreateCustomerAgency(Request $request) {
        $token = $request->input('token');
        $shop_id = $request->input('shop_id');
        $account = account_shop::getPermission($shop_id, $token);
        if($account && $account->role_permission) {
            $roles = explode(',', $account->role_permission);
            if(in_array(Constant::PERMISSION_CREATE_CUSTOMER_AGENCY, $roles)) {
                return $this->respondSuccess('', 'success');
            }
        }
        return $this->respondError('permission denied');
    }

    public function getAccountAgencyByShop(Request $request) {
	    $shop_id = $request->input('shop_id');
	    $data = account::getAccountAgencyByShop($shop_id);
	    return $this->respondSuccess($data);
    }

    /*public function deleteAccountPush(Request $request) {
        if(account_push::deleteAccountPushByDeviceId($request['device_id'])){
          return $this->respondSuccess();
        }
        else{
          return $this->respondSuccess(null, __('messages.error'));
        }
    }  */
}
