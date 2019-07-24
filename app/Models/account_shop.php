<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class account_shop extends Model
{
	protected $table = 'account_shop';
	
    public $timestamps = false;

    public function account() {
    	return $this->belongsTo('App\Models\account', 'account_id', 'id');
	}

	public static function validateShop($token, $shop_id) {
    	return account_shop::where([
    		'token' => $token,
			'shop_id' => $shop_id,
			'mainshop_flg' => 1
		])->count();
	}

	public static function validateChain($token, $shop_id) {
    	return account::where([
    		'is_chain' => 1,
			'is_allow_chain' => 1,
		])->join('account_shop', function($join) use ($token, $shop_id) {
			$join->on('account.id', '=', 'account_shop.account_id')
			->where([
				['account_shop.token', '=', $token],
				['account_shop.shop_id', '=', $shop_id]
			]);
		})->count();
	}

	public static function getPermission($shop_id, $token) {
        $account = account_shop::where([
            'account_shop.shop_id' => $shop_id,
            'token' => $token,
            'invalid' => 0
        ])->Join('role_permission', function ($join) {
            $join->on('role_permission.id', '=', 'account_shop.role_permission_id');
        })->first();
        return $account;
    }
}
