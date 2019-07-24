<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class app_shop extends Model
{
    protected $table = 'app_shop';

    public function product_category()
    {
        return $this->hasMany(product_category::class, 'shop_id', 'shop_id');
    }

    public function product(){
        return $this->hasMany(product::class, 'shop_id', 'shop_id');
    }

    public static function getListCategory($access_token){
        $app_identify_id = app_identify::where([
            'access_token' => $access_token,
        ]);
        if($app_identify_id->count() > 0){
            
            $app_identify_id = $app_identify_id->first()->id;

            $query = app_shop::where([
                'app_identify_id' => $app_identify_id
            ])->get();
            
            $response = [];
            foreach ($query as $item){
//                $data = [
//                	'shop_id' => $item->shop_id,
//					'categories' => product_category::getListCategory($item->shop_id, null, null, null)
//				];
				$response = product_category::getListCategory($item->shop_id, null, null, null);
            }
            return $response;
        }
    }

    public static function getListProduct($access_token, $page, $category_id = null, $product_type = null) {
        $app_identify_id = app_identify::where([
            'access_token' => $access_token,
        ]);
        if($app_identify_id->count() > 0){
            
            $app_identify_id = $app_identify_id->first()->id;

            $query = app_shop::where([
                'app_identify_id' => $app_identify_id
            ])->get();
            
            $response = [];
            foreach ($query as $item){
//				$data = [
//					'shop_id' => $item->shop_id,
//					'products' => product::getListProduct($item->shop_id, $page, null, null, null)
//				];
				$response = product::getListProduct($item->shop_id, $page, null, $category_id, null, $product_type);
            }

            return $response;
        }
    }
}
