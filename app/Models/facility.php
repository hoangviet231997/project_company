<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class facility extends Model
{
    protected $table = 'facility_master';
    public $timestamps = false;
    
    
    public static function getFacilityIdByShop($shop_id) {
        $data = facility::where([
            'shop_id' => $shop_id,
            'invalid' => 0
        ])->select('id', 'shop_id', 'facility_name')->get();
        
        return $data;
    }

    public static function getListFacilityByShopId($shop_id, $facility_name = null){
        $response = facility::where([
            'shop_id' => $shop_id,
            'invalid' => 0
        ]);
        if(!is_null($facility_name)){
            $response->where('facility_name', 'like', "%$facility_name%");
        }
        $response = $response->get()->makeHidden('invalid');
        return $response;
    }

    public static function getFacilityById($id, $shop_id){
        $response = facility::where([
            'shop_id' => $shop_id,
            'invalid' => 0,
            'id' => $id
        ])->first();
        if(!is_null($response)){
            $response = $response->makeHidden('invalid');
        }
        return $response;
    }

    public static function countExistedFacilityName($facility_name, $shop_id, $id = null){
        $count = facility::where([
            'facility_name' => $facility_name,
            'shop_id' => $shop_id,
            'invalid' => 0
        ]);
        if(!is_null($id)){
            $count = $count->where('id','<>', $id);
        }
        return $count->count();
    }

    public static function updateOrInsertFacility($data, $id=null){
        if(isset($data['facility_name'])){
			if(facility::countExistedFacilityName($data['facility_name'], $data['shop_id'], $id) > 0){
				return 'messages.existed_data';
			}
        }
        if(!is_null($id)) {
            $query = facility::updateOrInsert([ 'id' => $id ], $data);
            if($query){
                return 'messages.success';
            }
        }
        else {
            $last_id = facility::insertGetId($data);
            if($last_id) {
                $response = facility::getFacilityById($last_id, $data['shop_id']);
                return $response;
            }
        }
		
		return 'messages.error';
    }

    public static function deleteFacility($shop_id, $id){
        $query = facility::where([
			'id' => $id,
			'shop_id' => $shop_id,
			'invalid' => 0
		])->update(['invalid' => 1]);
		
		if($query){
			return true;
		}
		return false;
    }
}
