<?php
//CREATE TABLE `dealer_commission` (
//`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
//  `shop_id` int(11) NOT NULL DEFAULT '0',
//  `dealer_id` int(11) DEFAULT NULL,
//  `commission_id` int(11) DEFAULT NULL,
//  PRIMARY KEY (`id`)
//) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

//////tmp hide
//namespace App\Models;
//
//use Illuminate\Database\Eloquent\Model;
//use Illuminate\Support\Facades\DB;
//class dealer_commission extends Model
//{
//    protected $table = 'dealer_commission';
//
//    public static function getListDealerCommission($shop_id){
//        $response = dealer_commission::select([
//            'dealer_commission.*',
//            DB::raw('commission_master.customer_supplier_group_id as customer_supplier_group_id'),
//            DB::raw('commission_master.product_id as product_id'),
//            DB::raw('commission_master.product_amount as product_amount'),
//            DB::raw('commission_master.commission_percent as commission_percent'),
//        ]);
//
//        $response->join('commission_master', function($join){
//            $join->on('dealer_commission.commission_id', '=', 'commission_master.id');
//        });
//
//        $response = $response->where([
//            'dealer_commission.shop_id' => $shop_id
//        ]);
//
//        return $response->get();
//    }
//
//    public static function getDealerCommissionDetail($shop_id, $id){
//        $response = dealer_commission::select([
//            'dealer_commission.*',
//            DB::raw('commission_master.customer_supplier_group_id as customer_supplier_group_id'),
//            DB::raw('commission_master.product_id as product_id'),
//            DB::raw('commission_master.product_amount as product_amount'),
//            DB::raw('commission_master.commission_percent as commission_percent'),
//        ]);
//
//        $response->join('commission_master', function($join){
//            $join->on('dealer_commission.commission_id', '=', 'commission_master.id');
//        });
//        $response = $response->where([
//            'dealer_commission.shop_id' => $shop_id,
//            'dealer_commission.id' => $id,
//        ]);
//
//        return $response->first();
//    }
//    public static function checkNotExisted($table_name, $shopid_field_name, $id, $shop_id){
//        $count = DB::table($table_name)->where([
//            'id' => $id,
//            $shopid_field_name => $shop_id
//            ])->count();
//        if($count == 0){
//            return 'messages.not_existed';
//        }
//        return false;
//    }
//    public static function updateOrInsertDealerCommission($data, $id=null){
//        if(isset($data['commission_id'])){
//            $check_commission = dealer_commission::checkNotExisted('commission_master', 'shop_id', $data['commission_id'], $data['shop_id']);
//            if($check_commission){
//                return $check_commission;
//            }
//        }
//        if(isset($data['dealer_id'])){
//            $check_account = dealer_commission::checkNotExisted('customer_supplier', 'shop_id', $data['dealer_id'], $data['shop_id']);
//            if($check_account){
//                return $check_account;
//            }
//        }
//
//		$query = dealer_commission::updateOrInsert([ 'id' => $id ], $data);
//		if($query){
//			return 'messages.success';
//		}
//		return 'messages.error';
//    }
//
//    public static function deleteDealerCommissionById($shop_id, $id){
//        $query = dealer_commission::where([
//			'id' => $id,
//			'shop_id' => $shop_id
//		])->delete();
//
//		if(!$query){
//			return false;
//        }
//        return true;
//    }
//
//    public static function deleteDealerCommissionByCommissionId($shop_id, $commission_id){
//        $query = dealer_commission::where([
//			'commission_id' => $commission_id,
//			'shop_id' => $shop_id
//        ]);
//
//        if($query->count() > 0){
//            $query=$query->delete();
//            if(!$query){
//                return false;
//            }
//        }
//        return true;
//    }
//}
