<?php

namespace App\Models;

use App\facility;
use App\inventory_detail;
use App\inventory_master;
use App\inventory_transaction;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Lang;
use App\Helpers\Util;
use Illuminate\Support\Facades\Schema;
use Monolog\Processor\UidProcessor;


class inventory_transaction_master extends Model
{
    protected $table = 'inventory_transaction_master';
    public $timestamps = false;
    protected $casts = [
        'id' => 'string',
    ];
    protected $fillable = [
        'id',
        'shop_id',
        'code',
        'source_type',
        'type',
        'sub_type',
        'expensesflg',
        'transaction_with_id',
        'transaction_with_name',
        'orderdate',
        'account_id',
        'dateCreated',
        'total',
        'paidTotal',
        'status',
        'note',
		'bill_regdate',
    ];

    public function rules(Request $request)
    {
        return [
            'code' => 'max:255',
            'transaction_with_id' => 'required|integer',
            'dateCreated' => 'required|date',
            'orderdate' => 'date',
            'total' => 'integer|nullable',
            'paidTotal' => 'integer|nullable',
            'note' => 'max:255',
        ];
    }

    public function messages()
    {
        return Lang::get('validation');
    }


    public function getList($filter)
    {
        $query = $this->select(
            'id',
            'code',
            'dateCreated',
            'orderdate',
            'transaction_with_id',
            'transaction_with_name',
            'total',
            'paidTotal',
            'status',
            'note'
        )->where('invalid', 0)->where('type', $filter["type"]);

        if (isset($filter["order_flag"]) && isset($filter["date_start"]) && isset($filter["date_end"])) {
            if ($filter["order_flag"] == true) {
                $query = $query->whereBetween('orderdate', [
                    $filter["date_start"],
                    $filter["date_end"]
                ]);
            } else {
                $query = $query->whereBetween('dateCreated', [
                    $filter["date_start"],
                    $filter["date_end"]
                ]);
            }
        }
        if (isset($filter["status"]) && $filter["status"] != null) {
            $query = $query->where('status', $filter["status"]);
        }

        if (isset($filter["product_name"]) && $filter["product_name"] != null) {
            //$query = $query->where('product_name',$filter["product_name"]);
        }

        if (isset($filter["code"]) && $filter["code"] != null) {
            $query = $query->where('code', 'like', '%' . $filter["code"] . '%');
        }

        if (isset($filter["keyword"]) && $filter["keyword"] != null) {
            $query->where(function ($q) use ($filter) {
                $q->where('code', 'like', '%' . $filter["keyword"] . '%')->orWhere('transaction_with_name', 'like', '%' . $filter["keyword"] . '%');
            });
        }


        return $query->get();
    }

    public function findById($id)
    {
        return $this->select(
            'id',
            'code',
            'transaction_with_id',
            'dateCreated',
            'orderdate',
            'total',
            'paidTotal',
            'note'
        )
            ->where('id', $id)
            ->where('invalid', 0) // Check deleted
            ->first();
    }

    public function invalidById($id)
    {
        return $this->where('id', $id)->update(['invalid' => 1]);
    }

    public function getListInvTransactionMasterByBill(
        $date_from,
        $date_to,
        $status,
        $shop_ids,
        $type,
        $subtype,
        $search_code,
        $payment_status,
        $flg_bill_regdate,
        $limit
    ) {

        if (is_array($shop_ids)) {
            $query = inventory_transaction_master::whereIn('shop_id', $shop_ids);
        } else {
            $query = inventory_transaction_master::where('shop_id', $shop_ids);
        }
        if ($flg_bill_regdate == 0) {
            $query = $query->wherebetween('dateCreated', [$date_from, $date_to]);
        } else {
            $query = $query->wherebetween('bill_regdate', [$date_from, $date_to]);
        }

        $query = $query->where('type', $type)->where('sub_type', $subtype);

        if($search_code) {
            $sql_search = "(code like '%{$search_code}%' or transaction_with_name like '%{$search_code}%')";
            $query = $query->whereRaw($sql_search);
        }
		if (trim($status) !== '') {
            $query = $query->where('status', $status);
        }
        if (trim($payment_status) !== '') {
            $query = $query->where('payment_status', $payment_status);
        }

        $query = $query->paginate($limit);
        $data_list = $query->makeHidden('invalid');
        $count = $query->total();

        $data = [
            'total_page' => ceil($count / $limit),
            'current_page' => $query->currentPage(),
            'item_per_page' => $limit,
            'total_item' => $count,
            'list_items' => $data_list
        ];

        return $data;
    }

    public function getListInventoryMasterByProduct(
        $date_from,
        $date_to,
        $status,
        $shop_ids,
        $type,
        $subtype,
        $product_id,
        $payment_status,
        $flg_bill_regdate,
        $limit
    ) {
        $query = inventory_transaction_master::join('inventory_transaction', 'inventory_transaction_master.id', '=', 'inventory_transaction.transaction_masterid');

        if (is_array($shop_ids)) {
            $query = $query->whereIn('inventory_transaction_master.shop_id', $shop_ids);
        } else {
            $query = $query->where('inventory_transaction_master.shop_id', $shop_ids);
        }

        if ($flg_bill_regdate == 0) {
            $query = $query->wherebetween('dateCreated', [$date_from, $date_to]);
        } else {
            $query = $query->wherebetween('bill_regdate', [$date_from, $date_to]);
        }

        $query = $query->where([
            'product_id' => $product_id,
            'inventory_transaction_master.type' => $type,
            'inventory_transaction_master.sub_type' => $subtype,
            'inventory_transaction_master.invalid' => 0
        ]);

        if (trim($status) !== '') {
            $query = $query->where('inventory_transaction_master.status', $status);
        }
        if (trim($payment_status) !== '') {
            $query = $query->where('payment_status', $payment_status);
        }

        $query = $query->paginate($limit);
        $count = $query->total();
        $data_list = $query->makeHidden('invalid');

        $data = [
            'total' => ceil($count / $limit),
            'list_items' => $data_list
        ];

        return $data;
    }

