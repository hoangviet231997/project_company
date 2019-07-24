<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class table extends Model
{
    protected $table = 'table';

    public static function getTableByShopId($shop_id){
        $query = table::select([
            'table.*',
            DB::raw('area.name as area_name')
        ]);

        $query->leftJoin('area', function($join){
            $join->on('table.area_id', '=', 'area.id');
        });

        $query = $query->where([
            'table.shop_id' => $shop_id
        ])->get();
        return $query;
    }

    public static function getTableById($shop_id, $id){
        $query = table::select([
            'table.*',
            DB::raw('area.name as area_name')
        ]);

        $query->leftJoin('area', function($join){
            $join->on('table.area_id', '=', 'area.id');
        });

        $query = $query->where([
            'table.shop_id' => $shop_id,
            'table.id' => $id
        ])->first();
        return $query;
    }

    public static function getTableByAreaId($shop_id, $area_id){
        $query = table::select([
            'table.*',
            DB::raw('area.name as area_name')
        ]);

        $query->leftJoin('area', function($join){
            $join->on('table.area_id', '=', 'area.id');
        });

        $query = $query->where([
            'table.shop_id' => $shop_id,
            'table.area_id' => $area_id
        ])->get();
        return $query;
    }

    public static function countExistedTableName($name, $shop_id, $id = null){
        $count = table::where([
            'name' => $name,
            'shop_id' => $shop_id
        ]);
        if(!is_null($id)){
            $count = $count->where('id','<>', $id);
        }
        return $count->count();
    }

    public static function updateOrInsertTable($data, $id = null){
        if(isset($data['area_id'])){
            $count = area::where([
                'id' => $data['area_id'],
                'shop_id' => $data['shop_id']
                ])->count();
            if($count == 0){
                return 'messages.area_notfound';
            }
        }

        if(isset($data['name']) && table::countExistedTableName($data['name'], $data['shop_id'], $id) > 0){
            return 'messages.existed_data';
        }
        $query = table::updateOrInsert(['id' => $id], $data);
        if($query){
			return 'messages.success';
		}
		return 'messages.error';
    }

    public static function deleteTable($shop_id, $id){
        $query = table::where([
			'id' => $id,
			'shop_id' => $shop_id
		])->delete();
		
		if($query){
			return true;
		}
		return false;
    }

    public static function deleteTableByAreaId($shop_id, $area_id){
        $query = table::where([
            'area_id' => $area_id,
            'shop_id' => $shop_id
        ]);
        
        if($query->count() > 0){//when have table in area
            $query=$query->delete();
            if(!$query){
                return false;
            }
        }
		return true;
    }
}
