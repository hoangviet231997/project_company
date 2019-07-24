<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Helper\Constant;
use App\Helpers\Util;
use Illuminate\Support\Facades\Schema;

class product extends Model
{
    protected $table = 'product';
    protected $primaryKey = 'product_id';
    protected $fillable = [
        'shop_id',
        'owner_product_id',
        'owner_shop_id',
        'product_master_id',
        'product_master_code',
        'product_name',
        'product_code',
        'product_barcode',
        'info1',
        'info2',
        'info3',
        'info4',
        'info5',
        'info6',
        'short_name',
        'available',
        'receiptflg',
        'product_category_id',
        'product_tax',
        'batch_name',
        'batch_expire_date',
        'unit_id',
        'unit_name',
        'unit_exchange',
        'service_unit_value',
        'service_promotion',
        'promotion_unit',
        'alert_flg',
        'alert_minval',
        'product_price',
        'in_price',
        'bill_material',
        'eng_name',
        'top_flg',
        'direct_sell_flg',
        'point_get_flg',
        'online_sell_flg',
        'reseller_flg',
        'combo',
        'last_update',
        'invalid',
        'nameSortproduct',
        'orderIndexproduct',
        'group_price_id',
        'product_type',
        'product_material',
        'combo',
        'product_unit_type',
        'place_tag',
        'supplier_id',
        'supplier_name'
    ];
    public $timestamps = false;

//    public function getList($filter){
//        $query = $this->where('invalid',0)->where('available',1);
//
//        if( isset($filter["product_name"]) && $filter["product_name"] != "") {
//            //$query = $query->where('product_name','like','%'.$filter["product_name"].'%');
//            $query->where(function ($q) use ($filter) {
//                $q->where('product_name','like','%'.$filter["product_name"].'%')
//                ->orWhere('product_code', 'like', '%'.$filter["product_name"].'%')
//                ->orWhere('short_name', 'like', '%'.$filter["product_name"].'%')
//                ->orWhere('product_master_code', 'like', '%'.$filter["product_name"].'%');
//            });
//        }
//        return $query->get();
//    }

    public function findAll($filter){
        $query = $this->select(
            'product_master_id',
            'product_code',
            'product_name',
            'product_price',
            'product_tax',
            'available')
            ->where('invalid',0);

        if( isset($filter["product_name"]) && $filter["product_name"] != "") {
            $query->where(function ($q) use ($filter) {
                $q->where('product_name','like','%'.$filter["product_name"].'%')
                ->orWhere('product_code', 'like', '%'.$filter["product_name"].'%')
                ->orWhere('short_name', 'like', '%'.$filter["product_name"].'%')
                ->orWhere('product_master_code', 'like', '%'.$filter["product_name"].'%');
            });
        }
        if( isset($filter["available"]) && $filter["available"] != "") {
            $query = $query->where('available',$filter["available"]);
        }
        if( isset($filter["product_category_id"])) {
            $query = $query->where('product_category_id',$filter["product_category_id"]);
        }
        return $query->get();
    }

    public function getListByProductMasterId($id){
        $query = $this->select(
            'product_id',
            'product_code',
            'product_name',
            'product_price',
            'product_tax',
            'available',
            'alert_flg',
            'invalid')
        ->where('product_master_id',$id)
        ->where('invalid',0);
        return $query->get();
    }

    public function findById($id) {
        return $this->where('product_id',$id)
        ->where('invalid',0)
        ->first();
    }

    public static function getListProduct($shop_id, $page, $product_name, $product_category_id, $available, $product_type = null) {
		$query = product::select(
			DB::raw('product.*'),
			DB::raw('product_master.product_thumbnail1'),
			DB::raw('product_master.product_thumbnail2'),
			DB::raw('product_master.product_thumbnail3'),
			DB::raw('product_master.product_thumbnail4')
		);

		$query->leftJoin('product_master', 'product.product_master_id', 'product_master.product_master_id');
		$query->where(['product.shop_id' => $shop_id, 'product.invalid' => 0]);

		if(!is_null($product_name)) {
			$query->where('product.product_name', 'like', "%$product_name%");
		}

		if(!is_null($product_category_id)) {
			$query->where('product.product_category_id', $product_category_id);
		}

		if(!is_null($available)) {
			$query->where('product.available', $available);
		}

		if(!is_null($product_type)) {
			$query->where('product.product_type', $product_type);
        }
        
        $total_item = $query->count();

    	if($page) {
			$limit_pagination = Constant::LIMIT_PAGINATION;

			$query = $query->paginate($limit_pagination);
			$query_product = $query->items();

			return [
				'item_per_page' => $limit_pagination,
				'current_page' => $query->currentPage(),
                'total_page' => ceil($query->total() / $limit_pagination),
                'total_item' => $total_item,
                'products' => $query_product,
			];
		}
		else {
			return $query->get();
		}
    }

