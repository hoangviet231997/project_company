<?php

namespace App\Http\Controllers\Api\v1;

use App\Helper\Constant;
use App\Helpers\Util;
use App\inventory_master;
use App\Models\account;
use App\Models\customer_supplier;
use App\Models\debug_log;
use App\Models\inventory_transaction_master;
use App\Models\order;
use App\Models\order_product;
use App\Models\product;
use App\Models\promotion_detail;
use App\Models\restrict_duplicate_request;
use App\Models\shop;
use App\Models\shop_setting;
use App\Models\transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class SyncOrderController extends Controller {
    public function index(Request $request) {
    	$debug_log = new debug_log();
    	$debug_log->name = 'sync';
    	$debug_log->log = json_encode($_POST);
    	$debug_log->save();

		$is_new_order = false;
		$is_save = false;

//		$data = customer_supplier::getOrderCountByCustomerId(3, 1);
//		return $this->respondSuccess($data);

//		DB::statement('truncate `order`;');
//		DB::statement('truncate `order_product`;');

//		$order = new order();
//		$order->id = '1557110160311009487429';
//		$order->save();
//		return $this->respondSuccess($order);

		//always begin transaction
		DB::beginTransaction();

		try {
			$shop_id = $request->shop_id;
			$customer_id = $request->customer_id;

			$area_id = intval($request->area_id);
			$area_name = $request->area_name;
			$table_id = intval($request->table_id);
			$table_name = $request->table_name;
			$table_type = intval($request->table_type);
			$version_code = intval($request->version_code);
			$version_code_change_order = intval($request->version_code_change_order);

			$payment_status = intval($request->payment_status);
			$extra_status = intval($request->extra_status);

			//order from sale app
			if($request->token) {
				$account = account::getAccountByToken($request->token);
				$is_shop = $account->is_shop;
			}
			//order from user app
			else {
				$is_shop = 0;
			}

			$now = Util::getNow();
			$is_cancel_order = false;

			$order_status_tmp = intval($request->order_status);
			$last_update_local = $request->input('last_update_local', $now);
			$last_update_local_timestamp = strtotime($last_update_local);
			$print_date = $request->print_date;

			$regdate_local = $request->input('regdate_local', $now); //regdate local

			$shipping_price = $request->input('shipping_price', 0);

			$promotions = $request->promotion ? json_decode($request->promotion) : [];
			$multipay_method = $request->multipay_method;

			$table_status = $request->input('table_status', 0);
			$shift_local_id = $request->input('shift_local_id', 0);

			$generate_order_code_flg = false;

			$data_msg_return = Constant::SUCCESS;

			$order_products_db = [];

			$asset_id = $request->asset_id;
			$asset_name = $request->asset_name;

			$shop = shop::getShopById($shop_id);
			$shop_setting = shop_setting::getShopSettingByShopId($shop_id);

			$shift_id = $request->input('shift_id', 0);

//			if(!$shift_id) {
//				$local_time = substr($last_update_local, -8);
//				$shift_id = Shift::model()->getShift($shop_id, $local_time);
//			}

			$revenueship_flg = $shop_setting->revenueship_flg;
			$order_stage_id_subtract_inventory = $shop->order_stage_id_subtract_inventory;
//			$require_shift_transfer_local = $shop->select_shift_when_order; //require shift transfer when sync

			$order_grand_total = $revenueship_flg ? $request->total_price : $request->total_price - $shipping_price;

//			if(!$require_shift_transfer_local && ShiftTransferLocal::model()->countShiftTransferLocalRecently($shop_id, true, 0)) {
//				Shop::model()->updateRequireShiftTransferLocalByShopId($shop_id);
//				$require_shift_transfer_local = true;
//			}

//			if($require_shift_transfer_local && !$shift_local_id) {
//				$shift_local = ShiftTransferLocal::model()->getShiftTransferLocalRecently($shop_id, true, 0, 1);
//				if($shift_local) {
//					$shift_local_id = $shift_local[0]->shift_local_id;
//				}
//			}

			try {
				restrict_duplicate_request::saveRestrictDuplicateRequest('v3_syncOrder', $request->order_local_id, $shop_id);
			}
			catch(Exception $e) {
				DB::rollBack();
				$error_msg = 'Duplicate order. Line: ' . __LINE__;
//				$data_msg_return = 'request_duplicate';
//				$postlog_msg = Yii::t('postlog', 'msg.error.order_invalid').'. '.$error_msg;
//				$response_msg = json_encode(new stdClass());
//				PostLog::model()->savePostLogMsg($postlog_msg, true, 0, $response_msg, $data_msg_return);
				return $this->respondSuccess(null, $error_msg);
			}

			if($table_id == Constant::GROUP_TABLE_ID) {
				$table_id = 0;
			}

//			if(!$table_type && $table_name && $table_id_tmp = Table::model()->getTableIdByTableNameShopId($table_name, $shop_id)) {
//				$table_id = $table_id_tmp;
//			}

			if($table_type == 2) {
				$table_name = Util::getOrderCode($shop_id);
			}

			$order = order::getOrderById($request->order_local_id, $shop_id);

			if($order && $order->invalid) {
				$error_msg = 'order_invalid'; //Yii::t('postlog', 'msg.error.order_invalid').'. Line: ' . __LINE__;
				return $this->returnInvalidOrder($order, $shop_id, $error_msg);
			}

			if($order && $version_code && $version_code <= $order->version_code) {
				$data_msg_return = 'old_version';
				$error_msg = ' Version code <= Version code server. Transaction rollback. Line: ' . __LINE__;
				return $this->returnInvalidOrder($order, $shop_id, $error_msg, $data_msg_return);
			}

			if($order && (($order->status == 4 && $order_status_tmp != 5) || $order->status == 5 || ($order->status == 7 && $order_status_tmp != 5))) {
				$error_msg = 'order_status_invalid'; //Yii::t('postlog', 'msg.error.order_status_invalid').'. Line: ' . __LINE__;
				return $this->returnInvalidOrder($order, $shop_id, $error_msg);
			}

			//Create order
			if(empty($order)) {
				$is_new_order = true;
				$order_code =  '';

				if($request->order_code) {
					$order_code = $request->order_code;
				}
				else {
					$generate_order_code_flg = true;
				}

				$order = new order();
				$order->id = $request->order_local_id;
				$order->code = $order_code;
				$order->order_account_id = $request->order_account_id;
				$order->order_account_name = $request->order_account_name;
				$order->shop_id = $shop_id;
				$order->regdate = $now;
				$order->regdate_local = $regdate_local;
				$order->type = $request->type;
				$order->type_name = $request->type_name;
				$order->device_id = $request->device_id;
				$order->is_shop = $is_shop;
				$order->is_fast_payment = $request->extra_status_flag;
				$order->regdate_business_date = Util::getBusinessDateTimestamp($regdate_local, $shop->business_start_hour);

//				if($is_shop) {
					$order->status = $order_status_tmp ? $order_status_tmp : Constant::ORDER_IN_PROCESS;
//				}
//				else {
//					$order->status = Constant::ORDER_NEW;
//					$order->order_account_name = $request->customer_name;
//				}
			}
			//Update order
			else if($order) {
				$is_new_order = false;

				if(($order->status == 4 && $order_status_tmp == 5) || ($order->status == 7 && $order_status_tmp == 5)) {
					$is_cancel_order = true;
				}

				$order->status = $order_status_tmp;
			}

			$order->shift_id = $shift_id;
			$order->shift_local_id = $shift_local_id;
			$order->area_id = $area_id;
			$order->area_name = $area_name;
			$order->table_id = $table_id;
			$order->table_name = $table_name;
			$order->note = $request->note;
			$order->tablegroup_price = $request->tablegroup_price;
			$order->tablegroup_price_id = $request->tablegroup_price_id;
			$order->cashier_id = $request->cashier_id;
			$order->cashier_name = $request->cashier_name;
			$order->customer_id = $customer_id;
			$order->customer_name = $request->customer_name;
			$order->customer_phone_number = $request->customer_phone_number;
			$order->customer_email = $request->customer_email;
			$order->extra_status = $extra_status;
			$order->table_status = $table_status;
			$order->asset_id = $asset_id;
			$order->payment_status = $payment_status;
			$order->multipay_method = $multipay_method;
			$order->promotion_id = $request->promotion_id;
			$order->person_num = $request->person_num;
			$order->times_printed = $request->times_printed;

			$order->account_service_ids = $request->account_service_ids;

			$order->total = $request->total_price;
			$order->paid_total = $request->paid_total;

			$order->discount_id = $request->discount_id;
			$order->discount_percent = $request->discount_percent;
			$order->discount_reason = $request->discount_reason;
			$order->discount_price = $request->discount_price;

			$order->surcharge_id = $request->surcharge_id;
			$order->surcharge_price = $request->surcharge_price;
			$order->surcharge_percent = $request->surcharge_percent;
			$order->surcharge_reason = $request->surcharge_reason;

			$order->tax = $request->tax;
			$order->tax_price = $request->tax_price;
			$order->tax_percent = $request->tax_percent;

			$order->cancel_reason = $request->cancel_reason;

			$order->shipping_price = $shipping_price;
			$order->grand_total = $order_grand_total;

			$order->print_date = $print_date;
			$order->return_date = $request->return_date;
			$order->last_update = $now;
			$order->last_update_local = $last_update_local;
			$order->last_update_timestamp = $last_update_local_timestamp;
			$order->business_date =  Util::getBusinessDateTimestamp($order->last_update, $shop->business_start_hour);

			$order->booking_time = $request->booking_time;
			$order->checkin_time = $request->checkin_time;
			$order->checkout_time = $request->checkout_time;

			$order->version_code = $version_code;
			$order->version_code_change_order = $version_code_change_order;

			try {
				$order->save();
			}
			catch(Exception $e) {
				$error_msg = 'Can not save order. Line: ' . __LINE__;
				return $this->returnInvalidOrder($order, $shop_id, $error_msg);
			}

			//remove all product and add new product from request data
			$total_discount_price_items = 0;
			$order_product_insert_arr = [];
			foreach ($request->product as $item_key => $item) {
				$paid_date = $paid_regdate = null;

				if($item['order_product_status'] == 4 || $item['order_product_status'] == 7) {
					$paid_date = $last_update_local;
					$paid_regdate = $now;
				}

				if($order_status_tmp == 4 && $item['order_product_status'] != 5 && $item['order_product_status'] != 7 && $item['order_product_status'] != 8 && $item['order_product_status'] != 10) {
					$item['order_product_status'] = 4;
				}

				if($order_status_tmp == 5 ) {
					$item['order_product_status'] = 5;
				}

				$item['id'] = $item['order_product_local_id'];
				$item['shop_id'] = $shop_id;
				$item['order_id'] = $order->id;
				$item['order_product_invalid'] = 0;
				$item['paid_date'] = $paid_date;
				$item['paid_regdate'] = $paid_regdate;
				$item['order_product_business_date'] = Util::getBusinessDateTimestamp($last_update_local, $shop->business_start_hour);
				$item['regdate'] = $item['last_update'] = $now;

				unset($item['order_product_local_id']);
				$order_product_insert_arr[] = $item;

				if($item['order_product_status'] != 5) {
					$total_discount_price_items += ($item['discount_price'] * $item['number']);
				}
			}

			$sql = "DELETE FROM order_product WHERE order_id = '{$order->id}' and shop_id = '{$shop_id}'";
			DB::delete($sql);

			if($order_product_insert_arr) {
				DB::table('order_product')->insert($order_product_insert_arr);
			}

			if($total_discount_price_items) {
				$order->total_discount_price_items = $total_discount_price_items;
				order::updateOrderAttributeByOrderId($order->id, $shop_id, 'total_discount_price_items', $total_discount_price_items);
			}

			////transaction
			if($multipay_method) { //tách hoá đơn
				$multipay_methods = json_decode($multipay_method, true);
				$seconds = 0;
				foreach ($multipay_methods as $paymethod) {
					$is_create_payment_transaction = false;
					$is_deposit = 0;

					$payment_local_id = Util::getParam($paymethod, 'transaction_local_id', Util::getLocalId($shop_id));
					$payment_paytype = Util::getParam($paymethod, 'paytype');
					$payment_version_code = Util::getParam($paymethod, 'version_code', 1);
					$payment_notes = Util::getParam($paymethod, 'note');
					$payment_customer_id = Util::getParam($paymethod, 'customer_id');
					$payment_amount = $paymethod['amount'];
					$payment_pay = $paymethod['pay'];
					$payment_asset_id = $paymethod['asset_id'];
					$payment_asset_name = $paymethod['asset_name'];

					$update_local = date('Y-m-d H:i:s', strtotime("+$seconds second", strtotime($order->last_update_local)));

					if($payment_paytype == 2) { //đặt cọc
						$payment_transaction = transaction::getTransactionByLocalId($payment_local_id, $shop_id);
						if($payment_transaction && $payment_version_code > $payment_transaction->version_code) {
							$params = [
								'shop_id' => $order->shop_id,
								'amount' => $payment_amount,
								'business_start_hour' => $shop->business_start_hour,
								'version_code' => $payment_version_code,
								'notes' => $payment_notes,
								'asset_id' => $payment_asset_id,
								'shift_local_id' => $shift_local_id,
							];

							transaction::updateTransactionByParams($payment_local_id, $params);
						}
						else if(!$payment_transaction) {
							$is_deposit = 1;
							$is_create_payment_transaction = true;
						}
					}
					else if($payment_paytype != 2 && ($order_status_tmp == 4 || $order_status_tmp == 7)) { //thanh toán tách bill
						$is_create_payment_transaction = true;
					}

					if($is_create_payment_transaction) {
						$seconds++;
						$params = [
							'version_code' => $payment_version_code,
							'source_id' => $order->id,
							'order_local_id' => $payment_local_id,
							'note' => $payment_notes,
							'cashier_id' => $order->cashier_id,
							'cashier_name' => $order->cashier_name,
							'customer_id' => $payment_customer_id,
							'shift_id' => $order->shift_id,
							'shop_id' => $order->shop_id,
							'total_price' => $payment_amount,
							'paid_total' => $payment_pay,
							'regdate_local' => $update_local,
							'update_local' => $update_local,
							'business_start_hour' => $shop->business_start_hour,
							'asset_id' => $payment_asset_id,
							'asset_name' => $payment_asset_name,
							'category' => 1,
							'source_type' => Constant::TRASACTION_FROM_ORDER,
							'type' => Constant::TRASACTION_TYPE_IMPORT,
							'sub_type' => 1, //thêm order
							'sub_type_balance' => 2, //sub type cho transaction cân bằng
							'category_balance' => 0,
							'grand_total' => $payment_amount,
							'transaction_fee_ship' => 0,
							'transaction_surcharge' => 0,
							'transaction_discount' => 0,
							'revenueship_flg' => $revenueship_flg,
							'transaction_ignore' => 0,
							'is_deposit' => $is_deposit,
							'shift_local_id' => $shift_local_id,
						];

						transaction::addTransactionByParams($params);

						if($payment_customer_id) {
							customer_supplier::updateOrderCountById($customer_id, true, 1, $shop_id);
						}
					}
				}
			}
			else if(!$multipay_method && ($order_status_tmp == 4 || $order_status_tmp == 7)) { //ko tách hoá đơn thì tạo transaction như bình thường
				$params = [
					'source_id' => $order->id,
					'order_local_id' => $order->local_id,
					'cashier_id' => $order->cashier_id,
					'cashier_name' => $order->cashier_name,
					'customer_id' => $order->customer_id,
					'shift_id' => $order->shift_id,
					'shop_id' => $order->shop_id,
					'total_price' => $order->total,
					'paid_total' => $order->paid_total,
					'regdate_local' => $order->regdate_local,
					'update_local' => $order->last_update_local,
					'business_start_hour' => $shop->business_start_hour,
					'asset_id' => $asset_id,
					'asset_name' => $asset_name,
					'category' => 1,
					'source_type' => Constant::TRASACTION_FROM_ORDER,
					'type' => Constant::TRASACTION_TYPE_IMPORT,
					'sub_type' => 1, //thêm order
					'sub_type_balance' => 2, //sub type cho transaction cân bằng
					'category_balance' => 0,
					'grand_total' => $order_grand_total,
					'transaction_fee_ship' => $shipping_price,
					'transaction_surcharge' => doubleval($request->surcharge_price),
					'transaction_discount' => doubleval($request->discount_price),
					'revenueship_flg' => $revenueship_flg,
					'transaction_ignore' => 0,
					'shift_local_id' => $shift_local_id,
				];

				//lock wait transaction
				transaction::addTransactionByParams($params);

				if($customer_id) {
					customer_supplier::updateOrderCountById($customer_id, true, 1, $shop_id);
				}
			}
			//cancel order
			else if($is_cancel_order) {
				transaction::deleteTransactionByOrderId($order->id, $order->shop_id);

				if($customer_id) {
					customer_supplier::updateOrderCountById($customer_id, false, 1, $shop_id);
				}
			}
   
			if(!$order_products_db) {
                $order_products_db = order::getOrderProductByOrderId($order->id, $shop_id);
            }
			$items = $order_products_db;
			//inventory
			//complete order
            $product_inv_ids = [];
			if($order_stage_id_subtract_inventory) {
				if($order_stage_id_subtract_inventory == $table_status) {
					$total_amount_export = 0;
                    $params = [
                        'regdate_local' => $order->regdate_local,
                        'shop_id' => $order->shop_id,
                        'order_id' => $order->id,
                        'order_account_id' => $order->order_account_id,
                        'order_account_name' => $order->order_account_name,
                        'tax_percent' => $order->tax_percent,
                        'tax_price' => $order->tax_price,
                        'tax' => $order->tax,
                        'note' => $order->note,
                        'discount_id' => $order->discount_id,
                        'discount_percent' => $order->discount_percent,
                        'discount_reason' => $order->discount_reason,
                        'discount_price' => $order->discount_price,
                        'shipping' => $order->shipping_price,
                        'shift_id' => $order->shift_id,
                        'asset_id' => $asset_id,
                        'asset_name' => $asset_name,
                        'format_currency' => $shop->format_currency,
                    ];
                    
                    foreach($items as $item) {
						if($item->inventory_created_flg == 1) {
							continue;
						}

						$inprice_total = 0;
						/*if(
						    $item->combo &&
                            $item->type == 1 &&
                            ($combo = json_decode($item->combo))
                            && json_last_error() == JSON_ERROR_NONE
                        ) {
							$inprice_total = inventory_transaction_master::createBillTransationMasterGeneral(
							    $params,
                                $combo,
                                Constant::TRASACTION_TYPE_EXPORT,
                                Constant::TRANSACTION_SUBTYPE_ORDER,
                                $item->food_quantity,
                                $item->product_id
                            );
							if(isset($inprice_total['msg_error'])) {
							    DB::rollBack();
							    return $this->respondError($inprice_total);
                            }
						}*/
                        array_push($product_inv_ids, $item->product_id);
                        $data_product = [];
                        $data_product[] = [
                            'quantity' => $item->number,
                            'product_extend_id' => $item->product_extend_id,
                            'product_id' => $item->product_id,
                            'product_name' => $item->product_name,
                            'batch_no' => $item->batch_no,
                            'batch_expire_date' => $item->batch_expire_date,
                            'unit_id' => $item->unit_id,
                            'unit_name' => $item->unit_name,
                            'price' => $item->price,
                        ];
                        $unit_convert = $item->primary_unit_convert ?? 1;
                        $inprice_total = inventory_transaction_master::createBillTransationMasterGeneral(
                            $params,
                            $data_product,
                            Constant::TRASACTION_TYPE_EXPORT,
                            Constant::TRANSACTION_SUBTYPE_ORDER,
                            $unit_convert,
                            $item->product_id
                        );
                        if(isset($inprice_total['msg_error'])) {
                            DB::rollBack();
                            return $this->respondError($inprice_total);
                        }
                        
                        
                        //update order food
                        $food_inprice = product::getFoodInPriceByFoodId($item->food_id);
                        if($food_inprice) {
                            $inprice_total = $food_inprice * $item->number;
                            order_product::updateInpriceInProductOrder($shop_id, $item->product_id,
                                $inprice_total);
                        }
                        
                        order_product::updateInventoryFlag($item->product_id, $shop_id);
                        
                        $total_amount_export += $inprice_total;
					}
					if($total_amount_export) {
						//create transaction export
						$transaction_inventory_params = [
							'shop_id' => $order->shop_id,
							'account_id' => $order->order_account_id,
							'account_name' => $order->order_account_name,
							'shift_id' => $order->shift_id,
							'order_id' => $order->id,
							'regdate_local' => $order->regdate_local,
							'update_local' => $order->last_update_local,
							'type' => Constant::TRASACTION_TYPE_EXPORT,
							'amount' => $total_amount_export,
							'category' => '20', // chi gia von
							'business_start_hour' => $shop->business_start_hour,
							'asset_id' => $asset_id,
							'asset_name' => $asset_name,
							'format_currency' => $shop->format_currency,
							'shift_local_id' => $shift_local_id,
							'inprice_export_tran_report_flg' => $shop->inprice_export_tran_report_flg,
						];
						transaction::addTransactionInventory($transaction_inventory_params);
					}
				}
			}
			else if($order_status_tmp == 4 || $order_status_tmp == 7) {
				$total_amount_export = 0;
                $params = [
                    'regdate_local' => $order->regdate_local,
                    'shop_id' => $order->shop_id,
                    'order_id' => $order->id,
                    'order_account_id' => $order->order_account_id,
                    'order_account_name' => $order->order_account_name,
                    'tax_percent' => $order->tax_percent,
                    'tax_price' => $order->tax_price,
                    'tax' => $order->tax,
                    'note' => $order->note,
                    'discount_id' => $order->discount_id,
                    'discount_percent' => $order->discount_percent,
                    'discount_reason' => $order->discount_reason,
                    'discount_price' => $order->discount_price,
                    'shipping' => $order->shipping_price,
                    'shift_id' => $order->shift_id,
                    'asset_id' => $asset_id,
                    'asset_name' => $asset_name,
                    'format_currency' => $shop->format_currency,
                ];
                
				foreach($items as $item) {
					if($item->order_product_status != 4 && $item->order_product_status != 7)
						continue;
					$inprice_total = 0;
					/*if($item->combo &&
                        $item->type == 1 &&
                        ($combo = json_decode($item->combo)) &&
                        json_last_error() == JSON_ERROR_NONE
                    ) {
						$params = [
							'regdate_local' => $order->order_update_local_time,
							'shop_id' => $order->shop_id,
							'order_id' => $order->id,
							'order_account_id' => $order->account_id,
							'order_account_name' => $order->order_account_name,
							'tax_percent' => $order->tax_percent,
							'tax_price' => $order->tax_price,
							'tax' => $order->tax,
							'note' => $order->note,
							'discount_id' => $order->discount_id,
							'discount_percent' => $order->discount_percent,
							'discount_reason' => $order->discount_reason,
							'discount_price' => $order->discount_price,
							'shipping' => $order->shipping_price,
							'shift_id' => $order->shift_id,
							'asset_id' => $asset_id,
							'asset_name' => $asset_name,
							'format_currency' => $shop->format_currency,
						];
						$inprice_total = inventory_transaction_master::createBillTransationMasterGeneral (
						    $params,
                            $combo,
                            Constant::TRASACTION_TYPE_EXPORT,
                            Constant::TRANSACTION_SUBTYPE_ORDER,
                            $item->number,
                            $item->product_id
                        );
                        if(isset($inprice_total['msg_error'])) {
                            DB::rollBack();
                            return $this->respondError($inprice_total);
                        }
					}*/
                    array_push($product_inv_ids, $item->product_id);
                    $data_product = [];
                    $data_product[] = [
                        'quantity' => $item->number,
                        'product_extend_id' => $item->product_extend_id,
                        'product_id' => $item->product_id,
                        'product_name' => $item->product_name,
                        'batch_no' => $item->batch_no,
                        'batch_expire_date' => $item->batch_expire_date,
                        'unit_id' => $item->unit_id,
                        'unit_name' => $item->unit_name,
                        'price' => $item->price,
                    ];
                    $unit_convert = $item->primary_unit_convert ?? 1;
                    $inprice_total = inventory_transaction_master::createBillTransationMasterGeneral(
                        $params,
                        $data_product,
                        Constant::TRASACTION_TYPE_EXPORT,
                        Constant::TRANSACTION_SUBTYPE_ORDER,
                        $unit_convert,
                        $item->product_id
                    );
                    if(isset($inprice_total['msg_error'])) {
                        DB::rollBack();
                        return $this->respondError($inprice_total);
                    }
                    
					//update order food
					$food_inprice = product::getFoodInPriceByFoodId($item->product_id);
					if($food_inprice) {
						$inprice_total = $food_inprice * $item->number;
                        order_product::updateInpriceInProductOrder(
                            $shop_id,
                            $item->product_id,
                            $inprice_total
                        );
					}

					$total_amount_export += $inprice_total;
				}
				if($total_amount_export) {
					//create transaction export
					$transaction_inventory_params = [
						'shop_id' => $order->shop_id,
						'account_id' => $order->order_account_id,
						'account_name' => $order->order_account_name,
						'shift_id' => $order->shift_id,
						'order_id' => $order->id,
						'regdate_local' => $order->regdate_local,
						'update_local' => $order->last_update_local,
						'type' => Constant::TRASACTION_TYPE_EXPORT,
						'amount' => $total_amount_export,
						'category' => '20', // chi gia von
						'business_start_hour' => $shop->business_start_hour,
						'asset_id' => $asset_id,
						'asset_name' => $asset_name,
						'format_currency' => $shop->format_currency,
						'shift_local_id' => $shift_local_id,
						'inprice_export_tran_report_flg' => $shop->inprice_export_tran_report_flg,
					];
					transaction::addTransactionInventory($transaction_inventory_params);
				}
			}
			//cancel order
			if($is_cancel_order) {
				$params = [
					'regdate_local' => $order->order_update_local_time,
				];
				$inventory_transaction_masters = InventoryTransactionMaster::model()->getByOrderIdAndTypeAndShopId($order->id, Constant::TRASACTION_TYPE_EXPORT, $shop_id);
				foreach($inventory_transaction_masters as $inventory_transaction_master) {
					inventory_master::addBalanceInventoryByInventoryTransactionMasterId($inventory_transaction_master->id, $params);
					inventory_transaction_master::deleleTransactionOrder($inventory_transaction_master->id, null, true);
				}
			}
			
			$is_save = true;
			DB::commit();

			foreach ($promotions as &$promotion) {
				$promotion['amount_used'] = promotion_detail::updatePromotionDetailById($promotion['detail_id'], $promotion['use_amount']);
				unset($promotion['use_amount']);
			}
		}
		catch(Exception $e) {
			$data_msg_return = 'transaction_rollback_server';
			$error_msg = $e->getMessage(). ' Transaction rollback. Line: ' . __LINE__;
			return $this->returnInvalidOrder($order, $shop_id, $error_msg, $data_msg_return);
		}

		if(isset($product_inv_ids) && $product_inv_ids){
            $list_inventory = inventory_master::getListInventoryById($product_inv_ids, $shop_id);
        }
        else {
            $list_inventory = [];
        }

		if($is_new_order)
			$action_code = Constant::SYNC_ORDER_NEW;
		else {
			$action_code = Constant::SYNC_ORDER_UPDATE_SERVER;
		}

		if($generate_order_code_flg && $is_save) { //check transaction
			DB::beginTransaction();
			try {
				$order_code = Util::getOrderCode($shop_id);
				$order->code = $order_code;
				order::updateOrderAttributeByOrderId($order->id, $shop_id, 'code', $order_code);
				DB::commit();
			}
			catch(Exception $e) {
				DB::rollBack();
			}
		}

		if($is_save) { // && !$request->nopush
			$push_type = $is_new_order ? Constant::PUSH_TYPE_NEW_ORDER : Constant::PUSH_TYPE_UPDATE_ORDER;
			Artisan::call('pushSyncOrder', [
				'order_id' => $order->id,
				'shop_id' => $shop_id,
				'push_type' => $push_type,
				'--device_id' => $request->device_id
			]);
		}

		if(!$order_products_db) {
			$order_products_db = order::getOrderProductByOrderId($order->id, $shop_id);
		}
		$items = $order_products_db;

		$customer_order_count = 0;
		if($customer_id) {
			$customer_order_count = customer_supplier::getOrderCountByCustomerId($customer_id, $shop_id);
		}

		$data = [
			'server_status_return' => $data_msg_return,
			'action_code' => $action_code,
			'order' => $order,
			'order_product' => $items,
			'customer_order_count' => $customer_order_count,
			'promotion' => $promotions,
            'inventory' => $list_inventory
		];

//		$postlog_msg = Yii::t('postlog', 'msg.sucess') . '. Status: ';
//		$response_msg = json_encode($data);
//		PostLog::model()->savePostLogMsg($postlog_msg, false, 0, $response_msg, $data_msg_return);
		return $this->respondSuccess($data);
    }

	private function returnInvalidOrder($order, $shop_id, $error_surfix = '', $data_msg_return = false) {
		$items = order::getOrderProductByOrderId($order->id, $shop_id);

		$customer_order_count = 0;
		if($order->customer_id) {
			$customer_order_count = customer_supplier::getOrderCountByCustomerId($order->customer_id, $shop_id);
		}

		if(!$data_msg_return) {
			$data_msg_return = 'data_invalid';
		}

		$data_return = [
			'server_status_return' => $data_msg_return,
			'action_code' => '1',
			'order' => $order,
			'order_product' => $items,
			'customer_order_count' => $customer_order_count,
		];

		DB::rollBack();

//		$postlog_msg = Yii::t('postlog', 'msg.error.order_invalid').'.'.$error_surfix;
//		$response_msg = CJSON::encode($data_return);
//		PostLog::model()->savePostLogMsg($postlog_msg, true, 0, $response_msg, $data_msg_return);
		return $this->respondSuccess($data_return, 'Dữ liệu gửi không hợp lệ');
	}
}
