<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\customer_inventory;
use Illuminate\Http\Request;
use App\Helpers\Util;

class CustomerInventoryController extends Controller
{
    public function getListCustomerInventory(Request $request) {
		$data = customer_inventory::getListCustomerInventory($request->shop_id, $request->customer_id);

		return $this->respondSuccess($data);
	}

	public function newCustomerInventory(Request $request) {
		if($request->customer_id && $request->product_id) {
			$data = $request->except(['token', 'id']);
			$data['regdate'] = Util::getNow();
			$query = customer_inventory::updateOrInsertCustomerInventory($data);

			if($query){
				return $this->respondSuccess();
			}
			return $this->respondError();

		}
		return $this->respondMissingParam();
	}

	public function updateCustomerInventory(Request $request) {
		if($request->id) {
			$data = $request->except(['token', 'id']);
			$data['lastupdate'] = Util::getNow();
			$query = customer_inventory::updateOrInsertCustomerInventory($data, $request->id);

			if($query){
				return $this->respondSuccess();
			}
			return $this->respondError();

		}
		return $this->respondMissingParam();
	}

	public function deleteCustomerInventory(Request $request) {
		if($request->id) {
			$query = customer_inventory::deleteCustomerInventory($request->shop_id, $request->id);

			if($query){
				return $this->respondSuccess();
			}
			return $this->respondError();

		}
		return $this->respondMissingParam();
	}
}