    public function getProductDetail($shop_id, $product_id){
        /*product detail*/
        $product_detail = product_master::where([
            'product_master.shop_id' => $shop_id,
            'product_master.product_master_id' => $product_id
        ])
            ->distinct('product_id')
            ->get();
        $product_detail[0]['unit_list'] = product_unit::getListProductUnitByProductMaster($product_id, $shop_id);
        $product_detail[0]['product_list'] = product::getProductDetailByProductMasterId($product_id)->makeHidden('invalid');

        /*list product extend*/
        $product_by_batch = DB::table('inventory_master')
            ->Join('product_extend', function($join){
                $join->on('product_extend.id', '=', 'inventory_master.product_extend_id')
                    ->on('product_extend.product_id', '=', 'inventory_master.product_id');
            })
            ->where([
                'inventory_master.product_id' => $product_id,
                'inventory_master.shop_id' => $shop_id,
                'product_extend.invalid' => 0,
            ])
            ->select(
                'product_extend.batch_no',
                'product_extend.extend_barcode',
                'product_extend.batch_expire_date',
                'inventory_master.total_balance'
            )
            ->get();

        /*total balance*/
        $total_batch = DB::table('inventory_master')
            ->where(['shop_id' => $shop_id, 'product_id' => $product_id])
            ->sum('inventory_master.total_balance');

        $data = [
            'product_detail' => $product_detail,
            'list_batch'   => $product_by_batch,
            'total_batch'  => $total_batch
        ];

        return $data;
    }

    public static function getListInventory($request){
        $limit = $request->input('limit') ?? Constant::LIMIT_PAGINATION;
        $key_search = $request->input('key_search');
        $query = new product();
        $account = new account();
        $shop_ids = $request->input('shop_ids');
        $shop_id = $request->input('shop_id');
        if(!$shop_ids) {
            $shop_ids =$account->getListShopChild($shop_id);
        }
        if (is_array($shop_ids)) {
            $query = $query->whereIn('product.shop_id', $shop_ids);
        } else {
            $query = $query->where('product.shop_id', $shop_ids);
        }
        if ($key_search) {
            $query = $query->whereRaw("(product.product_code like '%{$key_search}%' or product.product_name like '%{$key_search}%')");
        }

        if (!is_null($request->input('available'))) {
            $query = $query->where('product.available', $request->input('available') );
        }

        if ($request->input('product_type')) {
            $query = $query->where(
                'product.product_type',
                $request->input('product_type')
            );
        }

        if ($request->input('product_category')) {
            $query = $query->where(
                'product.product_category_id',
                $request->input('product_category'
                )
            );
        }
        $query = $query->select(
            'product.product_id',
            'product.product_name',
            'product.product_type',
            'product.unit_name',
            'product.product_price',
            'product.product_tax',
            'product_category.category_name',
            DB::raw('sum(inventory_master.total_balance) as total_balance'),
            'product.invalid',
            'product.available'
        )
            ->join('product_category', function ($join) {
                $join->on('product_category.category_id', '=', 'product.product_category_id');
            })
            ->join('inventory_master', function ($join) {
                $join->on('inventory_master.product_id', '=', 'product.product_id');
            })
			->where('inventory_master.invalid', 0)
            ->groupBy('product.product_id')
        ->paginate($limit);

        $count = $query->total();
        $data = [
            'total_page' => ceil($count / $limit),
            'current_page' => $query->currentPage(),
            'item_per_page' => $limit,
            'total_item' => $count,
            'list_items' => $query->makeHidden('inventory_master.invalid')
        ];

        return $data;
    }

