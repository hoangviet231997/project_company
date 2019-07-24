<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
// use Request;
use App\Models\product_category;
use App\Helpers\Util;

use Session;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller {
	public function getListCategory(Request $request){
		$data = product_category::getListCategory($request->shop_id, $request->category_name, $request->category_group, $request->status);

		return $this->respondSuccess($data);
    }
    public function getListCategoryProduct(Request $request) {
		$data = product_category::getListCategoryProduct($request->shop_id, $request->product_type);
		return $this->respondSuccess($data);
    }
    public function getCategoryDetail(Request $request){

        $data = product_category::getCategoryById($request->category_id, $request->shop_id);

        return $this->respondSuccess($data);
    }

    public function insertCategory(Request $request){
        if($request['category_name']){

            $request['last_update'] = Util::getNow();
            $data = $request->except(['token', 'category_id']);
            $query = product_category::updateOrInsertCategory($data);
            if(is_string($query)){
                return $this->respondError(__($query));
            }
            else{
                return $this->respondSuccess($query);
            }
        }
        else{
            return $this->respondMissingParam();
        }
    }

    public function updateCategory(Request $request){
        if($request['category_id']){
            $category_id = $request['category_id'];

            $request['last_update'] = Util::getNow();
            $data = $request->except(['token', 'category_id']);
            $query = product_category::updateOrInsertCategory($data, $category_id);

            if($query == 'messages.success'){
                return $this->respondSuccess();
            }
            else{
                return $this->respondError(__($query));
            }
        }
        else{
            return $this->respondMissingParam();
        }
    }

    public function deleteCategory(Request $request){
        $category_id = $request['category_id'];
        $shop_id = $request['shop_id'];
        if($category_id){
            $delete = product_category::deleteCategory($category_id, $shop_id);
            if($delete){
                return $this->respondSuccess();
            }
            else{
                return $this->respondError();
            }
        }
        else{
            return $this->respondMissingParam();
        }
    }
}
