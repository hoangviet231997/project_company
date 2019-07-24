<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class area extends Model
{
    protected $table = 'area';

    public static function getListArea($shop_id){
        $response = area::where([
            'shop_id' => $shop_id
        ])->get();
        return $response;
    }

    public static function getListAreaTable($shop_id){
        $response = area::where([
            'shop_id' => $shop_id
        ])->get();

        foreach ($response as $value) {
            $value['list_tables'] = table::getTableByAreaId($shop_id, $value['id']);

        }

        return $response;
    }

    public static function getAreaDetail($shop_id, $id){
        return area::where([
            'shop_id' => $shop_id,
            'id' => $id
        ])->first();
    }

    public static function countExistedAreaName($name, $shop_id, $id = null){
        $count = area::where([
            'name' => $name,
            'shop_id' => $shop_id
        ]);
        if(!is_null($id)){
            $count = $count->where('id','<>', $id);
        }
        return $count->count();
    }

    public static function updateOrInsertArea($data, $id=null){
        if(isset($data['name'])){
			if(area::countExistedAreaName($data['name'], $data['shop_id'], $id) > 0){
				return 'messages.existed_data';
			}
		}
		$query = area::updateOrInsert([ 'id' => $id ], $data);
		if($query){
			return 'messages.success';
		}
		return 'messages.error';
    }

    public static function deleteArea($shop_id, $id){
        $query = area::where([
			'id' => $id,
			'shop_id' => $shop_id
		])->delete();
		
		if(!$query){
			return false;
        }
        
        $query_table = table::deleteTableByAreaId($shop_id, $id);
        if(!$query_table){
            return false;
        }
        return true;
    }
}