    public static function deleteProductById($id) {
        $query_product = product::where([
                            'product_id' => $id
                        ])
                        ->orWhere('product_master_id', $id)
                        ->update(['invalid' => 1]);
        $query_product_master = product_master::where('product_master_id', $id);

        if($query_product_master->count() > 0){
            $query_product_master->update(['invalid' => 1]);
        }
        else{
            $query_product_master = true;
        }
        
        if(!$query_product || !$query_product_master){
            return false;
        }
        return true;
	}

	public static function updateProductByProductMasterId($product_master_id, $shop_id, $params) {
		product::where([
			'product_master_id' => $product_master_id,
			'shop_id' => $shop_id
		])->update($params);
	}

	public static function getFoodInPriceByFoodId($product_id) {
        $data_product = product::where('product_id', $product_id)->select('in_price')->first();
        return $data_product->in_price;
    }

    public static function checkExistsProduct($product_name, $shop_id) {
        $data_product = product::where([
            'product_name' => $product_name,
            'shop_id' => $shop_id,
            'invalid' => 0,
        ])->select('product_id')->first();
        return $data_product ? $data_product->product_id : 0;
    }

    public static function createProductExcel($data_product, $shop_id) {
        $data_products = [];
        foreach ($data_product as $product_item) {
            //DB::beginTransaction();
            try{
                $product = new product();
                $product->shop_id = $shop_id;
                $product->owner_shop_id = $shop_id;
                $product->product_name = trim($product_item['product_name']);
                $product->info1 = trim($product_item['product_info1']);

                $product_master = new product_master();
                $product_master->shop_id = $shop_id;
                $product_master->product_name = trim($product_item['product_name']);
                $product_master->info1 = trim($product_item['product_info1']);

                if($product_category_name = trim($product_item['product_category_name'])) { //category
                    $product_category = product_category::where([
                        'category_name' => $product_category_name,
                        'shop_id' => $shop_id,
                    ])->first();
                    if(!$product_category) {
                        $product_category = new product_category();
                        $product_category->shop_id = $shop_id;
                        $product_category->category_name = $product_category_name;
                        $product_category->category_group = 0;
                        $product_category->status = 1;
                        $product_category->parent_id = 0;
                        $product_category->is_default = 0;
                        $product_category->category_flag = 1;
                        $product_category->save();
                    }

                    $product->product_category_id = $product_category->category_id;
                    $product_master->product_category_id = $product_category->category_id;
                }

                $product->available = 1;

                $product_master->available = 1;
                $product_master->receiptflg = 1;
                $product_master->status_in_day = 1;
                $product_master->status = 1;
                $product_master->point_get_flg = 1;
                $product_master->online_sell_flg = 1;
                $product_master->save();

                $product->product_master_id = $product_master->product_master_id;
                $product->receiptflg = 1;
                $product->alert_flg = 0;
                $product->product_type = 1;
                $product->point_get_flg = 1;
                $product->online_sell_flg = 1;
                $product->info3 = $product_item['product_info3'];
                $product->save();

                if($unit_name = strtoupper(trim($product_item['unit_name1']))) {
                    $unit = unit_master::where(['unitname' => $unit_name, 'shop_id' => $shop_id])->first();
                    if(!$unit) {
                        $unit = new unit_master();
                        $unit->shop_id = $shop_id;
                        $unit->unitname = $unit_name;
                        $unit->invalid = 0;
                        $unit->save();
                    }

                    $product->unit_id = $unit->id;
                    $product->unit_name = $unit->unitname;

                    $product_master->primary_unit_id = $unit->id;
                    $product_master->primary_unit_name = $unit->unitname;

                    $product_master_unit = product_unit::where([
                        'product_master_id' => $product_master->product_master_id,
                        'unit_id' => $unit->id,
                        'is_primary' => 1,
                        'shop_id' => $shop_id,
                    ])->first();

                    if(!$product_master_unit) {
                        $product_master_unit = new product_unit();
                        $product_master_unit->shop_id = $shop_id;
                        $product_master_unit->product_master_id = $product_master->product_master_id;
                        $product_master_unit->unit_id = $unit->id;
                        $product_master_unit->unit_name = $unit->unitname;
                        $product_master_unit->unit_exchange = $product_item['unit_exchange1'];
                        $product_master_unit->price = intval($product_item['default_price']);
                        $product_master_unit->is_primary = 1;
                        $product_master_unit->regdate = Util::getNow();
                        $product_master_unit->save();
                    }
                }

                if(
                    ($unit2_name = strtoupper(trim($product_item['unit_name2']))) &&
                    trim($product_item['unit_name1']) != trim($product_item['unit_name2'])
                ) {
                    $unit2 = unit_master::where(['unitname' => $unit2_name, 'shop_id' => $shop_id])->first();
                    if(!$unit2) {
                        $unit2 = new unit_master();
                        $unit2->shop_id = $shop_id;
                        $unit2->unitname = $unit2_name;
                        $unit2->invalid = 0;
                        $unit2->save();
                    }

                    $product_master_unit2 = product_unit::where([
                        'product_master_id' => $product_master->product_master_id,
                        'unit_id' => $unit2->id,
                        'unit_exchange' => intval($product_item['unit_exchange2']),
                        'price' => intval($product_item['unit_price2']),
                        'is_primary' => 0,
                        'shop_id' => $shop_id,
                    ])->first();

                    if(!$product_master_unit2) {
                        $product_master_unit2 = new product_unit();
                        $product_master_unit2->shop_id = $shop_id;
                        $product_master_unit2->product_master_id = $product_master->product_master_id;
                        $product_master_unit2->unit_id = $unit2->id;
                        $product_master_unit2->unit_name = $unit2->unitname;
                        $product_master_unit2->unit_exchange = intval($product_item['unit_exchange2']);
                        $product_master_unit2->price = intval($product_item['unit_price2']);
                        $product_master_unit2->is_primary = 0;
                        $product_master_unit2->regdate = Util::getNow();
                        $product_master_unit2->save();
                    }
                }

                if(
                    ($unit3_name = strtoupper(trim($product_item['unit_name3']))) &&
                    trim($product_item['unit_name1']) != trim($product_item['unit_name3'])
                ) {
                    $unit3 = unit_master::where(['unitname' => $unit3_name, 'shop_id' => $shop_id])->first();
                    if(!$unit3) {
                        $unit3 = new unit_master();
                        $unit3->shop_id = $shop_id;
                        $unit3->unitname = $unit3_name;
                        $unit3->invalid = 0;
                        $unit3->save();
                    }

                    $product_master_unit3 = product_unit::where([
                        'product_master_id' => $product_master->product_master_id,
                        'unit_id' => $unit3->id,
                        'unit_exchange' => intval($product_item['unit_exchange3']),
                        'price' => intval($product_item['unit_price3']),
                        'is_primary' => 0,
                        'shop_id' => $shop_id,
                    ])->first();

                    if(!$product_master_unit3) {
                        $product_master_unit3 = new product_unit();
                        $product_master_unit3->shop_id = $shop_id;
                        $product_master_unit3->product_master_id = $product_master->product_master_id;
                        $product_master_unit3->unit_id = $unit3->id;
                        $product_master_unit3->unit_name = $unit3->unitname;
                        $product_master_unit3->unit_exchange = intval($product_item['unit_exchange3']);
                        $product_master_unit3->price = intval($product_item['unit_price3']);
                        $product_master_unit3->is_primary = 0;
                        $product_master_unit3->regdate = Util::getNow();
                        $product_master_unit3->save();
                    }
                }

                $product_master->product_barcode = $product_item['product_barcode'];
                $product_master->default_price = intval($product_item['default_price']);
                $product_master->product_price = intval($product_item['default_price']);
                $product_master->save();

                $product->product_barcode = $product_item['product_barcode'];
                $product->product_price = intval($product_item['default_price']);
                $product->buy_price = intval($product_item['product_buy_price']);
                $product->save();

                $data_products['product_id'] = $product->product_id;
                //DB::commit();
            }
            catch(\Exception $e){
                echo $e->getMessage();
            }
        }
        return $data_products;
    }

