<?php

namespace App\Models;

use App\Helper\Constant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Helpers\Util;

class account extends Model
{
	protected $table = 'account';
    public $timestamps = false;

	public function main_shop() {
		return $this->hasOne('App\Models\shop', 'id', 'main_shopid');
	}

	public function main_account_shop() {
		return $this->hasOne('App\Models\account_shop', 'account_id', 'id');
	}

	public static function validateToken($token, $shop_id, $auth, $code) {
		if($token && $shop_id) {
			if(account_shop::validateShop($token, $shop_id)) { //shop
				return true;
			}
			else if(account_shop::validateChain($token, $shop_id)) { //chain
				return true;
			}
			else if($auth && $code) { //ios
				$timeout = Constant::RULE_TIMEOUT_EXPIRED_TOKEN;
				$timeout_expired_token = strtotime('-' . $timeout) * 1000;
				$server_auth = md5(($code + $shop_id) * 2);
				if($timeout_expired_token < $code && $auth == $server_auth) {
					return true;
				}
			}
		}

		return false;
	}

	public static function getAccount($user_name, $pass) {
		return account::with('main_shop', 'main_account_shop')->where([
			'username' => $user_name,
			'password' => $pass,
            'available' => 1
		])->first();
	}

	public static function getAccountAgencyByAccountId($shop_id, $account_id) {
        $account_agency = customer_supplier::checkAccountAgency($account_id, $shop_id);
	    return account::with('main_shop', 'main_account_shop')->where(['id' => $account_agency])->first();
    }

	public static function getAccountByToken($token) {
		if($token) {
			return account::join('account_shop', function($join) use ($token) {
				$join->on('account.id', '=', 'account_shop.account_id')
					 ->where([
						 ['account_shop.token', '=', $token]
					 ]);
			})->first();
		}
		return null;
    }

    public function getListShopChild($shop_id)
    {
        $is_chain = account::where(['is_chain' => 1, 'main_shopid' => $shop_id])->count();
        if ($is_chain) {
            $query = account::join('account_shop', 'account_shop.account_id', '=',
                'account.id')->where('account.main_shopid', $shop_id)->select('account_shop.shop_id')->get()->toArray();
            $data = [];
            foreach ($query as $shop_id => $value)
                $data[] = $value['shop_id'];
            return $data;
        } else {
            return $shop_id;
        }
    }

    public static function getListStaff($shop_id) {
		$query = account::select([
			DB::raw('account.id as id'),
			DB::raw('account_shop.shop_id as shop_id'),
			'username',
			'email',
			'full_name',
			'phone',
			'address',
			'orderpass',
			'role',
			'role_shop',
			'langcode',
			'timework',
			DB::raw('account_shop.token as token'),
			DB::raw('account_shop.role_permission_id as role_permission_id'),
			DB::raw('role_name as role_permission_name'),
			DB::raw('account.customer_supplier_group_id as account_group_id'),
			DB::raw('customer_supplier_group.group_name as account_group_name'),
			//commission of account
			DB::raw('account_commission.commission_id as commission_id'),
			DB::raw('commission_master.customer_supplier_group_id as customer_supplier_group_id'),
            //DB::raw('commission_master.product_id as product_id'),
            //DB::raw('commission_master.product_amount as product_amount'),
            //DB::raw('commission_master.commission_percent as commission_percent'),
		]);

		$query->join('account_shop', function($join) {
			$join->on('account.id', '=', 'account_shop.account_id');
		});
		$query->leftJoin('account_commission', function($join) {
			$join->on('account.id', '=', 'account_commission.account_id');
		});
		$query->leftJoin('commission_master', function($join){
            $join->on('account_commission.commission_id', '=', 'commission_master.id');
        });
		$query->leftJoin('role_permission', function($join) {
			$join->on('account_shop.role_permission_id', '=', 'role_permission.id');
		});
		$query->leftJoin('customer_supplier_group', function($join) {
			$join->on('account.customer_supplier_group_id', '=', 'customer_supplier_group.id');
		});

		return $query->where('account_shop.shop_id', $shop_id)->get();
	}

