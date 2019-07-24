<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class role_permission extends Model
{
    protected $table = 'role_permission';
    protected $hidden = ['regdate', 'invalid'];

    public $timestamps = false;

    public static function getListRolePermission($shop_id)
    {
        return role_permission::where([
            'shop_id' => $shop_id,
            'invalid' => 0
        ])->get();
    }

    public static function getRolePermissionById($shop_id, $id)
    {
        return role_permission::where([
            'shop_id' => $shop_id,
            'id' => $id,
            'invalid' => 0
        ])->get();
    }

    public static function getRoleAccount($shop_id, $id)
    {
        $roles = role_permission::where([
            'shop_id' => $shop_id,
            'id' => $id,
            'invalid' => 0
        ])->first();
        if ($roles) {
            return explode(',', $roles->role_permission);
        }
        return [];
    }

    public static function countExistedRolePermission($shop_id, $role_name, $id = null)
    {
        $query = role_permission::where(function ($query) use ($shop_id, $role_name) {
            $query->where(['shop_id' => $shop_id, 'role_name' => $role_name, 'invalid' => 0]);
        });
        if (!is_null($id)) {
            $query->where('id', '<>', $id);
        }
        return $query->count();
    }

    public static function updateOrInsertRolePermission($data, $id = null)
    {
        unset($data['flg_update_role_agency']);
        if (role_permission::countExistedRolePermission($data['shop_id'], $data['role_name'], $id) == 0) {
            if ($data['is_default_customer_agency_register'] == 1) {
                $value = role_permission::where('shop_id', $data['shop_id'])->update(['is_default_customer_agency_register' => 0]);
            }
            $query = role_permission::updateOrInsert(['id' => $id], $data);
            if ($query) {
                return 1;
            } else {
                return 0;
            }
        } else {
            return 2;
        }
    }

    public static function deleteRolePermission($shop_id, $id)
    {
        $query = role_permission::where([
            'shop_id' => $shop_id,
            'id' => $id
        ])->update(['invalid' => 1]);
        if ($query) {
            return true;
        }
        return false;
    }

    public static function getRolePermissionByShopId($shop_id)
    {
        return role_permission::where([
            'shop_id' => $shop_id,
            'invalid' => 0,
        ])->get();
    }

    public static function getDefaultRoleInformation($shop_id)
    {
        $query = role_permission::where([
            'shop_id' => $shop_id,
            'invalid' => 0,
            'is_default_customer_agency_register' => 1
        ])->select('id as role_id','role_name')->get();
        if(count($query) == 0 ) {
            return 'messages.error';
        }
        return $query;
    }
}