    public function getListHistoryBillForProduct(
        $date_from, $date_to,
        $type, $sub_type,
        $product_id, $batch_id,
        $limit
    ) {
    	$date_from = Util::getDateSearch($date_from);
    	$date_to = Util::getDateSearch($date_to, false);
        $query = DB::table('inventory_detail')
            ->select(
                'inventory_transaction_master.status',
                'inventory_transaction_master.code',
                'inventory_transaction_master.dateCreated',
                'inventory_transaction_master.type',
                'inventory_transaction_master.sub_type',
                'inventory_transaction_master.transaction_with_name',
                'inventory_detail.product_id',
                'inventory_detail.product_extend_id',
                DB::raw('sum(inventory_transaction.total) as total'),
                DB::raw('sum(inventory_detail.qty_prestock) as qty_prestock'),
                DB::raw('sum(inventory_detail.qty_return) as qty_return'),
                DB::raw('sum(inventory_detail.qty_receipt) as qty_receipt'),
                DB::raw('sum(inventory_detail.qty_stocktake) as qty_stocktake'),
                DB::raw('sum(inventory_detail.qty_issues) as qty_issues'),
                'inventory_transaction.batch_no',
                'inventory_transaction.batch_expire_date'
            )
            ->join('inventory_transaction', function ($join) {
                $join->on('inventory_detail.product_id', '=', 'inventory_transaction.product_id')
                    ->on('inventory_detail.product_extend_id', '=', 'inventory_transaction.product_extend_id');
            })
            ->join('inventory_transaction_master', function ($join) {
                $join->on('inventory_transaction.transaction_masterid', '=', 'inventory_transaction_master.id');
            })
            ->wherebetween('dateCreated', [$date_from, $date_to])
            ->where([
                'inventory_transaction.product_id' => $product_id,
                'inventory_transaction.invalid' => 0,
                'inventory_detail.invalid' => 0,
            ]);

        if ($type != null) {
            $query->where('inventory_transaction_master.type', $type);
        }
        if ($sub_type != null) {
            $query->where('inventory_transaction_master.sub_type', $sub_type);
        }
        if ($batch_id) { //batch for product
            $query->where('inventory_transaction.batch_no', $batch_id);
        }

        $query = $query->groupBy(
            'inventory_detail.product_id',
            'inventory_detail.product_extend_id',
            'inventory_transaction_master.dateCreated'
        )
            ->orderBy('inventory_detail.product_extend_id')
            ->paginate($limit);

        $count = $query->count();
        $data_list = $query->items();
        $data = [
            'total' => ceil($count / $limit),
            'list_items' => $data_list,
        ];

        return $data;
    }

    public static function getInventoryTransactionDetail($req)
    {
        $query = inventory_transaction_master::where([
            ['inventory_transaction_master.id', $req['transaction_masterid']],
            ['inventory_transaction_master.shop_id', $req['shop_id']],
            ['inventory_transaction_master.invalid', 0],
            ['inventory_transaction.invalid', 0],
        ])
            ->leftjoin('inventory_transaction', 'inventory_transaction.transaction_masterid', '=', 'inventory_transaction_master.id')
            ->leftjoin('product', 'inventory_transaction.product_id', '=', 'product.product_id')
            ->select(
                'inventory_transaction_master.code',
                'inventory_transaction_master.status',
                'inventory_transaction_master.dateCreated',
                'inventory_transaction_master.bill_regdate',
                'inventory_transaction_master.paidTotal',
                'inventory_transaction_master.transaction_with_id',
                'inventory_transaction_master.transaction_with_name',
                'inventory_transaction_master.note',
                'product.product_master_id',
                'inventory_transaction.product_id',
                'inventory_transaction.product_code',
                'inventory_transaction.product_name',
                'inventory_transaction.batch_no',
                'inventory_transaction.sellvat',
                'inventory_transaction.sellprice',
                'inventory_transaction.batch_expire_date',
                'inventory_transaction.costprice',
                'inventory_transaction.unit_id',
                'inventory_transaction.unit_name',
                'inventory_transaction.discount',
                'inventory_transaction.costvat',
                'inventory_transaction.total',
                'inventory_transaction.last_input_price',
                'inventory_transaction.quantity',
                'inventory_transaction_master.total as total_master'
            )
            ->get();
        $sum_total_pre = $paidTotal = $debtTotal = $sum_vat = $sum_total = 0;
        $transaction_status = $transaction_bill_regdate = $transaction_code = $transaction_regdate = $transaction_width_id = $transaction_with_name = $note = '';
        $item_product = [];
        foreach ($query as $value) {
            $sum_total_pre += $value->costprice * $value->quantity;
            $sum_vat += ($value->costprice * $value->quantity * ($value->sellvat/ 100)) - ($value->costprice * $value->quantity * ($value->discount / 100));
            $sum_total = $value->total_master;
            $transaction_code = $value->code;
			$transaction_status = $value->status;
            $transaction_regdate = $value->dateCreated;
            $transaction_bill_regdate = $value->bill_regdate;
            $transaction_width_id = $value->transaction_with_id;
            $transaction_with_name = $value->transaction_with_name;
            $paidTotal = $value->paidTotal;
            $debtTotal = $value->total_master - $value->paidTotal;
            $note = $value->note;
            $item_product[] = [
                "product_master_id" => $value->product_master_id,
                "product_id" => $value->product_id,
                "product_code" => $value->product_code,
                "product_name" => $value->product_name,
                "batch_no" => $value->batch_no,
                "sellvat" => $value->sellvat,
                "last_input_price" => $value->last_input_price,
                "sellprice" => $value->sellprice,
                "batch_expire_date" => $value->batch_expire_date,
                "costprice" => $value->costprice,
                "unit_id" => $value->unit_id,
                "unit_name" => $value->unit_name,
                "discount" => $value->discount,
                "costvat" => $value->costvat,
                "total" => $value->total,
                "quantity" => $value->quantity,
            ];
        }

        $data = [
            'sum_total_pre' => $sum_total_pre,
            'sum_vat' => $sum_vat,
            'sum_total' => $sum_total,
            'code' => $transaction_code,
            'status' => $transaction_status,
            'transaction_create' => $transaction_regdate,
            'transaction_bill_regdate' => $transaction_bill_regdate,
            'paidTotal' => $paidTotal,
            'debtTotal' => $debtTotal,
            'transaction_width_id' => $transaction_width_id,
            'transaction_width_name' => $transaction_with_name,
            'note' => $note,
            'list_transaction' => $item_product
        ];
        return $data;
    }

