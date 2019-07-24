<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Lang;

class feature_master extends Model
{
    protected $table = 'feature_master';
    protected $fillable = [
        'name',
        'shop_id',
        'type',
        'invalid'
    ];
    public $timestamps = false;

    public function rules(Request $request)
    {
        return [
            "name" => 'required|max:255'
        ];
    }

    public function messages()
    {
        return Lang::get('validation');
    }

    public function findById($id) {
        return $this->where('id',$id)
        ->where('shop_id',1)
        ->where('invalid',0)
        ->first();
    }

    public static function findByName($name, $shop_id){
        return feature_master::where('name', 'like', $name)
        ->where('shop_id',$shop_id)
        ->where('invalid',0)
        ->first();
    }

    public function invalidById($id) {
        return $this->find($id)->update(['invalid' => 1]);
    }

    public static function getListFeature($shop_id) {
		$query = feature_master::where(['shop_id' => $shop_id, 'invalid' => 0])->get();
		return $query->makeHidden('invalid');
	}

    public static function getFeatureById($id, $shop_id){
        return feature_master::where([
            'id' => $id,
            'shop_id' => $shop_id
        ])
        ->where('invalid', 0)
        ->first();
    }

    public static function updateOrInsertFeature($data, $id = null){
        // if $query = 1 is success, 0 is fail, -1 is exist data
        if(!feature_master::findByName($data['name'], $data['shop_id'])){
            $query = feature_master::updateOrInsert(['id' => $id], $data);
            if($query){
                return 'messages.success';
            }
            else{
                return 'messages.error';
            }
        }
        else{
            return 'messages.existed_data';
        }
        
    }

    public static function deleteFeature($id, $shop_id){
        $delete = feature_master::where([
            'id' => $id,
            'shop_id' => $shop_id,
            'invalid' => 0
        ])
        ->update(['invalid' => 1]);
        return $delete;
    }
}