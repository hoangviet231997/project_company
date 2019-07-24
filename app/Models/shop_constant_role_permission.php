<?php

namespace App\Models;

use App\Helper\Constant;
use Illuminate\Database\Eloquent\Model;


class shop_constant_role_permission extends Model
{
    public $table = 'shop_constant_role_permission';
    public $timestamps = true;

    public static function getConstantRolePermission($shop_id) {
        $roles = shop_constant_role_permission::where(['shop_id' => $shop_id, 'invalid' => 0])
            ->select('role_permission')->first();
        if($roles && $roles->role_permission) {
            return json_decode($roles->role_permission);
        }
        else {
            $data = Constant::getAllPermission();
            return $data;
        }
    }

    public static function createOrUpdateConstantRolePermission($shop_parent_id, $shop_id, $role_id, $id = 0) {
        $roles = role_permission::where(['id' => $role_id, 'shop_id' => $shop_parent_id, 'invalid' => 0])
            ->select('role_permission')->first();

        if($roles && $roles->role_permission) {
            $roles = explode(',', $roles->role_permission) ;
            $role_permission = self::formatRoleConstant($roles); //input array role permission
            $data_permission = [
                'shop_id' => $shop_id,
                'role_permission' => json_encode($role_permission),
                'parent_shop_role_permission_id' => $role_id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            shop_constant_role_permission::updateOrInsert(['id' => $id], $data_permission);
        }
        else {
            throw new \Exception(__('messages.role_permission_not_exists'), 1);
        }
    }

    public static function updateConstantRolePermission($role_id) {
        $roles = role_permission::where(['id' => $role_id, ])
            ->select('role_permission')->first();
        if($roles && $roles->role_permission) {
            $roles = explode(',', $roles->role_permission);
            $role_permission = self::formatRoleConstant($roles);
            $role_permission = json_encode($role_permission);
            shop_constant_role_permission::where(['parent_shop_role_permission_id' => $role_id])
                ->update(['role_permission' => $role_permission]);
        }

    }

    public static function deleteConstantRolePermission($id) {
        return shop_constant_role_permission::where(['id' => $id])->update(['invalid' => 1]);
    }

    private static function formatRoleConstant($roles) {
        $role_constant = Constant::getAllPermission();
        foreach ($role_constant as $key_role_name => $role) {
            foreach ($role as $key => $item) {
                if(!in_array($key, $roles)) {
                    unset($role_constant[$key_role_name][$key]);
                }
            }
            if(count($role_constant[$key_role_name]) == 0) {
                unset($role_constant[$key_role_name]);
            }
        }
        return $role_constant;
    }

}