    public static function getListInventoryDetail($data)
    {

        $query_inventory = DB::table('inventory_detail')
            ->select(
                'product.product_name',
                'inventory_detail.batch_no',
                'inventory_detail.batch_expire_date',
                'inventory_master.avgprice',
                'product.unit_name',
                DB::raw('inventory_detail.qty_prestock'),
                DB::raw('inventory_detail.qty_receipt'),
                DB::raw('inventory_detail.qty_return'),
                DB::raw('inventory_detail.qty_stocktake'),
                DB::raw('inventory_detail.qty_issues'),
                'inventory_detail.regdate'
            )
            ->join('inventory_master', function ($join) {
                $join->on('inventory_master.product_id', '=', 'inventory_detail.product_id')
                    ->on('inventory_master.product_extend_id', '=', 'inventory_detail.product_extend_id');
            })
            ->join('inventory_transaction', function ($join) {
                $join->on('inventory_detail.product_id', '=', 'inventory_transaction.product_id')
                    ->on('inventory_detail.product_extend_id', '=', 'inventory_transaction.product_extend_id')
                    ->on('inventory_transaction.invalid', '=', DB::raw('0'));
            })
            ->join('product', function ($join) {
                $join->on('product.product_id', '=', 'inventory_detail.product_id')
                ->on('product.invalid', '=', DB::raw('0'));
            })
            ->leftJoin('inventory_transaction_master', function ($join) {
                $join->on('inventory_transaction_master.id', '=', 'inventory_transaction.transaction_masterid');
            })
            ->where([
                'inventory_detail.invalid' => 0,
                'inventory_master.invalid' => 0,
            ]);
        if (is_array($data['shop_ids'])) {
            $query_inventory->whereIn('inventory_detail.shop_id', $data['shop_ids']);
        } else {
            $query_inventory->where('inventory_detail.shop_id', $data['shop_ids']);
        }

        if($data['status']) {
            $query_inventory->where('product.invalid', $data['status']);
        }
        if($data['product_category']) {
            $query_inventory->where('product.product_category_id', $data['product_category']);
        }
        if($data['product_type']) {
            $query_inventory->where('product.product_type', $data['product_type']);
        }
        if ($data['key_search']) {
            $query_inventory->whereRaw("(product.product_name like '%{$data['key_search']}%' or product.product_code like '%{$data['key_search']}%' or inventory_transaction_master.code like '%{$data['key_search']}%')");
        }

        if ($data['stock_quantity'] == 1) {
            $query_inventory->where('inventory_master.total_balance', '>', 0);
        }

        if($data['date_from']) {
            $query_inventory->whereBetween('inventory_transaction_master.dateCreated', [$data['date_from'], $data['date_to']]);
        }

        switch ($data['batch_expire_date']) {
            case '1':
                $query_inventory->where('inventory_detail.batch_expire_date', '>=', $data['expire_date']);
                break;
            case '2':
                $query_inventory->where('inventory_detail.batch_expire_date', '<', $data['expire_date']);
                break;
            case '3':
                $query_inventory->where('inventory_detail.batch_expire_date', '<', $data['now']);
                break;
        }

        $query = $query_inventory->groupBy(
            'inventory_detail.product_id',
            'inventory_detail.product_extend_id'
        )
         ->paginate($data['limit']);

        $count = $query->total();
        $data_list = $query->items();

        $data = [
            'total' => ceil($count / $data['limit']),
            'current_page' => $query->currentPage(),
            'item_per_page' => $data['limit'],
            'total_item' => $count,
            'list_items' => $data_list
        ];

        return $data;
    }


    /**
     * @param $data_transaction
     * @param $data_product
     * @param $code
     * @param bool $data_pending
     * @return mixed
     */
    public static function createInventoryTransaction($data_transaction, $data_product, $code, $data_pending = false) {
        DB::beginTransaction();
        try {
            $transaction_master = new inventory_transaction_master();
            $data_transaction['code'] = $code ?? self::genInventoryTransactionMasterCode(
                $data_transaction['shop_id'],
                $data_transaction['type']
            );

            $data_transaction_master = $data_transaction;
            $transaction_master->insert($data_transaction_master);
            $master_id = $data_transaction_master['id'];

            $data_product_handles = [];
            foreach ($data_product as $key => $product) {
                $product['transaction_masterid'] = $master_id;
                $product['regdate'] = $data_transaction['itm_regdate'];
                $product['regdate_local'] = $data_transaction['master_local_regdate'];
                $product['id'] = Util::getLocalId($data_transaction['shop_id']);
                $product['stocktake_quanity'] = $product['stocktake_quanity'] ?? 0;
                $product['version_code'] = 1;
                $product['account_id'] = $data_transaction['account_id'];
                $product['account_name'] = $data_transaction['account_name'];
                $product['shop_id'] = $data_transaction['shop_id'];
                $product['type'] = $data_transaction['type'];
                $product['sub_type'] = $data_transaction['sub_type'];
                $product['status'] = $data_transaction['status'];
                $product['last_input_price'] = isset($product['last_input_price']) ? $product['last_input_price'] : 0;
                if(isset($product['sellprice']) && $product['sellprice']) {
                    product_unit::updatePriceUnit($product['shop_id'], $product['product_id'], $product['unit_id'], $product['sellprice']);
                    product_master::updatePriceProductMaster($product['shop_id'], $product['product_id'], $product['unit_id'], $product['sellprice']);
                }
                if(!(isset($product['product_extend_id']) && $product['product_extend_id'])) {
                    $product['product_extend_id'] = product_extend::checkExistsProductExtend(
                        $product['product_id'],
                        $data_transaction['shop_id'],
                        $product['batch_no'],
                        $product['batch_expire_date']
                    );
                }
                $data_product_handles[] = $product;


                $data_inventory_master = inventory_master::createInventoryMaster(
                    $data_transaction['shop_id'],
                    $product['product_id'],
                    $product['product_extend_id'],
                    $product['quantity'] * $product['primary_unit_convert'],
                    $product['total'],
                    $data_transaction['facility_id'],
                    $data_transaction['type'],
                    $product['stocktake_quanity'],
                    $data_transaction['sub_type'],
                    $product['batch_no'],
                    $product['batch_expire_date']
                );

                if(isset($data_inventory_master['msg_error'])) {
                    DB::rollBack();
                    $data['msg_error'] = $data_inventory_master['msg_error'];
                    return $data;
                }

                inventory_detail::createOrUpdateInventoryInDay(
                    $data_transaction['shop_id'],
                    $product['product_id'],
                    $product['product_extend_id'],
                    $data_transaction['facility_id'],
                    $product['quantity'] * $product['primary_unit_convert'],
                    $data_transaction['type'],
                    $data_transaction['sub_type'],
                    $data_transaction['itm_regdate'],
                    $product['batch_no'],
                    $product['batch_expire_date']
                );
            }
            inventory_transaction::createTransaction($data_product_handles);
            DB::table('inventory_transaction_log')->insert($data_product_handles);

            if($data_pending && is_array($data_pending)) {
                $data_pending['source_type'] = 2; //phieu cap phat
                $data_pending['source_id'] = $master_id;
                $data_pending['type'] = 4;
                $data_pending['id'] = Util::getLocalId($data_pending['shop_id']);
                $data_pending['code'] = $code ?? self::genInventoryTransactionMasterCode($data_pending['shop_id'], 4);
                inventory_transaction_master::insert($data_pending);
            }

            DB::commit();
            $data['msg_success'] = __('messages.success');
        }
        catch (\Exception $e) {
            DB::rollBack();
            $data['msg_error'] = $e->getMessage();
        }
        return $data;
    }


