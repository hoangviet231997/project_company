<?php

namespace App;

use App\Helpers\Util;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class inventory_transaction extends Model
{
    protected $table = 'inventory_transaction';
    public $timestamps = false;
    const CREATED_AT = 'regdate';
    const UPDATED_AT = 'update';

    public $fillable = [
        'shop_id',
        'transaction_masterid',
        'local_id',
        'account_id',
        'account_name',
        'product_id',
        'product_name',
        'product_code',
        'product_extend_id',
        'batch_no',
        'batch_expire_date',
        'sellprice',
        'costprice',
        'costvat',
        'discount',
        'total',
        'stocktake_quanity',
        'note',
        'regdate',
        'regdate_local',
        'type',
        'sub_type',
        'update',
        'update_local',
        'printdate',
        'status',
        'invalid'
    ];

    public static function createTransaction($product) {
        return inventory_transaction::insert($product);
    }
    
    /**
     * @param $shop_id
     * @param $transaction_master_id
     * @param $facility_id
     * @param $update
     * @param $new_quantity
     * @return mixed
     */
    public static function editTransaction($shop_id, $transaction_master_id, $facility_id, $update) {
        $transactions = inventory_transaction::where([
            'shop_id' => $shop_id,
            'transaction_masterid' => $transaction_master_id,
            'invalid' => 0
        ])->get();

        $now = Carbon::now()->format('Y-m-d H:i:s');
        if($transaction_master_id && $transactions) {
            foreach ($transactions as $key => $transaction) {
                $date = $transaction->regdate;
                
                inventory_master::editInventory(
                    $shop_id,
                    $facility_id,
                    $transaction->product_id,
                    $transaction->product_extend_id,
                    $transaction->quantity * $transaction->primary_unit_convert,
                    $transaction->type
                );

                inventory_detail::editInventoryInDay(
                    $shop_id,
                    $facility_id,
                    $transaction->product_id,
                    $transaction->product_extend_id,
                    $transaction->quantity * $transaction->primary_unit_convert,
                    $transaction->type,
                    $transaction->sub_type,
                    $date
                );
            }

            DB::table('inventory_transaction')->where([
                'shop_id' => $shop_id,
                'transaction_masterid' => $transaction_master_id,
                'invalid' => 0
            ])->update(['invalid' => 1,'update_local' => $update,'update' => $now]);

            DB::table('inventory_transaction_log')->where([
                'transaction_masterid' => $transaction_master_id
            ])->update(['invalid' => 1,'update_local' => $update,'update' => $now]);
        }
        else {
            $data['msg_error'] = __('messages.canNotFoundResource');
            return $data;
        }
    }


    /**
     * @param $shop_id
     * @param $transaction_id
     * @param $master_id
     * @param $facility_id
     * @param $local_id
     * @param $account_id
     * @param $account_name
     * @param $type
     * @param $sub_type
     * @param $regdate_local
     * @return mixed
     */
    public static function cancelTransaction(
        $shop_id,
        $transaction_id,
        $master_id,
        $facility_id,
        $account_id,
        $account_name,
        $type,
        $sub_type,
        $regdate_local
    ) {
        $transactions = inventory_transaction::where([
            'shop_id' => $shop_id,
            'transaction_masterid' => $transaction_id,
            'invalid' => 0
        ])->get();
        if($transactions) {
            $transaction_add = [];
            foreach ($transactions as $key => $transaction) {
                $transaction->status = 5; //type bill cancel
                $transaction->save();

                $data_transaction['id'] = Util::getLocalId($shop_id);
                $data_transaction['shop_id'] = $shop_id;
                $data_transaction['transaction_masterid'] = $master_id;
                $data_transaction['account_id'] = $account_id;
                $data_transaction['account_name'] = $account_name;
                $data_transaction['product_id'] = $transaction->product_id;
                $data_transaction['product_name'] = $transaction->product_name;
                $data_transaction['product_code'] = $transaction->product_code;
                $data_transaction['product_extend_id'] = $transaction->product_extend_id;
                $data_transaction['batch_no'] = $transaction->batch_no;
                $data_transaction['batch_expire_date'] = $transaction->batch_expire_date;
                $data_transaction['quantity'] = $transaction->quantity;
                $data_transaction['unit_id'] = $transaction->unit_id;
                $data_transaction['unit_name'] = $transaction->unit_name;
                $data_transaction['primary_unit_convert'] = $transaction->primary_unit_convert;
                $data_transaction['sellvat'] = $transaction->sellvat;
                $data_transaction['sellprice'] = $transaction->sellprice;
                $data_transaction['version_code'] = $transaction->version_code;
                $data_transaction['costprice'] = $transaction->costprice;
                $data_transaction['costvat'] = $transaction->costvat;
                $data_transaction['total'] = $transaction->total;
                $data_transaction['stocktake_quanity'] = $transaction->stocktake_quanity;
                $data_transaction['regdate_local'] = $regdate_local;
                $data_transaction['regdate'] = $regdate_local;
                $data_transaction['status'] = 0;
                $data_transaction['type'] = $type;
                $data_transaction['sub_type'] = $sub_type;

                if($type == 3) {
                    $stocktake_quanity = $transaction->stocktake_quanity + $transaction->quantity;
                    $quantity = (-1) * $transaction->quantity * $transaction->primary_unit_convert;
                    $data_transaction['stocktake_quanity'] = $stocktake_quanity;
                    $data_transaction['quantity'] = $quantity;
                }
                else {
                    $stocktake_quanity = 0;
                    $quantity = $transaction->quantity * $transaction->primary_unit_convert;
                }

                $transaction_add[] = $data_transaction;

                $inventory = inventory_master::createInventoryMaster(
                    $shop_id,
                    $transaction->product_id,
                    $transaction->product_extend_id,
                    $transaction->quantity * $transaction->primary_unit_convert,
                    $transaction->total,
                    $facility_id,
                    $type,
                    $stocktake_quanity,
                    $sub_type,
                    $transaction->batch_no,
                    $transaction->batch_expire_date
                );

                if(isset($inventory['msg_error'])) {
                    return $inventory;
                }

                inventory_detail::createOrUpdateInventoryInDay(
                    $shop_id,
                    $transaction->product_id,
                    $transaction->product_extend_id,
                    $facility_id,
                    $quantity,
                    $type,
                    $sub_type,
                    $regdate_local,
                    $transaction->batch_no,
                    $transaction->batch_expire_date
                );
            }
            inventory_transaction::insert($transaction_add);
            DB::table('inventory_transaction_log')->insert($transaction_add);
        }
    }

    public static function setAvgPriceProduct($shop_id, $product_id, $product_extend_id) {
        $data_total = inventory_transaction::where([
            'shop_id' => $shop_id,
            'product_id' => $product_id,
            'product_extend_id' => $product_extend_id,
            'type' => 1,
            'invalid' => 0
        ])->sum(DB::raw('total / (quantity * primary_unit_convert)'));
        return $data_total;
    }
}
