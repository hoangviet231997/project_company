<?php

namespace App\Models;

use App\Helper\Constant;
use App\Helpers\Util;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class shop extends Model {
	protected $table = 'shop';
	public $timestamps = false;

	public static function getShopById($shop_id) {
		return shop::find($shop_id);
	}

	public static function getShopDetailById($id){
		return shop::where('id', $id)->first();
	}

	public static function getShortAddress($address){
		if(!is_null($address)){
			$splice = explode(",", $address);
			return $splice[0];
		}
		return null;
	}

	public static function getPublicShop($data) {
		$query = shop::select([
			DB::raw('shop.id as id'),
			'address',
			'image',
			DB::raw('city.city_name as city_name'),
			DB::raw('district.district_name as district_name'),
			'latitude',
			'longitude',
			'tel',
			'open_hour',
			DB::raw('asset.id as asset_id'),
			DB::raw('asset.name as asset_name'),
		]);

		$query->leftJoin('city', function($join) {
			$join->on('shop.city', '=', 'city.id');
		});

		$query->leftJoin('district', function($join) {
			$join->on('shop.district', '=', 'district.id');
		});

		$query->leftJoin('asset', function($join) {
			$join->on('shop.id', '=', 'asset.shop_id')->where('asset.default_flg', '=', 1);
		});

		if($shop_type = Util::getParam($data, 'type')) {
			$query->where('shop.type', $shop_type);
		}

		$query = $query->where('shop.public_shop_flg', 1)
					   ->where('shop.invalid', 0)
					   ->get();

		$array = [];
		foreach($query as $item){
			$data = [
				"id" => $item->id,
				"shortAddress" => shop::getShortAddress($item->address),
				"image" => $item->image,
				"area" => $item->city_name,
				"subArea" => $item->district_name,
				"latitude" => $item->latitude,
				"longitude" => $item->longitude,
				"fullAddress" => $item->address,
				"contact" => $item->tel,
				"openHours" => $item->open_hour,
				"assetId" => $item->asset_id,
				"assetName" => $item->asset_name,
			];
			array_push($array, $data);
		}

		return $array;
	}

	public static function createOrUpdateShop($data, $id = 0) {
	    if(!$id) {
            $data['regdate'] = date('Y-m-d H:i:s');
            $id = shop::insertGetId($data);
        }
        else {
            $data['last_update_date'] = date('Y-m-d H:i:s');
            shop::updateOrInsert(['id' => $id], $data);
        }
	    if(!$id) {
	        throw new \Exception('__(messages.can\'t_save)'.'shop', 1);
        }
        return $id;
    }

    public static function updateAccountId($shop_id, $account_id) {
	   $shop = shop::where(['id' => $shop_id])->update(['account_id' => $account_id]);
	   return $shop;
    }

    public static function getShopTypeById($shop_id) {
	    $shop = shop::where(['id' => $shop_id, 'invalid' => 0])->first();
	    return $shop ? $shop->type : 1;
    }

    public static function getShopParentAgency() {
	    return Constant::CUSTOMER_AGENCY_REGISTER_PARENT_SHOP_ID;
    }
}