    public static function createInventoryTransactionExcel($data_transaction, $data_product, $code) {
        DB::beginTransaction();
        $data = [];
        try {
            $transaction_master = new inventory_transaction_master();
            $data_transaction['code'] = $code ?? self::genInventoryTransactionMasterCode($data_transaction['shop_id'], $data_transaction['type']);

            $data_transaction_master = $data_transaction;
            $transaction_master->insert($data_transaction_master);
            $master_id = $data_transaction_master['id'];

            $data_product_handles = [];
            foreach ($data_product as $key => $product_item) {
                /*check exists product*/
                $check_product = product::checkExistsProduct($product_item['product_name'], $data_transaction['shop_id']);
                if($check_product) {
                    $product['product_id'] = $check_product;
                }
                else {
                    $products_import[0] = $product_item;
                    $product_import = product::createProductExcel($products_import, $data_transaction['shop_id']);
                    $product['product_id'] = $product_import['product_id'];
                }

                $product['transaction_masterid'] = $master_id;
                $product['regdate'] = $data_transaction['itm_regdate'];
                $product['regdate_local'] = $data_transaction['master_local_regdate'];
                $product['id'] = Util::getLocalId($data_transaction['shop_id']);
                $product['stocktake_quanity'] = $product_item['stocktake_quanity'] ?? 0;
                $product['version_code'] = 1;
                $product['account_id'] = $data_transaction['account_id'];
                $product['account_name'] = $data_transaction['account_name'];
                $product['shop_id'] = $data_transaction['shop_id'];
                $product['type'] = $data_transaction['type'];
                $product['sub_type'] = $data_transaction['sub_type'];
                $product['status'] = $data_transaction['status'];
                $product['batch_no'] = $product_item['batch_no'];
                $product['batch_expire_date'] = Carbon::createFromFormat('d-m-Y', $product_item['batch_expire_date']);
                $product['quantity'] = $product_item['unit_quantity_import'];
                $product['primary_unit_convert'] = $product_item['unit_convert'];
                $product['total'] = $product_item['total'];
                $product['product_name'] = $product_item['product_name'];
                $product['unit_name'] =  strtoupper(trim($product_item['unit_import']));
                $product['unit_id'] = unit_master::checkExitAndCreateUnitMaster($data_transaction['shop_id'], $product['unit_name']);
                $product['sellprice'] = isset($product_item['sellprice']) ? $product_item['sellprice'] : 0;
                $product['sellvat'] = isset($product_item['sellvat']) ? $product_item['sellvat'] : 0;
                $product['costprice'] = isset($product_item['costprice']) ? $product_item['costprice'] : 0;
                $product['costvat'] = isset($product_item['costvat']) ? $product_item['costvat'] : 0;
                $product['discount'] = isset($product_item['discount']) ? $product_item['discount'] : 0;

                if(!(isset($product_item['product_extend_id']) && $product_item['product_extend_id'])) {
                    $product['product_extend_id'] = product_extend::checkExistsProductExtend(
                        $product['product_id'],
                        $data_transaction['shop_id'],
                        $product['batch_no'],
                        $product['batch_expire_date']
                    );
                }

                $data_inventory_master = inventory_master::createInventoryMaster(
                    $data_transaction['shop_id'],
                    $product['product_id'],
                    $product['product_extend_id'],
                    $product['quantity'] * $product['primary_unit_convert'],
                    $product['total'],
                    $data_transaction['facility_id'],
                    $data_transaction['type'],
                    $product['stocktake_quanity'],
                    $data_transaction['sub_type'],
                    $product['batch_no'],
                    $product['batch_expire_date']
                );

                if(isset($data_inventory_master['msg_error'])) {
                    DB::rollBack();
                    $data['msg_error'] = $data_inventory_master['msg_error'];
                    return $data;
                }

                inventory_detail::createOrUpdateInventoryInDay(
                    $data_transaction['shop_id'],
                    $product['product_id'],
                    $product['product_extend_id'],
                    $data_transaction['facility_id'],
                    $product['quantity'] * $product['primary_unit_convert'],
                    $data_transaction['type'],
                    $data_transaction['sub_type'],
                    $data_transaction['itm_regdate'],
                    $product['batch_no'],
                    $product['batch_expire_date']
                );


                $data_product_handles[] = $product;
            }
            inventory_transaction::createTransaction($data_product_handles);
            DB::table('inventory_transaction_log')->insert($data_product_handles);
            DB::commit();
            $data['msg_success'] = __('messages.success');
        }
        catch (\Exception $e) {
            DB::rollBack();
            $data['msg_error'] = $e->getMessage();
        }

        return $data;
    }

