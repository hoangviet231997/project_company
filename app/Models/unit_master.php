<?php

namespace App\Models;

use App\Helper\Constant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Lang;

class unit_master extends Model
{
    protected $table = 'unit_master';
    protected $fillable = [
        'id', 
        'shop_id',
        'unitname',
        'invalid'
    ];
    public $timestamps = false;

    public function rules(Request $request)
    {
        return [
            "unitname" => 'required|max:255'
        ];
    }

    public function messages()
    {
        return Lang::get('validation');
    }

    public function findById($id) {
        return $this->where('id',$id)
        ->where('invalid',0)
        ->where('shop_id',1)
        ->first();
    }

    public static function findByName($unitname, $shop_id = null){
        $query = unit_master::where('unitname', 'like', $unitname)->where('invalid', 0);

        if(!is_null($shop_id)) {
			$query = $query->where('shop_id', $shop_id);
		}

        return $query->first();
    }

    public function filter($filter){
    }

    public function invalidById($id) {
        return $this->find($id)->update(['invalid' => 1]);
    }

    public static function getListUnit($shop_id, $type = null) {
		$query = unit_master::where(['shop_id' => $shop_id, 'invalid' => 0]);

		if(!is_null($type)) {
			$query = $query->whereIn('unit_type', [Constant::UNIT_TYPE_ALL, $type]);
		}

		$query = $query->get();

		return $query->makeHidden('invalid');
	}

    public static function getUnitById($id, $shop_id){
        return unit_master::where([
            'id' => $id,
            'shop_id' => $shop_id
        ])
        ->where('invalid', 0)
        ->first();
    }

    public static function updateOrInsertUnitMaster($data, $id = null){
        if(!unit_master::findByName($data['unitname'], $data['shop_id'])){
            
            if(is_null($id)) {
                $id = unit_master::insertGetId($data);
                if(!$id) {
                    return 'messages.error';
                }
            }
            else {
                $query = unit_master::updateOrInsert([ 'id' => $id ], $data);
                if(!$query) {
                    return 'messages.error';
                }
            }
            return unit_master::getUnitById($id, $data['shop_id']);
        }   
        else{
            return 'messages.existed_data';
        }
    }

    public static function deleteUnitMaster($id, $shop_id){
        $query = unit_master::where([
                    'id' => $id,
                    'shop_id' => $shop_id,
                    'invalid' => 0
                ])->update(['invalid' => 1]);
        return $query;
    }

    public static function checkExitAndCreateUnitMaster($shop_id, $unit_name) {
        $unit = unit_master::where(['unitname' => $unit_name, 'shop_id' => $shop_id])->first();
        if(!$unit) {
            $unit = new unit_master();
            $unit->shop_id = $shop_id;
            $unit->unitname = $unit_name;
            $unit->invalid = 0;
            $unit->save();
            return $unit->id;
        }

        return $unit->id;
    }
}