	public static function countAccountExisted($username, $email, $id = null){
		$query = account::where(function ($query) use ($username, $email){
			$query->where(['username' => $username, 'available' => 1]);
				  //->orWhere('email', $email);
		});
		if(!is_null($id)){
			$query->where('id', '<>', $id);
		}
		return $query->count();

	}

	public static function getAccountById($id, $shop_id){
		$query = account::select([
			DB::raw('account.id as id'),
			DB::raw('account_shop.shop_id as shop_id'),
			'username',
			'email',
			'full_name',
			'phone',
			'address',
			'orderpass',
			'role',
			'role_shop',
			'langcode',
			'timework',
			DB::raw('account_shop.token as token'),
			DB::raw('account_shop.role_permission_id as role_permission_id'),
			DB::raw('role_name as role_permission_name'),
			DB::raw('account.customer_supplier_group_id as account_group_id'),
			DB::raw('customer_supplier_group.group_name as account_group_name'),
			//commission of account
//			DB::raw('account_commission.commission_id as commission_id'),
//			DB::raw('commission_master.customer_supplier_group_id as customer_supplier_group_id'),
//            DB::raw('commission_master.product_id as product_id'),
//            DB::raw('commission_master.product_amount as product_amount'),
//            DB::raw('commission_master.commission_percent as commission_percent'),
		]);

		$query->join('account_shop', function($join) {
			$join->on('account.id', '=', 'account_shop.account_id');
		});
		$query->leftJoin('account_commission', function($join) {
			$join->on('account.id', '=', 'account_commission.account_id');
		});
		$query->leftJoin('commission_master', function($join){
            $join->on('account_commission.commission_id', '=', 'commission_master.id');
        });
		$query->leftJoin('role_permission', function($join) {
			$join->on('account_shop.role_permission_id', '=', 'role_permission.id');
		});
		$query->leftJoin('customer_supplier_group', function($join) {
			$join->on('account.customer_supplier_group_id', '=', 'customer_supplier_group.id');
		});

		return $query->where([
			'account_shop.shop_id' => $shop_id,
			'account.id' => $id
			])->first();
	}

	public static function updateOrInsertAccount($data, $role_permission_id=null, $push_id=null, $device_id=null, $device_type=null, $id=null){
		if(is_null($id) && account::countAccountExisted($data['username'], $data['email'], $id) > 0){//$id null when in insert case
			return 'messages.existed_account';
		}
		if(isset($data['password'])) {
			$data['password'] = sha1($data['password']);
		}

		if(!is_null($id)){
			//avoid change username and email in update case
			if(isset($data['username'])){
				unset($data['username']);
			}
			if(isset($data['email'])){
				unset($data['email']);
			}
//			$query_update = account::updateOrInsert(['id' => $id], $data);
//			if(!$query_update){
//				return 'messages.error';
//			}

			account::updateOrInsert(['id' => $id], $data);

			if(!is_null($role_permission_id)){
//				$query_shop_update = account_shop::where('account_id', $id)->update(['role_permission_id' => $role_permission_id]);
//				if(!$query_shop_update){
//					return 'messages.error';
//				}
				account_shop::where('account_id', $id)->update(['role_permission_id' => $role_permission_id]);
			}

			$updated_data = account::getAccountById($id, $data['main_shopid']);
		}
		else{

			$id = account::insertGetId($data); // insert into account table and get this id
			//begin insert or update to account_shop table in insert case
			$param = [];
			$shop_name = shop::where('id', $data['main_shopid'])
				->first();
			$param['shop_name'] = $shop_name->name;
			$param['token'] = Util::getToken();
			$param['regdate'] = Util::getNow();
			$param['mainshop_flg'] = 1;
			$param['shop_id'] = $data['main_shopid'];
			$param['role_permission_id'] = $role_permission_id;

			$query_account_shop = account_shop::updateOrInsert(['account_id' => $id], $param);
			if(!$query_account_shop){
				return'messages.error';
			}

			$inserted_data = account::getAccountById($id,$param['shop_id']);
		}

		if($push_id != null && $device_id != null && $device_type != null){//check push_id, device_id, device_type is existed
			account_push::deleteAccountPushByDeviceId($device_id);
			$push_data['shop_id'] = $data['main_shopid'];
			$push_data['push_id'] = $push_id;
			$push_data['device_id'] = $device_id;
			$push_data['device_type'] = $device_type;
			$query_account_push = account_push::updateOrInsert(['account_id' => $id], $push_data);
			if(!$query_account_push){
				return 'messages.error';
			}

		}
		if(isset($inserted_data)){
			return $inserted_data;
		}
		if(isset($updated_data)){
			return $updated_data;
		}
		return 'messages.success';
	}