    /**
     * @param $id
     * @param $data_transaction
     * @param $data_product
     * @param $shop_id
     * @return mixed
     */
    public static function editTransaction(
        $id,
        $data_transaction,
        $data_product,
        $shop_id,
        $update
    ) {
        DB::beginTransaction();
        try {
            $transaction_master = inventory_transaction_master::where([
                'id' => $id,
            ])->where('status', '<>', 5)->first();  //phieu edit phai la phieu xong hoặc tạm status(0, 1)
            if(!$transaction_master) {
                $data['msg_error'] = __('messages.canNotFoundResource');
                return $data;
            }
            $check_permission = self::checkPermissionActionBill($transaction_master->shop_id, $shop_id);
            if(!$check_permission) {
                $data['error_msg'] = __('messages.error_permission_edit');
                return $data;
            }
            $facility_id = $transaction_master->facility_id;
            $transaction_master->last_update = Carbon::now()->format('Y-m-d H:i:s');
            unset($data_transaction['shop_id']);
            $transaction_master->update($data_transaction);

            $inv_transaction = inventory_transaction::editTransaction(
                $transaction_master->shop_id,
                $id,
                $facility_id,
                $update
            );
            if(isset($inv_transaction['msg_error'])) {
                DB::rollBack();
                return $inv_transaction;
            }


            $product_handles = [];
            foreach ($data_product as $key => $product) {
                $product['transaction_masterid'] = $id;
                $product['update'] = Carbon::now();
                $product['update_local'] = $update;
                $product['regdate_local'] = $transaction_master->master_local_regdate;
                $product['regdate'] = $transaction_master->itm_regdate;
                $product['stocktake_quanity'] = $product['stocktake_quanity'] ?? 0;
                $product['version_code'] = 1;
                $product['invalid'] = 0;
                $product['type'] = $transaction_master->type;
                $product['sub_type'] = $transaction_master->sub_type;
                $product['account_id'] = $transaction_master->account_id;
                $product['account_name'] = $transaction_master->account_name;
                $product['id'] = Util::getLocalId($transaction_master->shop_id);
                $product['shop_id'] = $transaction_master->shop_id;

                $product['last_input_price'] = isset($product['last_input_price']) ? $product['last_input_price'] : 0;
                if(isset($product['sellprice']) && $product['sellprice']) {
                    product_unit::updatePriceUnit($product['shop_id'], $product['product_id'], $product['unit_id'], $product['sellprice']);
                    product_master::updatePriceProductMaster($product['shop_id'], $product['product_id'], $product['unit_id'], $product['sellprice']);
                }

                if(!(isset($product['product_extend_id']) && $product['product_extend_id'])) {
                    $product['product_extend_id'] = product_extend::checkExistsProductExtend(
                        $product['product_id'],
                        $transaction_master->shop_id,
                        $product['batch_no'],
                        $product['batch_expire_date']
                    );
                }

                $product_handles[] = $product;

                $inventory_master = inventory_master::createInventoryMaster(
                    $transaction_master->shop_id,
                    $product['product_id'],
                    $product['product_extend_id'],
                    $product['quantity'] * $product['primary_unit_convert'],
                    $product['total'],
                    $facility_id,
                    $data_transaction['type'],
                    $product['stocktake_quanity'],
                    $transaction_master->sub_type,
                    $product['batch_no'],
                    $product['batch_expire_date']
                );

                if(isset($inventory_master['msg_error'])) {
                    DB::rollBack();
                    return $inventory_master;
                }

                inventory_detail::createOrUpdateInventoryInDay(
                    $transaction_master->shop_id,
                    $product['product_id'],
                    $product['product_extend_id'],
                    $data_transaction['facility_id'],
                    $product['quantity'] * $product['primary_unit_convert'],
                    $data_transaction['type'],
                    $data_transaction['sub_type'],
                    $product['regdate'],
                    $product['batch_no'],
                    $product['batch_expire_date']
                );
            }
            inventory_transaction::createTransaction($product_handles);
            DB::table('inventory_transaction_log')->insert($product_handles);

            DB::commit();
        }
        catch (\Exception $e){
            DB::rollBack();
            $data['msg_error'] = $e->getMessage();
            return $data;
        }
    }


    public static function editTransactionProvided($id, $data_master, $data_provided, $data_product, $shop_id) {
        DB::beginTransaction();
        try {
            $transaction_master = inventory_transaction_master::where([
                'id' => $id,
                'status' => 1,
            ])->first();
            if(!$transaction_master) {
                $data['msg_error'] = __('messages.canNotFoundResource');
                return $data;
            }
            $check_permission = self::checkPermissionActionBill($transaction_master->shop_id, $shop_id);
            if(!$check_permission) {
                $data['error_msg'] = __('messages.error_permission_edit');
                return $data;
            }
            inventory_transaction_master::where('id', $id)->update($data_master);

            $data_inv_transaction = inventory_transaction::editTransaction(
                $transaction_master->shop_id,
                $transaction_master->source_id,
                $transaction_master->facility_id,
                $transaction_master->last_update
            );

            if(isset($data_inv_transaction['msg_error'])) {
                DB::rollBack();
                $data['msg_error'] = $data_inv_transaction['msg_error'];
                return $data;
            }

            $data_inv_provided = inventory_transaction_master::where([
                'id' => $transaction_master->source_id
            ])->update($data_provided);


            $product_handles = [];
            foreach ($data_product as $key => $product) {
                $product['transaction_masterid'] = $id;
                $product['update'] = Carbon::now();
                $product['update_local'] = $data_provided['last_update'];
                $product['regdate_local'] = $transaction_master->master_local_regdate;
                $product['regdate'] = $transaction_master->itm_regdate;
                $product['stocktake_quanity'] = $product['stocktake_quanity'] ?? 0;
                $product['version_code'] = 1;
                $product['invalid'] = 0;
                $product['type'] = $data_provided['type'];
                $product['sub_type'] = $data_provided['sub_type'];
                $product['account_id'] = $transaction_master->account_id;
                $product['account_name'] = $transaction_master->account_name;
                $product['id'] = Util::getLocalId($data_provided['shop_id']);
                $product['shop_id'] = $data_provided['shop_id'];

                if(!(isset($product['product_extend_id']) && $product['product_extend_id'])) {
                    $product['product_extend_id'] = product_extend::checkExistsProductExtend(
                        $product['product_id'],
                        $data_provided['shop_id'],
                        $product['batch_no'],
                        $product['batch_expire_date']
                    );
                }

                $product_handles[] = $product;

                $inventory_master = inventory_master::createInventoryMaster(
                    $transaction_master->shop_id,
                    $product['product_id'],
                    $product['product_extend_id'],
                    $product['quantity'] * $product['primary_unit_convert'],
                    $product['total'],
                    $data_provided['facility_id'],
                    $data_provided['type'],
                    $product['stocktake_quanity'],
                    $data_provided['sub_type'],
                    $product['batch_no'],
                    $product['batch_expire_date']
                );

                if(isset($inventory_master['msg_error'])) {
                    DB::rollBack();
                    return $inventory_master;
                }

                inventory_detail::createOrUpdateInventoryInDay(
                    $data_provided['shop_id'],
                    $product['product_id'],
                    $product['product_extend_id'],
                    $data_provided['facility_id'],
                    $product['quantity'] * $product['primary_unit_convert'],
                    $data_provided['type'],
                    $data_provided['sub_type'],
                    $product['regdate'],
                    $product['batch_no'],
                    $product['batch_expire_date']
                );
            }
            inventory_transaction::createTransaction($product_handles);
            DB::table('inventory_transaction_log')->insert($product_handles);
            DB::commit();
        }
        catch (\Exception $e) {
            $data['msg_error'] = $e->getMessage();
            DB::rollback();
            return $data;
        }
    }

