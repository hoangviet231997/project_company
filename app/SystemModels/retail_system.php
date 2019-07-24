<?php

namespace App\SystemModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class retail_system extends Model
{
	public static function login($username, $password)
    {
    	DB::setDefaultConnection('mysql2');

		$query = collect(DB::table('account')
		    		->where(['username'=> $username, 'password'=> $password, 'invalid' => 0])
		    		->join('shop_setting', 'account.shop_id', '=', 'shop_setting.shop_id')
		            ->join('database_master', 'account.shop_id', '=', 'database_master.shop_id')
		            ->join('server_master', 'account.shop_id', '=', 'server_master.shop_id')
		            ->select('shop_setting.*')			            
		            ->first());
		
		if(count($query) > 0){
			$data = $query->except('id');
			return $data;
		}
    }
}
