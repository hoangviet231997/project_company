<?php

namespace App\Http\Controllers\Api\v1;

use App\Helper\Constant;
use App\Models\shop;
use App\Models\shop_constant_role_permission;
use Illuminate\Http\Request;
use App\Models\role_permission;
use App\Helpers\Util;

class RolePermissionController extends Controller
{
    //
    public function getListRolePermission(Request $request)
    {
        $data = role_permission::getListRolePermission($request->shop_id);
        return $this->RespondSuccess($data);
    }

    public function getRolePermissionDetail(Request $request)
    {
        if ($request->id) {
            $data = role_permission::getRolePermissionById($request->shop_id, $request->id);
            return $this->RespondSuccess($data);
        }
        return $this->respondMissingParam();
    }

    public function updateOrInsertRolePermission(Request $request, $is_update = null)
    {
        if ($is_update) {
            if (is_null($request->id)) {
                return $this->respondMissingParam();
            }
        }
        if ($request->role_name && trim($request->role_permission)) {
            $id = $request->id ? $request->id : null;
            $request['regdate'] = Util::getNow();
            $data = $request->except('token');
            $query = role_permission::updateOrInsertRolePermission($data, $id);
//            if($request['flg_update_role_agency']) {
            shop_constant_role_permission::updateConstantRolePermission($id);
//            }
            if ($query == 1) {
                return $this->respondSuccess($query);
            } else if ($query == 2) {
                return $this->respondError(__('messages.existed_data'));
            } else {
                return $this->respondError();
            }
        } else {
            return $this->respondMissingParam();
        }

    }

    public function deleteRolePermission(Request $request)
    {
        if ($request->id) {
            $query = role_permission::deleteRolePermission($request->shop_id, $request->id);
            if ($query) {
                return $this->respondSuccess();
            }
            return $this->respondError();
        }
        return $this->respondMissingParam();
    }

    public function getConstantRolePermission(Request $request)
    {
        $shop_id = $request->input('shop_id');
        $shop_type = shop::getShopTypeById($shop_id);
        $role_permissions = shop_constant_role_permission::getConstantRolePermission($shop_id);
        $data = Util::changeTextShopConstantRolePermission($role_permissions, $shop_type);
        return $this->respondSuccess($data);
    }

    public function getDefaultRoleInformation () {
        $shop_id = shop::getShopParentAgency();
        $data = role_permission::getDefaultRoleInformation($shop_id);
        if($data == 'messages.error') {
            return $this->respondError(__('messages.role_default_not_found'));
        }
        return $this->RespondSuccess($data);
    }
}