    /**
     * @param $shop_id
     * @param $transaction_id
     * @param $request
     * @return mixed
     */
    public static function cancelTransaction($shop_id, $transaction_id, $request) {
        DB::beginTransaction();
        try {
            $now = Carbon::now()->format('Y-m-d H:i:s');
            $regdate_local = $request->input('regdate') ?? Carbon::now()->format('Y-m-d H:i:s');
            $transaction_master = inventory_transaction_master::where([
                'id' => $transaction_id
            ])->where('status', '<>', '5')->first();
            if(!$transaction_master) {
                $data['msg_error'] = __('messages.canNotFoundResource');
                return $data;
            }
            $check_permission_shop = self::checkPermissionActionBill($transaction_master->shop_id, $shop_id);
            if(!$check_permission_shop) {
                $data['msg_error'] = __('messages.error_permission_cancel');
                return $data;
            }
            $transaction_master->last_update = $now;
            $transaction_master->status = 5;
            $transaction_master->save();

            if($transaction_master->type == 1) {
                $data_transaction['type'] = 2;
            }
            else if($transaction_master->type == 2){
                $data_transaction['type'] = 1;
            }
            else {
                $data_transaction['type'] = $transaction_master->type;
            }

            $data_transaction['sub_type'] = $transaction_master->sub_type;
            /*if($transaction_master->sub_type ==  5 || $transaction_master->sub_type == 7) {
                $data_transaction['type'] = 5;
            }
            else {
                $data_transaction['sub_type'] = $transaction_master->sub_type;
            }

            if($transaction_master->type == 1 && $transaction_master->sub_type == 1) {
				$data_transaction['sub_type'] = 8; //export to supplier
			}*/

            $code = $request->input('code');
            $data_transaction['code'] = $code ?? self::genInventoryTransactionMasterCode(
                $transaction_master->shop_id,
                $data_transaction['type']
            );
            $data_transaction['id'] = Util::getLocalId($transaction_master->shop_id);
            $data_transaction['bill_regdate'] = $regdate_local;
            $data_transaction['version_code'] = $transaction_master->version_code;
            $data_transaction['master_local_regdate'] = $regdate_local;
            $data_transaction["itm_regdate"] = $regdate_local;
            $data_transaction["dateCreated"] = $regdate_local;
            $data_transaction['paidTotal'] = $transaction_master->paidTotal;
            $data_transaction['transaction_with_id'] = $transaction_master->transaction_with_id;
            $data_transaction['transaction_with_name'] = $transaction_master->transaction_with_name;
            $data_transaction['total'] = $transaction_master->total;
            $data_transaction['payment_status'] = $transaction_master->payment_status;
            $data_transaction['facility_id'] = $transaction_master->facility_id;
            $data_transaction['account_id'] = $request->input('account_id');
            $data_transaction['account_name'] = $request->input('account_name');
            $data_transaction['shop_id'] = $transaction_master->shop_id;
            $data_transaction['invalid'] = 0;
            $data_transaction['status'] = 0;

            inventory_transaction_master::insert($data_transaction);
            $master_id = DB::getPdo()->lastInsertId();
            $facility_id = $transaction_master->facility_id;

            $data_inv_transaction = inventory_transaction::cancelTransaction(
                $transaction_master->shop_id,
                $transaction_id,
                $master_id,
                $facility_id,
                $request->input('account_id'),
                $request->input('account_name'),
                $data_transaction['type'],
                $data_transaction['sub_type'],
                $regdate_local
            );

            if(isset($data_inv_transaction['msg_error'])) {
                DB::rollBack();
                $data['msg_error'] = $data_inv_transaction['msg_error'];
                return $data;
            }
            $data['msg_success'] = __('messages.success');
            DB::commit();
        }
        catch (\Exception $e) {
            $data['msg_error'] = $e->getMessage();
            DB::rollBack();
        }

        return $data;
    }

