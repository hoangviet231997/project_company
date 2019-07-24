<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class customer_inventory extends Model
{
    protected $table = 'customer_inventory_master';
    public const CREATED_AT = 'regdate';
    public const UPDATED_AT = 'lastupdate';

	public static function getListCustomerInventory($shop_id, $customer_id = null) {
		$query = customer_inventory::where([
			['shop_id', $shop_id],
			['invalid', 0]
		]);

		if(!is_null($customer_id)) {
			$query->where('customer_id', $customer_id);
		}

		return $query->get()->makeHidden('invalid');
	}

	public static function updateOrInsertCustomerInventory($data, $id = null) {
		$query = customer_inventory::updateOrInsert([ 'id' => $id ], $data);
		if($query){
			return true;
		}
		return false;
	}

	public static function deleteCustomerInventory($shop_id, $id) {
		$query = customer_inventory::where([
			'shop_id' => $shop_id,
			'id' => $id
		])->update(['invalid' => 1]);
		if($query) {
			return true;
		}
		return false;
	}
}
