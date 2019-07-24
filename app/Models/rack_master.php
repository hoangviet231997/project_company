<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Lang;

class rack_master extends Model
{
    protected $table = 'rack_master';
    protected $fillable = ['rack_name','shop_id','invalid'];
    public $timestamps = false;

    public function rules(Request $request)
    {
        return [
            "rack_name" => 'required|max:255'
        ];
    }

    public function messages()
    {
        return Lang::get('validation');
    }

    public function invalidById($id) {
        return $this->find($id)->update(['invalid' => 1]);
    }

    public static function getListRack($shop_id) {
		$query = rack_master::where(['shop_id' => $shop_id, 'invalid' => 0])->get();
		return $query->makeHidden('invalid');
	}

    public static function getRackById($id, $shop_id){
        return rack_master::where([
            'id' => $id,
            'shop_id' => $shop_id
        ])
        ->where('invalid', 0)
        ->first()->makeHidden('invalid');
    }

    public static function updateOrInsertRack($data, $id = null){
        // if $query = 1 is success, 0 is fail, -1 is exist data
        $query = null;
        if(!is_null($id)){
            $query = rack_master::updateOrInsert(['id' => $id], $data);
            if(!$query){
                return false;
            }
            return true;
        }
        else{
            $id = rack_master::insertGetId($data);
            if(!$id){
                return false;
            }
            $response = rack_master::where('id', $id)->get()->makeHidden('invalid');
            return $response;
        }
        // if($query){
        //     return 'messages.success';
        // }
        // else{
        //     return 'messages.error';
        // }
    }

    public static function deleteRack($id, $shop_id){
        $delete = rack_master::where([
            'id' => $id,
            'shop_id' => $shop_id,
            'invalid' => 0
        ])
        ->update(['invalid' => 1]);
        return $delete;
    }
}