    public static function verifyBillProvidedReceive(
        $shop_id,
        $transaction_id,
        $account_id,
        $account_name,
        $verify_flg,
        $regdate,
        $note
    ) {
        DB::beginTransaction();
        try{
            $inv_master_provided = inventory_transaction_master::where([
                'id' => $transaction_id,
                'source_type' => 2,
                'status' => 1,
            ])->first();

            if($inv_master_provided) {
                $check_permission = self::checkPermissionActionBill($inv_master_provided->shop_id_receive, $shop_id);
                if(!$check_permission) {
                    $data['msg_error'] = __('messages.error_permission_edit');
                }
                $inv_master = inventory_transaction_master::where([
                    'id' => $inv_master_provided->source_id
                ])->first();
                if($inv_master) {
                    $now = Carbon::now();
                    if($verify_flg) { //accept
                        $shop_id = $inv_master_provided->shop_id_receive;
                        $facility_id = $inv_master_provided->facility_id_receive;
                        $type = 1;
                        $sub_type = 4;
                        $status = $status_transction = 0;
                        $inv_master_provided->status = 0;
                        $inv_master->status = 0;
                    }
                    else { //cancel
                        $shop_id = $inv_master_provided->shop_id_provided;
                        $facility_id = $inv_master_provided->facility_id;
                        $type = 1;
                        $sub_type = 4;
                        $status = 0;
                        $status_transction = 5;
                        $inv_master_provided->note = $note;
                        $inv_master_provided->status = 5;
                        $inv_master->status = 5;
                    }

                    $inv_master_receive = [
                        'id' => Util::getLocalId($shop_id),
                        'shop_id' => $shop_id,
                        'bill_regdate' => $now,
                        'version_code' => 1,
                        'code' => self::genInventoryTransactionMasterCode($shop_id, $type),
                        'type' => $type,
                        'sub_type' => $sub_type,
                        'account_id' => $account_id,
                        'account_name' => $account_name,
                        'total' => $inv_master->total,
                        'paidTotal' => $inv_master->paidTotal,
                        'status' => $status,
                        'dateCreated' => $now,
                        'itm_regdate' => $now,
                        'master_local_regdate' => $regdate,
                        'payment_status' => 1,
                        'facility_id' => $facility_id
                    ];

                    $data_transaction = [];

                    inventory_transaction_master::insert($inv_master_receive);
                    $master_id = $inv_master_receive['id'];
                    $inv_master_provided->source_id2 = $inv_master_receive['id'];
                    $inv_master_provided->save();
                    $inv_transactions = inventory_transaction::where([
                        'transaction_masterid' => $inv_master->id,
                        'invalid' => 0
                    ])->get();

                    foreach ($inv_transactions as $transaction) {
                        $product['id'] = Util::getLocalId($shop_id);
                        $product['transaction_masterid'] = $master_id;
                        $product['regdate_local'] = $regdate;
                        $product['regdate'] = $now;
                        $product['stocktake_quanity'] = $product['stocktake_quanity'] ?? 0;
                        $product['version_code'] = 1;
                        $product['invalid'] = 0;
                        $product['type'] = $type;
                        $product['sub_type'] = $sub_type;
                        $product['account_id'] = $account_id;
                        $product['account_name'] = $account_name;
                        $product['shop_id'] = $shop_id;
                        $product['product_id'] = $transaction->product_id;
                        $product['product_name'] = $transaction->product_name;
                        $product['product_code'] = $transaction->product_code;
                        $product['batch_no'] = $transaction->batch_no;
                        $product['batch_expire_date'] = $transaction->batch_expire_date;
                        $product['quantity'] = $transaction->quantity;
                        $product['unit_id'] = $transaction->unit_id;
                        $product['unit_name'] = $transaction->unit_name;
                        $product['primary_unit_convert'] = $transaction->primary_unit_convert;
                        $product['sellvat'] = $transaction->sellvat;
                        $product['sellprice'] = $transaction->sellprice;
                        $product['costprice'] = $transaction->costprice;
                        $product['costvat'] = $transaction->costvat;
                        $product['discount'] = $transaction->discount;
                        $product['total'] = $transaction->total;
                        $product['stocktake_quanity'] = 0;
                        $product['facility_id'] = $facility_id;
                        $product['product_extend_id'] = product_extend::checkExistsProductExtend(
                            $product['product_id'],
                            $product['shop_id'],
                            $product['batch_no'],
                            $product['batch_expire_date']
                        );

                        inventory_master::createInventoryMaster(
                            $product['shop_id'],
                            $product['product_id'],
                            $product['product_extend_id'],
                            $product['quantity'] * $product['primary_unit_convert'],
                            $product['total'],
                            $product['facility_id'],
                            $product['type'],
                            $product['stocktake_quanity'],
                            $sub_type,
                            $transaction->batch_no,
                            $transaction->batch_expire_date
                        );

                        inventory_detail::createOrUpdateInventoryInDay(
                            $product['shop_id'],
                            $product['product_id'],
                            $product['product_extend_id'],
                            $product['facility_id'],
                            $product['quantity'] * $product['primary_unit_convert'],
                            $product['type'],
                            $product['sub_type'],
                            $product['regdate'],
                            $transaction->batch_no,
                            $transaction->batch_expire_date
                        );
                        $transaction->status = $status_transction;
                        $transaction->save();

                        unset($product['facility_id']);
                        $data_transaction[] = $product;

                    }
                    inventory_transaction::createTransaction($data_transaction);
                }
                else {
                    DB::rollBack();
                    $data['msg_error'] = __('message.not_found_provided');
                }
            }
            else {
                DB::rollBack();
                $data['msg_error'] = __('messages.canNotFoundResource');
                return $data;
            }

            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollBack();
            $data['msg_error'] = $e->getMessage();
            return $data;
        }

    }

    public static function genInventoryTransactionMasterCode($shop_id, $type) {
        $arr_prefix = [
            1 => 'PNK',
            2 => 'PXK',
            3 => 'PKK',
            4 => 'PCP'
        ];

        $arr_limit = array(
            '10' => '000000',
            '100' => '00000',
            '1000' => '0000',
            '10000' => '000',
            '100000' => '00',
            '1000000' => '0',
            '10000000' => '',
        );

        $code = $arr_prefix[$type];

        $query_count = inventory_transaction_master::select('id')->where('shop_id', $shop_id)
            ->count();
        $total_record = $query_count + 1;

        foreach ($arr_limit as $key => $value) {
            if ($total_record < $key) {
                return $code . $value . $total_record;
            }
        }
    }

    public function getListInventoryTransactionMaster(
        $date_from,
        $date_to,
        $status,
        $type,
        $sub_type,
        $shop_ids,
        $search_key,
        $limit,
        $search_product_id
    ) {
//        DB::enableQueryLog();
        $query = inventory_transaction_master::where('inventory_transaction_master.sub_type',$sub_type);
        if (is_array($shop_ids)) {
            $query = $query->whereIn('inventory_transaction_master.shop_id', $shop_ids);
        } else {
            $query = $query->where('inventory_transaction_master.shop_id', $shop_ids);
        }
        $query = $query->wherebetween('inventory_transaction_master.bill_regdate', [$date_from, $date_to]);
        if ($status != null) {
            $query = $query->where('inventory_transaction_master.status', $status);
        }
        if($search_key != null){
            $query = $query->where('inventory_transaction_master.code', 'like' , "%$search_key%");
        }
        if($search_product_id != null){
            $query->join('inventory_transaction',function ($join) {
                    $join->on('inventory_transaction.transaction_masterid' , '=' , 'inventory_transaction_master.id');
                })
                ->where('inventory_transaction.product_id', $search_product_id);
        }
        if($type == 1){
            $query->whereRaw("inventory_transaction_master.shop_id_provided = inventory_transaction_master.shop_id");

        }
        else if($type == 2){
            $query->whereRaw("inventory_transaction_master.shop_id_receive = inventory_transaction_master.shop_id");
        }
        $query = $query->select('inventory_transaction_master.code','inventory_transaction_master.bill_regdate','inventory_transaction_master.shop_id_provided',
            'inventory_transaction_master.shop_id_receive','inventory_transaction_master.total','inventory_transaction_master.status',
            'inventory_transaction_master.note')->distinct()->paginate();

//        print_r(DB::getQueryLog());
        $count = $query->total();
        $data_list = $query->items();
        $data = [
            'total' => ceil($count / $limit),
            'list_items' => $data_list
        ];

        return $data;
    }

