<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Lang;

class customer_supplier_group extends Model
{
    protected $table = 'customer_supplier_group';
    protected $fillable = [];
    public $timestamps = false;

    public function rules(Request $request)
    {
        return [];
    }

    public function messages()
    {
        return Lang::get('validation');
    }

    public static function getListSupplierGroup($shop_id, $group_name){
        $query = customer_supplier_group::where(['shop_id' => $shop_id, 'invalid' => 0,'supplier_flg' => 1])->select('id','shop_id','group_name','memo','price_policy_id','usevat','payment_method','customer_flg','supplier_flg','regdate');

        if(!is_null($group_name)){
            $query->where('group_name', 'like', "%$group_name%");
        }
        $query = $query->get();

        return $query->makeHidden('invalid');
    }
    public static function getListCustomerGroup($shop_id, $group_name){
        $query = customer_supplier_group::where(['shop_id' => $shop_id, 'invalid' => 0,'customer_flg' => 1])
            ->select('id','shop_id','group_name','memo','price_policy_id','usevat','payment_method','customer_flg','supplier_flg','regdate', 'is_default_customer_agency_register');
        
        if(!is_null($group_name)){
            $query->where('group_name', 'like', "%$group_name%");
        }
        $query = $query->get();

        return $query->makeHidden('invalid');
    }

    public static function countExistedGroupName($shop_id, $group_name, $customer_flg = null, $supplier_flg = null, $account_flg = null, $id = null){
        $count = customer_supplier_group::where([
            'group_name' => $group_name,
            'shop_id' => $shop_id,
            'invalid' => 0
        ]);

        $count = $count->where(function ($query) use ($customer_flg, $supplier_flg, $account_flg){
			$query->where('customer_flg' ,$customer_flg)
				  ->orWhere('supplier_flg', $supplier_flg)
				  ->orWhere('account_flg', $account_flg);
        });

        if(!is_null($id)){
            $count = $count->where('id','<>', $id);
        }
        return $count->count();
    }

    public static function updateOrInsertCustomerSupplierGroup($data, $id=null){

        if(isset($data['group_name'])){
            if($data['is_default_customer_agency_register'] == 1 && isset($data['customer_flg']) && $data['customer_flg'] == 1) {
                customer_supplier_group::where('shop_id' , $data['shop_id'])->update(['is_default_customer_agency_register' => 0]);
            }
            $data['customer_flg'] = isset($data['customer_flg']) ? $data['customer_flg'] : null;
            $data['account_flg'] = isset($data['account_flg']) ? $data['account_flg'] : null;
            $data['supplier_flg'] = isset($data['supplier_flg']) ? $data['supplier_flg'] : null;

			if(customer_supplier_group::countExistedGroupName(
                $data['shop_id'],
                $data['group_name'],
                $data['customer_flg'],
                $data['supplier_flg'],
                $data['account_flg'],
                $id) > 0)
            {
				return 'messages.existed_data';
			}
        }

        $data['customer_flg'] = !is_null($data['customer_flg']) ? $data['customer_flg'] : 0;
        $data['account_flg'] = !is_null($data['account_flg']) ? $data['account_flg'] : 0;
        $data['supplier_flg'] = !is_null($data['supplier_flg']) ? $data['supplier_flg'] : 0;
        if(is_null($id)) {
            $last_id = customer_supplier_group::insertGetId($data);
            if($last_id){
                $response = customer_supplier_group::where('id', $last_id)->first();
                return $response;
            }
        }
        else{
            $query = customer_supplier_group::updateOrInsert([ 'id' => $id ], $data);
            if($query){
                return 'messages.success';
            }
        }
		return 'messages.error';
    }

    public static function deleteCustomerSupplierGroup($shop_id, $id){
        $delete = customer_supplier_group::where([
            'id' => $id,
            'shop_id' => $shop_id,
            'invalid' => 0,
        ])
        ->update(['invalid' => 1]);

        if(!$delete){
			return 'messages.error';
        }

        $delete_child = customer_supplier::deleteCustomerSupplierByGroupId($shop_id, $id);
        if(!$delete_child){
            return 'messages.error';
        }

		return 'messages.success';
    }

    public static function getCustomerSupplierGroupById($id, $shop_id)
    {
        return customer_supplier_group::where([
            'id' => $id,
            'shop_id' => $shop_id
        ])
        ->where('invalid', 0)
        ->first();
    }

    public static function getListAccountGroup($shop_id, $group_name){
        $query = customer_supplier_group::where(['shop_id' => $shop_id, 'invalid' => 0, 'account_flg' => 1]);

        if(!is_null($group_name)){
            $query->where('group_name', 'like', "%$group_name%");
        }
        $query = $query->get();

        return $query->makeHidden('invalid');
    }

    public static function getAccountGroupById($id, $shop_id)
    {
        $response = customer_supplier_group::where([
            'id' => $id,
            'shop_id' => $shop_id,
            'invalid' => 0,
            'account_flg' => 1
        ])->first();

        if($response){
            $response = $response->makeHidden('invalid');
        }
        return $response;
    }

    public static function getThreeGroup($shop_id) {
        $groups = customer_supplier_group::where(['shop_id' => $shop_id, 'invalid' => 0])
            ->select(['id', 'group_name', 'supplier_flg', 'customer_flg', 'account_flg'])
            ->orderBy('supplier_flg', 'desc')
            ->orderBy('customer_flg', 'desc')
            ->orderBy('account_flg', 'desc')
            ->get();
        $data = [];
        if($groups) {
            foreach ($groups as $item) {
                if($item->supplier_flg == 1) {
                    $data['distributor'][] = [
                        'id' => $item->id,
                        'name' => $item->group_name
                    ];
                } else if($item->customer_flg == 1) {
                    $data['agency'][] = [
                        'id' => $item->id,
                        'name' => $item->group_name
                    ];
                } else if($item->account_flg == 1) {
                    $data['staff'][] = [
                        'id' => $item->id,
                        'name' => $item->group_name
                    ];
                }
            }
        }
        return $data;
    }

    public static function getDefaultAgencyGroup ($shop_id) {
        $query = customer_supplier_group::where([
            'shop_id' => $shop_id,
            'invalid' => 0,
            'is_default_customer_agency_register' => 1
        ])->select('id as customer_supplier_group_id ','group_name')->get();
        return $query;
    }
}