	public static function deleteAccount($id){
		$query_shop = account_shop::where('account_id', $id);
		if($query_shop->count() > 0){
			if(!$query_shop->delete()){
				return false;
			}
		}
		$query_push = account_push::where('account_id', $id);
		if($query_push->count() > 0){
			if(!$query_push->delete()){
				return false;
			}
		}
		if(!account::where('id', $id)->delete()){
			return false;
		}

		return true;

	}

    public static function updateOrInsertAccountCustomerAgency($data, $id = null, $role_permission_id = null, $push_id = null, $device_id = null, $device_type = null){
        if ((is_null($id) || !intval($id)) && account::countAccountExisted($data['username'], $data['email'],
                $id) > 0) {
            throw new \Exception(__('messages.existed_account'), 1);
            return;
        }
        if (isset($data['password'])) {
            $data['password'] = sha1($data['password']);
        }

        if (!is_null($id) && intval($id)) {
            if (isset($data['username'])) {
                unset($data['username']);
            }
            if (isset($data['email'])) {
                unset($data['email']);
            }
            $data_clone = $data;
            $data_clone['main_shopid'] = $data['shop_id'];
            unset($data_clone['shop_id']);
            account::updateOrInsert(['id' => intval($id)], $data_clone);

            if (!is_null($role_permission_id)) {
                account_shop::where('account_id', $id)->update(['role_permission_id' => $role_permission_id]);
            }
        } else {
            // main_shop_id = shop_id  (case create new account customer agency)
            $data_clone = $data;
            $data_clone['main_shopid'] = $data['shop_id'];
            unset($data_clone['shop_id']);
            $id = account::insertGetId($data_clone);
            $param = [];
            $shop_name = shop::where('id', $data['shop_id'])->first();
            $param['shop_name'] = $shop_name->name;
            $param['token'] = Util::getToken();
            $param['regdate'] = Util::getNow();
            $param['mainshop_flg'] = 1;
            $param['shop_id'] = $data['shop_id'];
            $param['role_permission_id'] = $role_permission_id;

            $query_account_shop = account_shop::updateOrInsert(['account_id' => $id], $param);
            if (!$query_account_shop) {
                throw new \Exception(__('messages.error') . 'account_shop', 1);
            }
        }

        if ($push_id != null && $device_id != null && $device_type != null) {
            account_push::deleteAccountPushByDeviceId($device_id);
            $push_data['shop_id'] = $data['shop_id'];
            $push_data['push_id'] = $push_id;
            $push_data['device_id'] = $device_id;
            $push_data['device_type'] = $device_type;
            $query_account_push = account_push::updateOrInsert(['account_id' => $id], $push_data);
            if (!$query_account_push) {
                return __('messages.error');
            }

        }
        return $id;
    }

    public static function getAccountAgencyByShop($shop_id) {
	    /*account link to agency*/
        $data = account::where(['account.main_shopid' => $shop_id, 'available' => 1])
            ->join('customer_supplier', function ($join) {
                $join->on('customer_supplier.access_account_id', '=', 'account.id');
            })
            ->select(DB::raw('account.id as account_id'), 'account.username');

        /*account owner*/
        $data_owner = account::where(['account.main_shopid' => $shop_id, 'available' => 1])
            ->join('shop', function ($join) {
                $join->on('shop.account_id', '=', 'account.id')
                    ->on('shop.id', '=', 'account.main_shopid');
            })
            ->select(DB::raw('account.id as account_id'), 'account.username')->union($data)->first();
        return $data_owner;
    }

    public static function updateStatusLogin($id, $available) {
	    return account::where(['id' => $id])->update(['available' => $available]);
    }
}