    public static function checkLocalIdTransaction($local_id) {
        $check = inventory_transaction_master::where('id', $local_id)->count();
        return $check;
    }

    protected static function getMaxlocalId() {
        $local_id = inventory_transaction_master::max('id');
        return $local_id + 1;
    }

    public static function checkPermissionActionBill($shop_id, $shop_id_call) {
        $account = new account();
        $shop_ids = $account->getListShopChild($shop_id_call);
        if(is_array($shop_ids) && in_array($shop_id, $shop_ids)) {
            return true;
        }
        else if($shop_ids == $shop_id) {
            return true;
        }
        else {
            return false;
        }
    }

    public static function getByOrderIdAndTypeAndShopId($oder_id, $shop_id, $type) {
        $transaction = inventory_transaction_master::where([
            'source_id' => $oder_id,
            'type' => $type,
            'shop_id' => $shop_id
        ])->whereRaw('status != 5')->get();

        return $transaction;
    }

    public static function deleleTransactionOrder($transaction_id, $transaction, $ignore_transaction) {

        DB::beginTransaction();
        try {
            inventory_transaction_master::where(['id' => $transaction_id, 'invalid' => 0])->update(['status' => 5]);
            inventory_transaction::where(['transaction_masterid' => $transaction_id, 'invalid' => 0])->update(['status' => 5]);
            DB::commit();
            return $data['msg_success'] = __('messages.success');
        }
        catch (\Exception $e) {
            DB::rollBack();
            $data['msg_error'] = $e->getMessage();
            return $data;
        }
    }


    public static function createBillTransationMasterGeneral(
        $params,
        $products,
        $type,
        $sub_type,
        $quantity = 1,
        $order_food_id
    ) {
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $column_transaction_master = Schema::getColumnListing('inventory_transaction_master');
        $transaction_params = [];
        foreach ($column_transaction_master as $colum) {
            $transaction_params[$colum] = isset($params[$colum]) ?? '';
        }
        //$facility_id = DB::table('facility_master')->where(['shop_id' => $params['shop_id'], 'invalid' => 0])->first();
        $transaction_params['facility_id'] = 1;//$facility_id->id;
        $transaction_params['id'] = Util::getLocalId($params['shop_id']);
        $transaction_params['invalid'] = 0;
        $transaction_params['source_id'] = $params['order_id'];
        $transaction_params['source_type'] = 1; //xuất định lưọng bán hàng
        $transaction_params['itm_regdate'] = $now;
        $transaction_params['master_local_regdate'] = $now;
        $transaction_params['dateCreated'] = $params['regdate_local'];
        $transaction_params['orderdate'] = $params['regdate_local'];
        $transaction_params['type'] = $type;
        $transaction_params['sub_type'] = $sub_type;
        $transaction_params['shop_id'] = $params['shop_id'];
        $transaction_params['code'] = self::genInventoryTransactionMasterCode($params['shop_id'], 2);

        /*transaction*/
        $product_data = [];
        $total = 0;
        foreach ($products as $key =>  $product) {
            $avgprice_inventory = inventory_master::getAvgPriceByProductId(
                $product['product_id'],
                $transaction_params['shop_id'],
                $product['product_extend_id']
            );
            $price = $avgprice_inventory ? ($avgprice_inventory * $product['quantity'] * $quantity) : 0;
            $product_data[] = [
                'id' => Util::getLocalId($params['shop_id']),
                'regdate' => $now,
                'regdate_local' => $params['regdate_local'],
                'update_local' => $params['regdate_local'],
                'account_id' => $params['order_account_id'],
                'account_name' => $params['order_account_name'],
                'status' => 0,
                'invalid' => 0,
                'shop_id' => $params['shop_id'],
                'transaction_masterid' => $transaction_params['id'],
                'total' => $price,
                'version_code' => 1,
                'quantity' => $product['quantity'] * $quantity,
                'product_extend_id' => $product['product_extend_id'],
                'product_id' => $product['product_id'],
                'product_name' => $product['product_name'],
                'batch_no' => $product['batch_no'],
                'batch_expire_date' => $product['batch_expire_date'],
                'unit_id' => $product['unit_id'],
                'unit_name' => $product['unit_name'],
                'primary_unit_convert' => 1,
                'type' => $type,
                'sub_type' => $sub_type,
            ];

            /*inventory_master*/
            $inv_master = inventory_master::createInventoryMaster(
                $transaction_params['shop_id'],
                $product['product_id'],
                $product['product_extend_id'],
                $quantity * $product['quantity'],
                $product['price'],
                $transaction_params['facility_id'],
                $type,
                $stocktake_quanity = 0,
                $sub_type,
                $product['batch_no'],
                $product['batch_expire_date']
            );


            /*inventory_detail*/
            $inv_detail = inventory_detail::createOrUpdateInventoryInDay(
                $transaction_params['shop_id'],
                $product['product_id'],
                $product['product_extend_id'],
                $transaction_params['facility_id'],
                $quantity * $product['quantity'],
                $type,
                $sub_type,
                $params['regdate_local'],
                $product['batch_no'],
                $product['batch_expire_date']
            );

            $total += $price;
        }
        $transaction_params['total'] = $total;
        inventory_transaction_master::insert($transaction_params);
        inventory_transaction::insert($product_data);
        DB::table('inventory_transaction_log')->insert($product_data);

        /*update order food inprice*/
        order_product::updateInpriceInProductOrder(
            $order_food_id,
            $transaction_params['shop_id'],
            $total
        );
    }
}
