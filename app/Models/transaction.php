<?php

namespace App\Models;

use App\Helper\Constant;
use App\Helpers\Util;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class transaction extends Model
{
    protected $table = 'transaction';
    public $timestamps = false;

	public static function getTransactionById($id, $shop_id) {
		return transaction::where([
			'id' => $id,
			'shop_id' => $shop_id,
			'invalid' => 0,
		])->first();
	}

	public static function getTransactionByLocalId($local_id, $shop_id) {
		return transaction::where([
			'local_id' => $local_id,
			'shop_id' => $shop_id,
			'invalid' => 0,
		])->first();
	}

	public static function updateTransactionByParams($local_id, $params) { //exclude customer debt
		$shop_id = $params['shop_id'];
		$payment_amount = $params['amount'];
		$payment_version_code = $params['version_code'];
		$payment_notes = $params['notes'];
		$payment_business_start_hour = $params['business_start_hour'];
		$asset_id = $params['asset_id'];
		$shift_local_id = $params['shift_local_id'];

		/** @var transaction $transaction */
		$transaction = transaction::getTransactionByLocalId($local_id, $shop_id);

		$now = Util::getNow();
		$transaction->update = $now;
		$diff_total = 0;
		$old_total = $transaction->total;

		if($payment_amount != $old_total) {
			$diff_total = $payment_amount - $old_total;
		}
		$transaction->version_code = $payment_version_code;
		$transaction->note = $payment_notes;
		$transaction->amount = $payment_amount;
		$transaction->total = $payment_amount;
		$transaction->shift_local_id = $shift_local_id;
		$transaction->input_amount = $payment_amount;
		$transaction->total_asset = $payment_amount;
		$transaction->save();

		$asset = asset::getAssetById($asset_id);

		if($transaction->type == 1) {
			$asset_total = $asset->asset_total + $diff_total;
		}
		else {
			$asset_total = $asset->asset_total - $diff_total;
		}

		asset::updateAssetAttributeByAssetId($asset_id, $shop_id, 'asset_total', $asset_total);

		//Asset amount log
		$business_date_timestamp = Util::getBusinessDateTimestamp($transaction->update_local, $payment_business_start_hour, true);
		asset_amount_log::updateAssetAmountLog($asset_id, $shop_id, $diff_total, $business_date_timestamp, $transaction->type);
	}

	public static function addTransactionByParams($params) {
		$asset_id = $params['asset_id'];
		$asset_name = $params['asset_name'];
		$amount = $params['total_price'] - $params['paid_total'];
		$transaction_local_id = $params['order_local_id'];
		$category = $params['category'];
		$source_type = $params['source_type'];
		$source_id = $params['source_id'];
		$type = $params['type'];
		$sub_type = $params['sub_type'];
		$grand_total = $params['grand_total'];
		$transaction_fee_ship = $params['transaction_fee_ship'];
		$transaction_surcharge = $params['transaction_surcharge'];
		$transaction_discount = $params['transaction_discount'];
		$revenueship_flg = $params['revenueship_flg'];
		$report_flg = Util::getParam($params, 'report_flg', 1);
		$version_code = Util::getParam($params, 'version_code', 1);
		$is_deposit = Util::getParam($params, 'is_deposit', 0);
		$note = Util::getParam($params, 'note', '');
		$transaction_ignore = $params['transaction_ignore'];
		$shift_local_id = Util::getParam($params, 'shift_local_id', 0);
		$shop_id = $params['shop_id'];

		$trans = new transaction();
		$trans->code = Util::genTransactionID($shop_id, $sub_type);
		$trans->regdate = Util::getNow();
		$trans->type = $type;
		$trans->sub_type = $sub_type;
		$trans->local_id = $transaction_local_id;
		$trans->version_code = $version_code;
		$trans->category = $category;
		$trans->account_id = $params['cashier_id'];
		$trans->account_name = $params['cashier_name'];
		$trans->amount = $params['total_price'];
		$trans->total = $grand_total;
		$trans->transaction_discount = $transaction_discount;
		$trans->transaction_surcharge = $transaction_surcharge;
		$trans->transaction_fee_ship = $transaction_fee_ship;
		$trans->revenueship_flg = $revenueship_flg;
		$trans->report_flg = $report_flg;
		$trans->transaction_ignore = $transaction_ignore;
		$trans->debt_amount = $amount;
		$trans->note = $note;
		$trans->is_deposit = $is_deposit;

		//transaction cho việc tính doanh thu
		$customer = customer_supplier::getCustomerSupplierById($params['customer_id'], $shop_id);
		if($customer) {
			$trans->whowith_id = $customer->id;
			$trans->whowith_name = $customer->name;
		}

		$trans->regdate_local = $params['regdate_local'];
		$trans->update_local = $params['update_local'];
		$trans->shop_id = $shop_id;
		$trans->asset_id = $asset_id;
		$trans->asset_name = $asset_name;
		$trans->shift_id = $params['shift_id'];
		$trans->soure_type = $source_type;
		$trans->soure_id = $source_id;
		$trans->customer_debt_flg = 0;
		$trans->transaction_business_date = Util::getBusinessDateTimestamp($trans->update_local, $params['business_start_hour']);
		$trans->input_amount = $trans->amount - $trans->transaction_surcharge + $trans->transaction_discount - $trans->transaction_fee_ship;
		$trans->total_asset = $params['total_price']; //$params['paid_total']; //total quỹ tiền
		$trans->shift_local_id = $shift_local_id;

		$trans->save();

		asset::updateAssetTotalTransactionByAssetId($asset_id, $shop_id, $trans->total_asset, $trans->type);
		//Asset amount log
		$business_date_timestamp = Util::getBusinessDateTimestamp($trans->update_local, $params['business_start_hour'], true);
		asset_amount_log::updateAssetAmountLog($asset_id, $shop_id, $trans->total_asset, $business_date_timestamp, $trans->type);

		//transaction customer debt
		if($params['paid_total'] < $params['total_price'] && $customer) {
			$regdate_local_after_1_second = date('Y-m-d H:i:s', strtotime('+1 second', strtotime($params['regdate_local'])));
			$update_local_after_1_second = date('Y-m-d H:i:s', strtotime('+1 second', strtotime($params['update_local'])));

			$trans2 = new transaction();
			$trans2->code = Util::genTransactionID($shop_id, 15);
			$trans2->regdate = date('Y-m-d H:i:s', strtotime('+1 second'));
			$trans2->type = $type == 1 ? 2 : 1; //phát sinh phiếu cân bằng với type ngược lại
			$trans2->sub_type = $params['sub_type_balance'];
			$trans2->local_id = Util::getLocalId($shop_id);
			$trans2->version_code = 1;
			$trans2->category = $params['category_balance'];
			$trans2->account_id = $params['cashier_id'];
			$trans2->account_name = $params['cashier_name'];
			$trans2->amount = $amount;
			$trans2->total = $amount; //phieu chi de thong ke doanh thu

			if($trans2->type == 1) {
				$after_amount = $customer->debt - $amount;
			}
			else {
				$after_amount = $customer->debt + $amount;
			}
			$pre_amount = $customer->debt;

			$trans2->after_amount = $after_amount;
			$trans2->pre_amount = $pre_amount;
			$trans2->whowith_id = $customer->id;
			$trans2->whowith_name = $customer->name;
			$trans2->debt_amount = $amount;

			$customer->debt = $trans2->after_amount;
			$customer->save();

			$trans2->shift_local_id = $shift_local_id;
			$trans2->regdate_local = $regdate_local_after_1_second; //sequence auto transaction
			$trans2->update_local = $update_local_after_1_second; //sequence auto transaction
			$trans2->shop_id = $shop_id;
			$trans2->asset_id = $asset_id;
			$trans2->asset_name = $asset_name;
			$trans2->shift_id = $params['shift_id'];
			$trans2->soure_type = $source_type;
			$trans2->soure_id = $source_id;
			$trans2->customer_debt_flg = 1;
			$trans2->transaction_business_date = Util::getBusinessDateTimestamp($trans2->update_local, $params['business_start_hour']);
			$trans2->transaction_discount = $transaction_discount;
			$trans2->transaction_surcharge = $transaction_surcharge;
			$trans2->transaction_fee_ship = $transaction_fee_ship;
			$trans2->revenueship_flg = $revenueship_flg;
			$trans2->input_amount = $trans2->amount - $trans2->transaction_surcharge + $trans2->transaction_discount - $trans2->transaction_fee_ship;

			$trans2->total_asset = $amount;
			$trans2->save();
			asset::updateAssetTotalTransactionByAssetId($asset_id, $shop_id, $trans2->total_asset, $trans2->type);

			//Asset amount log
			$business_date_timestamp = Util::getBusinessDateTimestamp($trans2->update_local, $params['business_start_hour'], true);
			asset_amount_log::updateAssetAmountLog($asset_id, $shop_id, $trans2->total_asset, $business_date_timestamp, $trans2->type);

			$after_transaction = transaction::getAfterTransactionBalanceFromReferTransactionByCustomerId($trans2->type, $customer->id, $trans2->local_id, $amount, $trans2->transaction_refer_ids, $shop_id);

			transaction::where([
				'id' => $trans2->id,
				'shop_id' => $shop_id
			])->update([
				'transaction_balance' => $after_transaction['transaction_balance'],
				'transaction_refer_ids' => $after_transaction['transaction_refer_ids'],
			]);
		}
	}

	public static function getCountTransactionByShopId($shop_id) {
		return transaction::where('shop_id', $shop_id)->count();
	}

	public static function getAfterTransactionBalanceFromReferTransactionByCustomerId($type, $customer_id, $transaction_local_id, $transaction_balance, $parent_transaction_refer_ids, $shop_id) {
		$refer_type = $type == Constant::TRASACTION_TYPE_IMPORT ? Constant::TRASACTION_TYPE_EXPORT : Constant::TRASACTION_TYPE_IMPORT;

		$transactions_refer = transaction::where([
			'type' => $refer_type,
			'whowith_id' => $customer_id,
			'shop_id' => $shop_id,
			'customer_debt_flg' => 1,
			'invalid' => 0,
		])->where('transaction_balance', '>', 0)
		  ->orderByRaw('update_local asc, id asc')
		  ->get();

		foreach ($transactions_refer as $transaction_refer) {
			if($transaction_balance > 0) {
				$transaction_refer_balance = $transaction_refer->transaction_balance;
				if($transaction_refer_balance > $transaction_balance) {
					$transaction_refer_balance_after = $transaction_refer_balance - $transaction_balance;
				}
				else {
					$transaction_refer_balance_after = 0;
				}

				$transaction_refer_ids = $transaction_refer->transaction_refer_ids.$transaction_local_id.',';

				transaction::where([
					'id' => $transaction_refer->id,
					'shop_id' => $shop_id
				])->update([
					'transaction_balance' => $transaction_refer_balance_after,
					'transaction_refer_ids' => $transaction_refer_ids,
				]);

				$transaction_balance -= $transaction_refer_balance;
				$parent_transaction_refer_ids = $parent_transaction_refer_ids.$transaction_refer->transaction_local_id.',';
			}
			else {
				break;
			}
		}
		$transaction_balance = $transaction_balance < 0 ? 0 : $transaction_balance;

		return [
			'transaction_balance' => $transaction_balance,
			'transaction_refer_ids' => $parent_transaction_refer_ids,
		];
	}

	public static function deleteTransactionByOrderId($order_id, $shop_id) {
		$transactions = transaction::getTransactionByOrderId($order_id, $shop_id);
		foreach($transactions as $transaction) {
			transaction::deleteTransactionByTransactionId($transaction->id, $shop_id, false);
		}
	}

	public static function getTransactionByOrderId($order_id, $shop_id) {
		return transaction::where([
			'soure_id' => $order_id,
			'shop_id' => $shop_id,
		])->get();
	}

	public static function deleteTransactionByTransactionId($id, $shop_id, $is_transaction = true) {
		if($is_transaction) {
			DB::beginTransaction();
		}

		try {
			$trans = transaction::getTransactionById($id, $shop_id);

			$now = Util::getNow();
			$customer = customer_supplier::getCustomerSupplierById($trans->whowith_id, $shop_id);
			$asset_id = $trans->asset_id;
			$diff_total = -$trans->total;

			$trans->update = $now;
			$trans->invalid = 1;

			if($trans->customer_debt_flg == 1 && $customer) {
				if($trans->type == 1) {
					$customer->debt -= $diff_total;
				}
				else {
					$customer->debt += $diff_total;
				}
				$customer->save();
			}

			if($trans->save()) {
				$asset = asset::getAssetById($asset_id, $shop_id);
				if($trans->type == 1) {
					$asset_total = $asset->asset_total + $diff_total;
				}
				else {
					$asset_total = $asset->asset_total - $diff_total;
				}

				if($trans->customer_debt_flg == 1 && $customer) {
					transaction::updatePreAfterAmountAfterTransaction($trans->id, $trans->type, $shop_id, $diff_total, $trans->whowith_id, $trans->update_local);
					transaction::reCalculateTransactionBalanceAndReferIdsByCustomer($trans->whowith_id, $shop_id);
				}
				asset::updateAssetAttributeByAssetId($asset_id, $shop_id, 'asset_total', $asset_total);

				//Asset amount log
				$shop = shop::getShopById($shop_id);
				$business_date_timestamp = Util::getBusinessDateTimestamp($trans->update_local, $shop->business_start_hour, true);
				asset_amount_log::updateAssetAmountLog($asset_id, $shop_id, $diff_total, $business_date_timestamp, $trans->type);

				if($is_transaction) {
					DB::commit();
				}

				return 'success';
			}
			else {
				if($is_transaction) {
					DB::rollBack();
				}

				return 'fail';
			}
		}
		catch (Exception $e) {
			if($is_transaction) {
				DB::rollBack();
			}

			return $e->getMessage();
		}
	}

	public static function updatePreAfterAmountAfterTransaction($transaction_id, $type, $shop_id, $total, $customer_id, $update_local) {
		$operator = $type == 1 ? '-' : '+';
		$sql = <<<EOD
update `transaction` 
set pre_amount = pre_amount {$operator} {$total},
after_amount = after_amount {$operator} {$total} 
where customer_debt_flg = 1 and whowith_id = '{$customer_id}' and shop_id = '{$shop_id}' 
and invalid = 0 and update_local >= '{$update_local}' and id != '{$transaction_id}'
EOD;
		DB::update($sql);
	}

	public static function reCalculateTransactionBalanceAndReferIdsByCustomer($customer_id, $shop_id) {
		$sql = <<<EOD
update `transaction`
set transaction_balance = total,
transaction_refer_ids = null
where whowith_id = '{$customer_id}' and shop_id = '{$shop_id}' and customer_debt_flg = 1 and invalid = 0
EOD;
		DB::update($sql);

		$transactions = transaction::where([
			'whowith_id' => $customer_id,
			'shop_id' => $shop_id,
			'customer_debt_flg' => 1,
			'invalid' => 0,
		])->where('transaction_balance', '>', 0)->orderByRaw('update_local asc, id asc')->get();

		foreach ($transactions as $transaction) {
			$after_transaction = transaction::getAfterTransactionBalanceFromReferTransactionByCustomerId($transaction->type, $customer_id, $transaction->local_id, $transaction->transaction_balance, $transaction->transaction_refer_ids, $shop_id);
			transaction::where([
				'id' => $transaction->id,
				'shop_id' => $shop_id
			])->update([
				'transaction_balance' => $after_transaction['transaction_balance'],
				'transaction_refer_ids' => $after_transaction['transaction_refer_ids'],
			]);
		}
	}

	public static function addTransactionInventory($params) {
	    
        $asset_id = $params['asset_id'];
        $asset_name = $params['asset_name'];
        $local_id =  Util::getLocalId($params['shop_id']);
        $sub_type = 1;
        $amount = $params['amount'];
        $shift_local_id = $params['shift_local_id'];
		/*$inprice_export_tran_report_flg = $params['inprice_export_tran_report_flg'];
        //format currency
        $format_currency = $params['format_currency'];
        $amount = Constants::getCurrency($amount, $format_currency);*/

        $transaction = new Transaction();
        $transaction->local_id = $local_id;
        $transaction->version_code = 1;
        $transaction->code = Util::genTransactionID($params['shop_id'], $sub_type);
        $transaction->account_id = $params['account_id'];
        $transaction->account_name = $params['account_name'];
        //$transaction->account_email = $params['account_email'];
        $transaction->shop_id = $params['shop_id'];
        $transaction->shift_id = $params['shift_id'];
        $transaction->auto_type = 1;
        $transaction->frequent_type = 0;
        $transaction->type = $params['type'];
        $transaction->sub_type = $sub_type;
        $transaction->asset_id = $asset_id;
        $transaction->asset_name = $asset_name;
        $transaction->status = 1;
        $transaction->amount = $amount;
        $transaction->total = $amount;
        $transaction->soure_type = 1;
        $transaction->soure_id = $params['order_id'];
        $transaction->customer_debt_flg = 0;
        $transaction->shift_local_id = $shift_local_id;
        $transaction->transaction_ignore = 0;

        if(!empty($params['category'])){
            $transaction->category = $params['category'];
        }else{
            $transaction->category = 1;
        }

        $transaction->regdate_local = $params['update_local'];
        $transaction->update_local = $params['update_local'];
        $transaction->regdate = $transaction->update = date('Y-m-d H:i:s');
        $transaction->transaction_business_date = Util::getBusinessDateTimestamp($transaction->update_local, $params['business_start_hour']);
        $transaction->total_asset = 0; //$amount;

        $transaction->save();

        //chi giá vốn không tính vào quỹ tiền
        //Asset::model()->updateAssetTotalTransaction($asset_id, $transaction->id, $transaction->total_asset, $transaction->type);
    }
}