    public static function getProductDetailByProductMasterId($product_master_id){
        $response = product::where([
            'product_master_id' => $product_master_id,
            'invalid' => 0
        ])->get();
        return $response;
    }

    public static function exportProductExcelTransaction($data_product) {
        $data_success = $data_error = [];
        foreach ($data_product[0] as $row) {
            $msg_error = [];
            if(!$row[2]) {
                $msg_error[] = __('messages.product_name_null');
            }
            /*if(!$row[19]) {
                $msg_error[] = __('messages.product_info3_null');
            }*/
            if(!$row[9]) {
                $msg_error[] = __('messages.unit_name_null');
            }
            if($row[13] && !is_numeric($row[13])){
                $msg_error[] = __('messages.defined_exchange2');
            }
            if($row[15] && !is_numeric($row[15])){
                $msg_error[] = __('messages.defined_exchange3');
            }
            if(!$row[22]) {
                $msg_error[] = __('messages.batch_name_null');
            }
            if(!$row[23]) {
                $msg_error[] = __('messages.batch_expire_date_error');
            }
            if(!$row[24]) {
                $msg_error[] = __('messages.unit_import_error');
            }
            if(!$row[25] || ($row[25] && !is_numeric($row[25]))){
                $msg_error[] = __('messages.unit_quantity_error');
            }
            if(!$row[26] || ($row[26] && !is_numeric($row[26]))){
                $msg_error[] = __('messages.unit_convert_error');
            }
            if(!$row[27] || ($row[27] && !is_numeric($row[27]))){
                $msg_error[] = __('messages.price_export_error');
            }
            if(!$row[28] || ($row[28] && !is_numeric($row[28]))){
                $msg_error[] = __('messages.vat_buy_error');
            }
            if(!$row[29] || ($row[29] && !is_numeric($row[29]))){
                $msg_error[] = __('messages.price_import_error');
            }
            if($row[30] && !is_numeric($row[30])) {
                $msg_error[] = __('messages.vat_sell_error');
            }
            if($row[31] && !is_numeric($row[31])) {
                $msg_error[] = __('messages.discount_not_correct');
            }

            if($msg_error) {
                $data_error[] = [
                    'product_barcode' => $row[1],
                    'product_name' => $row[2],
                    'product_info1' => $row[3],
                    'product_category_name' => $row[4],
                    'product_info6' => $row[7],
                    'product_info2' => $row[8],
                    'unit_name1' => $row[9],
                    'unit_exchange1' => $row[10],
                    'default_price' => $row[11],
                    'unit_name2' => $row[12],
                    'unit_exchange2' => $row[13],
                    'unit_price2' => $row[14],
                    'unit_name3' => $row[15],
                    'unit_exchange3' => $row[16],
                    'unit_price3' => $row[17],
                    'product_buy_price' => $row[18],
                    'product_info3' => $row[19],
                    'product_info5' => $row[20],
                    'profuct_info4' => $row[21],
                    'batch_no' => $row[22],
                    'batch_expire_date' => $row[23],
                    'unit_import' => $row[24],
                    'unit_quantity_import' => $row[25],
                    'unit_convert' => $row[26],
                    'sellprice' => $row[27],
                    'sellvat' => $row[28],
                    'costprice' => $row[29],
                    'costvat' => $row[30],
                    'discount' => $row[31],
                    'msg_error' => $msg_error
                ];
            }
            else {
                $data_success[] = [
                    'product_barcode' => $row[1],
                    'product_name' => $row[2],
                    'product_info1' => $row[3],
                    'product_category_name' => $row[4],
                    'product_info6' => $row[7],
                    'product_info2' => $row[8],
                    'unit_name1' => $row[9],
                    'unit_exchange1' => $row[10],
                    'default_price' => $row[11],
                    'unit_name2' => $row[12],
                    'unit_exchange2' => $row[13],
                    'unit_price2' => $row[14],
                    'unit_name3' => $row[15],
                    'unit_exchange3' => $row[16],
                    'unit_price3' => $row[17],
                    'product_buy_price' => $row[18],
                    'product_info3' => $row[19],
                    'product_info5' => $row[20],
                    'profuct_info4' => $row[21],
                    'batch_no' => $row[22],
                    'batch_expire_date' => $row[23],
                    'unit_import' => $row[24],
                    'unit_quantity_import' => $row[25],
                    'unit_convert' => $row[26],
                    'sellprice' => $row[27],
                    'sellvat' => $row[28],
                    'costprice' => $row[29],
                    'costvat' => $row[30],
                    'discount' => $row[31],
                    'msg_error' => []
                ];
            }
        }

        $data = ['success' => $data_success, 'error' => $data_error];
        return $data;
    }

    public static function getProductMasterId($product_id, $shop_id) {
        $product = product::where([
            'product_id' => $product_id,
            'shop_id' => $shop_id,
            'invalid' => 0
        ])->select('product_master_id')->first();

        return $product->product_master_id;
    }
}

