<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class order_type_master extends Model
{
    protected $table = 'order_type_master';
    public $timestamps = false; 

    public static function getListOrderType($shop_id){
        $response = order_type_master::whereIn('shop_id', [0, $shop_id])
                                    ->where('invalid', 0)
                                    ->get();
        if(!is_null($response)){
            $response = $response->makeHidden('invalid');
        }
        return $response;
    }

    public static function getOrderTypeById($shop_id, $id){
        $response = order_type_master::whereIn('shop_id', [0, $shop_id])
                                    ->where([
                                        'id' => $id,
                                        'invalid' => 0
                                    ])
                                    ->first();
        if(!is_null($response)){
            $response = $response->makeHidden('invalid');
        }
        return $response;
    }

    public static function countExistedOrderType($order_type, $shop_id, $id){
        $count = order_type_master::where([
            'order_type' => $order_type,
			'shop_id' => $shop_id,
			'invalid' => 0
        ]);
        if(!is_null($id)){
            $count = $count->where('id','<>', $id);
        }
        return $count->count();
    }

    public static function updateOrInsertOrderType($data, $id = null){
        if(isset($data['order_type'])){
            if(order_type_master::countExistedOrderType($data['order_type'], $data['shop_id'], $id) > 0){
                return 'messages.existed_data';
            }
        }
        $query = order_type_master::updateOrInsert(['id' => $id], $data);
        if($query){
            return 'messages.success';
        }
        return 'messages.error';
        
    }

    public static function deleteOrderType($shop_id, $id){
        $query = order_type_master::where([
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
