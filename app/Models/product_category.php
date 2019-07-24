<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Lang;

class product_category extends Model
{
    protected $table = 'product_category';
    protected $primaryKey = 'category_id';
    protected $fillable = [
        'shop_id',
        'category_name',
        'category_group',
        'status',
        'category_desc'
    ];
    public $timestamps = false;

    public function rules(Request $request)
    {
        return [
            "category_name" => 'required|max:200',
            "category_group" => 'required|between:1,2,3',
            "status" => 'boolean',
            "category_desc" => 'max:500'
        ];
    }

    public function messages()
    {
        return Lang::get('validation');
    }

    public function findById($id) {
        return $this->select(
            'category_id',
            'category_name',
            'category_group',
            'status',
            'category_desc')
            ->where('category_id',$id)
            ->where('invalid',0) // Check deleted
            ->first();
    }

    public static function findByName($category_name){
        return product_category::select(
            'category_id',
            'category_name',
            'category_group',
            'status',
            'category_desc')
            ->where('category_name','like', $category_name)
            ->where('invalid',0) // Check deleted
            ->first();
    }

    public function invalidById($id) {
        return $this->where('category_id',$id)->update(['invalid' => 1]);
    }

    public static function getListCategory($shop_id, $category_name, $category_group, $status) {
        $query = product_category::where(['shop_id' => $shop_id, 'invalid' => 0]);

        if(!is_null($category_name)) {
        	$query->where('category_name', 'like', "%$category_name%");
		}

		if(!is_null($category_group)) {
			$query->where('category_group', $category_group);
		}

		if(!is_null($status)) {
			$query->where('status', $status);
		}

        $query = $query->get();
        return $query->makeHidden('invalid');
    }

    public static function getCategoryById($category_id, $shop_id){
        return product_category::where([
            'category_id' => $category_id,
            'shop_id' => $shop_id
        ])
        ->where('invalid', 0)
        ->first();
    }

    public static function countExistedCategoryName($category_name, $shop_id, $category_id){
        $count = product_category::where([
            'category_name' => $category_name,
            'shop_id' => $shop_id,
            'invalid' => 0
        ]);
        if(!is_null($category_id)){
            $count = $count->where('category_id','<>', $category_id);
        }
        return $count->count();
    }

    public static function updateOrInsertCategory($data, $category_id = null){
        // if $query = 1 is success, 0 is fail, -1 is exist data
        if(!is_null($category_id == null)){
            if(isset($data['category_name']) && product_category::countExistedCategoryName($data['category_name'], $data['shop_id'], $category_id) > 0){
                return 'messages.existed_data';
            }
        }
        if(is_null($category_id)){
            $insert_id = product_category::insertGetId($data);
            if(!$insert_id){
                return 'messages.error';
            }
            $query = product_category::where('category_id', $insert_id)->get()->makeHidden('invalid');
            return $query;
        }
        else{
            $query = product_category::updateOrInsert(['category_id' => $category_id], $data);
            if($query){
                return 'messages.success';
            }
            else{
                return 'messages.error';
            }
        }
    }

    public static function deleteCategory($category_id, $shop_id){
        $delete = product_category::where([
            'category_id' => $category_id,
            'shop_id' => $shop_id,
            'invalid' => 0
        ])
        ->update(['invalid' => 1]);
        if($delete){
			return true;
		}
		return false;
    }
    public static function getListCategoryProduct($shop_id, $product_type) {
        $cates = product_category::where(['shop_id' => $shop_id, 'invalid' => 0])->get();
        foreach($cates as $cate){
            $query = product::select(
                DB::raw('product.*'),
                DB::raw('product_master.product_thumbnail1'),
                DB::raw('product_master.product_thumbnail2'),
                DB::raw('product_master.product_thumbnail3'),
                DB::raw('product_master.product_thumbnail4')
            );

            $query->leftJoin('product_master', 'product.product_master_id', 'product_master.product_master_id');
            $query->where(['product.shop_id' => $shop_id, 'product.invalid' => 0]);

            if(!is_null($product_type)) {
                $query->where('product.product_type', $product_type);
            }

            $list_products = $query->where('product.product_category_id', $cate->category_id)->get();
            $data[]=[
                'category_id'=>$cate->category_id,
                'category_name'=>$cate->category_name,
                'category_group'=>$cate->category_group,
                'status'=>$cate->status,
                'category_desc'=>$cate->category_desc,
                'products'=> $list_products
            ];
        }
        return $data;

    }
}
