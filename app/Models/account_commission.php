<?php
//CREATE TABLE `account_commission` (
//`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
//  `shop_id` int(11) NOT NULL DEFAULT '0',
//  `account_id` int(11) DEFAULT NULL,
//  `commission_id` int(11) DEFAULT NULL,
//  PRIMARY KEY (`id`)
//) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

////tmp hide
//namespace App\Models;
//
//use Illuminate\Database\Eloquent\Model;
//use Illuminate\Support\Facades\DB;
//
//class account_commission extends Model
//{
//    protected $table = 'account_commission';
//
//    public static function getListAccountCommission($shop_id){
//        $response = account_commission::select([
//            'account_commission.*',
//            DB::raw('commission_master.customer_supplier_group_id as customer_supplier_group_id'),
//            DB::raw('commission_master.product_id as product_id'),
//            DB::raw('commission_master.product_amount as product_amount'),
//            DB::raw('commission_master.commission_percent as commission_percent'),
//        ]);
//
//        $response->join('commission_master', function($join){
//            $join->on('account_commission.commission_id', '=', 'commission_master.id');
//        });
//
//        $response = $response->where([
//            'account_commission.shop_id' => $shop_id
//        ]);
//
//        return $response->get();
//    }
//
//    public static function getAccountCommissionDetail($shop_id, $id){
//        $response = account_commission::select([
//            'account_commission.*',
//            DB::raw('commission_master.customer_supplier_group_id as customer_supplier_group_id'),
//            DB::raw('commission_master.product_id as product_id'),
//            DB::raw('commission_master.product_amount as product_amount'),
//            DB::raw('commission_master.commission_percent as commission_percent'),
//        ]);
//
//        $response->join('commission_master', function($join){
//            $join->on('account_commission.commission_id', '=', 'commission_master.id');
//        });
//        $response = $response->where([
//            'account_commission.shop_id' => $shop_id,
//            'account_commission.id' => $id,
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
//    public static function updateOrInsertAccountCommission($data, $id=null){
//        if(isset($data['commission_id'])){
//            $check_commission = account_commission::checkNotExisted('commission_master', 'shop_id', $data['commission_id'], $data['shop_id']);
//            if($check_commission){
//                return $check_commission;
//            }
//        }
//        if(isset($data['account_id'])){
//            $check_account = account_commission::checkNotExisted('account', 'main_shopid', $data['account_id'], $data['shop_id']);
//            if($check_account){
//                return $check_account;
//            }
//        }
//
//		$query = account_commission::updateOrInsert([ 'id' => $id ], $data);
//		if($query){
//			return 'messages.success';
//		}
//		return 'messages.error';
//    }
//
//    public static function deleteAccountCommissionById($shop_id, $id){
//        $query = account_commission::where([
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
//    public static function deleteAccountCommissionByCommissionId($shop_id, $commission_id){
//        $query = account_commission::where([
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
