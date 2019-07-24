<?php

namespace App\Models;

use App\Helper\Constant;
use App\Helpers\Util;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class asset extends Model
{
	public const CREATED_AT = 'regdate';
	public const UPDATED_AT = 'update';

    protected $table = 'asset';
    protected $hidden = ['regdate_local', 'update_local', 'invalid'];

    public static function getAssetByShopId($shop_id, $asset_id = null, $name = null) {
    	$query = asset::where([
    		'shop_id' => $shop_id,
    		'invalid' => 0,
		]);

    	if($asset_id) {
    		$query->where('id', $asset_id);
    		return $query->first();
		}

		if(!is_null($name)){
			$query = $query->where('name', 'like', "%$name%");
		}

		return $query->get();
    }

	public static function getAssetById($asset_id, $shop_id) {
		return asset::where([
			'id' => $asset_id,
			'shop_id' => $shop_id,
			'invalid' => 0,
		])->first();
	}

	public static function updateAssetAttributeByAssetId($asset_id, $shop_id, $key, $val) {
		asset::where([
			'id' => $asset_id,
			'shop_id' => $shop_id
		])->update([$key => $val]);
	}

	public static function updateAssetTotalTransactionByAssetId($asset_id, $shop_id, $total_asset, $type) {
		$operator = $type == Constant::TRASACTION_TYPE_IMPORT ? '+' : '-';
		$sql = <<<EOD
update asset
set asset_total = asset_total {$operator} {$total_asset}
where id = '{$asset_id}' and shop_id = '{$shop_id}'
EOD;
		DB::update($sql);
	}

    public static function countExistedAssetName($name, $shop_id, $id){
        $count = asset::where([
            'name' => $name,
			'shop_id' => $shop_id,
			'invalid' => 0
        ]);
        if(!is_null($id)){
            $count = $count->where('id','<>', $id);
        }
        return $count->count();
    }

	public static function updateOrInsertAsset($data, $id=null){
		if(isset($data['name'])){
			if(asset::countExistedAssetName($data['name'], $data['shop_id'], $id) > 0){
				return 'messages.existed_data';
			}
		}
		$query = asset::updateOrInsert([ 'id' => $id ], $data);
		if($query){
			return 'messages.success';
		}
		return 'messages.error';
	}

	public static function deleteAsset($shop_id, $id){
		$query = asset::where([
			'id' => $id,
			'shop_id' => $shop_id,
			'invalid' => 0
		])->update(['invalid' => 1]);

		if($query){
			return true;
		}
		return false;
	}

    public static function addWalletDefault($account_id, $shop_id) {
        $account = account::where(['id' => $account_id, 'available' => 1])->first();
        $asset_currency = $currency_denomination = null;
        if($account && $account->langcode) {
            $currency = Constant::$CURRENCY_LANGCODE[$account->langcode];
            $asset_currency = $currency;
            $currency_denomination = Constant::$CURRENCY_DENOMINATION[$currency];
        }

        $data_insert[] = [
            'name' => 'Tiền mặt',
            'shop_id' => $shop_id,
            'type' => 1,
            'default_flg' => 1,
            'asset_currency' => $asset_currency,
            'currency_denomination' => $currency_denomination,
            'regdate' => Util::getNow()
        ];
        $data_insert[] = [
            'name' => 'Tài khoản',
            'shop_id' => $shop_id,
            'type' => 2,
            'default_flg' => 0,
            'asset_currency' => $asset_currency,
            'currency_denomination' => $currency_denomination,
			'regdate' => Util::getNow()
        ];
        try {
            asset::insert($data_insert);
        }
        catch (\Exception $e) {
            throw new \Exception(__($e->getMessage() . 'cant not save asset'), 1);
        }
    }
}
