<?php

namespace App;

use App\Helper\Constant;
use App\Helpers\Util;
use App\Models\inventory_transaction_master;
use App\Models\product_extend;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class inventory_master extends Model
{
    public $timestamps = false;
    protected $table = 'inventory_master';
    protected $fillable = [
        'shop_id',
        'facility_id',
        'product_id',
        'product_extend_id',
        'product_status',
        'total_balance',
        'avgprice',
    ];
    
    
    /**
     * @param $shop_id
     * @param $product_id
     * @param $product_extend_id
     * @param $quantity
     * @param $total
     * @param $facility_id
     * @param $type
     * @param int $stocktake_quanity
     * @param int $sub_type
     * @param $batch_no
     * @param $batch_expire_date
     * @return mixed
     */
    public static function createInventoryMaster(
        $shop_id,
        $product_id,
        $product_extend_id,
        $quantity,
        $total,
        $facility_id,
        $type,
        $stocktake_quanity = 0,
        $sub_type = 0,
        $batch_no,
        $batch_expire_date
    ){
        $inventory_master = self::checkExistsInventoryMaster($shop_id, $product_id, $product_extend_id, $facility_id);
        
        if ($inventory_master) {
            switch ($type) {
                case 1:
                    $avg_price = inventory_transaction::setAvgPriceProduct(
                        $shop_id,
                        $product_id,
                        $product_extend_id
                    );
                    if($quantity) {
                        $inventory_master->avgprice = $avg_price ?? ($total / $quantity);
                    }
                    else {
                        $inventory_master->avgprice = $avg_price ?? 0;
                    }

                    $inventory_master->total_balance += $quantity;
                    break;
                case 2:
                    $inventory_master->avgprice = inventory_transaction::setAvgPriceProduct(
                        $shop_id,
                        $product_id,
                        $product_extend_id
                    );
                    $inventory_master->total_balance -= $quantity;
                    break;
                case 3:
                    $inventory_master->total_balance = $stocktake_quanity;
                    break;
            }
            if ($inventory_master->total_balance < 0 && !($type == 2 && $sub_type == Constant::TRANSACTION_SUBTYPE_ORDER)) {
                $data['msg_error'] = __('messages.inventory_is_not_enough');
                return $data;
            }

            $inventory_master->lastupdate = Carbon::now()->format('Y-m-d H:i:s');
            $inventory_master->save();
        } else {
            $inventory_master = new inventory_master();
            $inventory_master->shop_id = $shop_id;
            $inventory_master->facility_id = $facility_id;
            $inventory_master->product_id = $product_id;
            $inventory_master->product_extend_id = $product_extend_id;
            $inventory_master->total_balance = $quantity;
            $inventory_master->avgprice = $quantity ? ($total / $quantity) : 0;
            $inventory_master->batch_expire_date = $batch_expire_date;
            $inventory_master->batch_no = $batch_no;
            $inventory_master->invalid = 0;
            $inventory_master->regdate = Carbon::now()->format('Y-m-d H:i:s');
            if ($type == 2) {
                $data['msg_error'] = __('messages.inventory_is_not_enough');
                return $data;
            }
            $inventory_master->save();
        }
    }

    public static function checkExistsInventoryMaster(
        $shop_id,
        $product_id,
        $product_extend_id,
        $facility_id
    ) {
        $inventory_master = inventory_master::where([
            'shop_id' => $shop_id,
            'product_id' => $product_id,
            'product_extend_id' => $product_extend_id,
            'facility_id' => $facility_id,
            'invalid' => 0,
        ])->first();

        return $inventory_master;
    }

    /**
     * @param $shop_id
     * @param $product_id
     * @param $product_extend_id
     * @return mixed
     */
    /*public static function totalPrestock(
        $shop_id,
        $product_id,
        $product_extend_id
    ) {
        $inventory_master = inventory_master::select('total_balance')
            ->where([
                'shop_id' => $shop_id,
                'product_id' => $product_id,
                'product_extend_id' => $product_extend_id,
                'invalid' => 0,
            ])->first();

        return $inventory_master ? $inventory_master->total_balance : 0;
    }*/
    
    
    /**
     * @param $shop_id
     * @param $facility_id
     * @param $product_id
     * @param $product_extend_id
     * @param $quantity
     * @param $type
     * @param $new_quantity
     * @return mixed
     */
    public static function editInventory(
        $shop_id,
        $facility_id,
        $product_id,
        $product_extend_id,
        $quantity,
        $type
    ) {
        $inventory = inventory_master::where([
            'shop_id' => $shop_id,
            'facility_id' => $facility_id,
            'product_id' => $product_id,
            'product_extend_id' => $product_extend_id,
            'invalid' => 0,
        ])->first();


        if($type == 1) {
            $inventory->total_balance -= $quantity;
        }
        else {
            $inventory->total_balance += $quantity;
        }
        if($inventory->total_balance) {
            $inventory->avgprice = inventory_transaction::setAvgPriceProduct(
                $shop_id,
                $product_id,
                $product_extend_id
            );
        }
        
        return $inventory->save();
    }


    /**
     * @param $shop_id
     * @return mixed
     */
    public static function getAllInventoryMaster($shop_id) {
        $data = inventory_master::where([
            'shop_id' =>  $shop_id,
            'invalid' => 0
        ])->get()->makeHidden('invalid');

        return $data;
    }

    public static function getListProductInInventory($shop_id, $key_search, $limit = Constant::LIMIT_PAGINATION) {
        $data = inventory_master::where([
                'inventory_master.shop_id' => $shop_id,
                'inventory_master.invalid' => 0,
                'product.invalid' => 0,
            ])
            ->join('product', function($join) {
                $join->on('product.product_id', '=', 'inventory_master.product_id');
            })
            ->join('inventory_transaction', function ($join) {
                $join->on('inventory_master.product_id', '=', 'inventory_transaction.product_id')
                    ->on('inventory_master.product_extend_id', '=', 'inventory_transaction.product_extend_id');
            })
            ->join('inventory_transaction_master', function ($join) {
                $join->on('inventory_transaction_master.id', '=', 'inventory_transaction.transaction_masterid');
            });

        if($key_search) {
            $data->whereRaw("(product.product_name LIKE '%{$key_search}%' OR product.product_code LIKE '%{$key_search}%' OR inventory_transaction_master.code LIKE '%{$key_search}%')");
        }

        $query_product  = $data->select(
            'inventory_master.id',
            'inventory_master.shop_id',
            'inventory_master.product_id',
            'inventory_master.total_balance',
            'inventory_master.avgprice',
            'product.product_master_id',
            'product.product_id',
            'product.product_code',
            'product.product_name',
            'product.unit_id',
            'product.unit_name',
            'product.info1',
            'product.info2',
            'product.info3',
            'product.info4',
            'product.info5',
            'product.info6',
            'inventory_master.product_extend_id',
            'inventory_master.batch_no',
            'inventory_master.batch_expire_date'
        )
        ->orderBy('inventory_master.product_id', 'desc')
        ->orderBy('inventory_master.product_extend_id', 'desc')
        ->groupBy('inventory_master.id')->paginate($limit);

        $count = $query_product->total();
        $data_list = $query_product->items();

        $data = [
            'total' => ceil($count / $limit),
            'list_items' => $data_list
        ];

        return $data;
    }

    public static function getListBatch($shop_id, $product_id) {
        $data_batch = inventory_master::where([
            'inventory_master.shop_id' => $shop_id,
            'inventory_master.invalid' => 0,
            'inventory_master.product_id' => $product_id
        ])
            ->leftJoin('product_extend', function ($join) {
                $join->on('product_extend.id', '=', 'inventory_master.product_extend_id')
                    ->on('product_extend.product_id', '=', 'inventory_master.product_id');
            })
            ->select(
                'inventory_master.product_id',
                'inventory_master.product_extend_id',
                'inventory_master.total_balance',
                'product_extend.batch_no',
                'product_extend.batch_expire_date'
            )
        ->get();

        return $data_batch;
    }

    public static function addBalanceInventoryByInventoryTransactionMasterId($transaction_id, $params) {
        $old_transaction_master = inventory_transaction_master::where(['id' => $transaction_id])->first();
        $old_transactions = inventory_transaction::where(['transaction_masterid' => $transaction_id])->get();

        $now = Carbon::now()->format('Y-m-d H:i:s');
        $shop_id = $old_transaction_master->shop_id;
        $local_id  = Util::getLocalId($shop_id);
        $facility_id = $old_transaction_master->facility_id;
        $type = $old_transaction_master->type == Constant::TRASACTION_TYPE_IMPORT ? Constant::TRASACTION_TYPE_EXPORT : Constant::TRASACTION_TYPE_IMPORT;
        $sub_type = 2;


        $transaction_master = new inventory_transaction_master();
        $columns = Schema::getColumnListing('inventory_transaction_master');
        foreach ($columns as $column) {
            $transaction_master->$column = $old_transaction_master->$column;
        }
        $transaction_master->id = $local_id;
        $transaction_master->code = inventory_transaction_master::genInventoryTransactionMasterCode($shop_id, $type);
        $transaction_master->shop_id = $shop_id;
        $transaction_master->type = $type;
        $transaction_master->sub_type = $sub_type;
        $transaction_master->itm_regdate = $now;
        $transaction_master->dateCreated = $params['regdate_local'];
        $transaction_master->save();

        $new_transaction = [];
        foreach($old_transactions as $old_transaction) {
            $columns = Schema::getColumnListing('inventory_transaction');
            foreach ($columns as $column) {
                $data_transaction[$column] = $old_transaction->$column;
            }
            $data_transaction['type'] = $type;
            $data_transaction['sub_type'] = $sub_type;
            $data_transaction['code'] = inventory_transaction_master::genInventoryTransactionMasterCode($shop_id, $data_transaction['shop_id']);
            $data_transaction['id'] = Util::getLocalId($shop_id);
            $new_transaction[] = $data_transaction;

            $product_extend = product_extend::getProductExtendByid($data_transaction['product_extend_id']);
            $batch_no = $product_extend ? $product_extend->batch_no : null;
            $batch_expire_date = $product_extend ? $product_extend->batch_expire_date : null;
            self::createInventoryMaster(
                $data_transaction['shop_id'],
                $data_transaction['product_id'],
                $data_transaction['product_extend_id'],
                $data_transaction['quantity'] * $data_transaction['primary_unit_convert'],
                $data_transaction['total'],
                $facility_id,
                $type,
                $stocktake_quanity = 0,
                $sub_type,
                $batch_no,
                $batch_expire_date
            );

            inventory_detail::createOrUpdateInventoryInDay(
                $data_transaction['shop_id'],
                $data_transaction['product_id'],
                $data_transaction['product_extend_id'],
                $facility_id,
                $data_transaction['quantity'] * $data_transaction['primary_unit_convert'],
                $type,
                $sub_type,
                $now,
                $batch_no,
                $batch_expire_date
            );
        }
        inventory_transaction::insert($new_transaction);

    }

    public static function getAvgPriceByProductId($product_id, $shop_id, $extend_id) {
        $prices = inventory_master::where([
            'product_id' => $product_id,
            'shop_id' => $shop_id,
            'product_extend_id' => $extend_id,
            'invalid' => 0,
        ])->select('avgprice')->first();
        return $prices ? $prices->avgprice : 0;
    }

    public static function getListInventoryById($ids, $shop_id) {
        $inventorys = inventory_master::where(['shop_id' => $shop_id, 'invalid' => 0])->whereIn('product_id',
            $ids)->get();

        return $inventorys->makeHidden('invalid');
    }

    public static function reportProduct($shop_ids) {
        $expire_date = Carbon::now()->addDays(Constant::LIMIT_BATCH_EXPIRE_DATE)->format('Y-m-d 23:59:59');
        $out_of_stock = Constant::OUT_OF_STOCK;
        $data = self::select(
            DB::raw("sum(if(batch_expire_date < '{$expire_date}', 1, 0)) as expire_date"),
            DB::raw("sum(if(total_balance < '{$out_of_stock}', 1, 0)) as out_of_stock")
        )
            ->where('invalid', 0)
            ->whereIn('shop_id', $shop_ids)
            ->first();

        $data_product = ['expire_date' => $data->expire_date, 'out_of_stock' => $data->out_of_stock];
        return $data_product;
    }
}
