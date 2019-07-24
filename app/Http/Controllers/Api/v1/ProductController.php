<?php

namespace App\Http\Controllers\Api\v1;

use App\Console\Commands\ImportProductExcel;
use App\Helper\Constant;
use App\Imports\ProductsImport;
use App\inventory_master;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Excel;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Validator;
// use Request;
use Exception;
use DB;
use App\Helpers\Util;
use App\Models\product_master;
use App\Models\product;
use App\Models\product_unit;
use App\Models\product_feature;
use App\Models\product_extend;
use App\Exceptions\APIException;
use Illuminate\Http\Request;
use Session;

class ProductController extends Controller{
	public function getListProduct(Request $request) {
    	$page = $request->page;
		$shop_id = $request->input('shop_id');
		$data = product::getListProduct($shop_id, $page, $request->product_name, $request->product_category_id, $request->available, $request->product_type);
		return $this->respondSuccess($data);
    }

    public function getListProductUnitBatch(Request $request) {
        $page = $request->page;
        $shop_id = $request->shop_id;
        $product_name = $request->product_name;
        $product_category = $request->product_category_id;
        $available = $request->available;
        if(!$page) {
            return $this->respondMissingParam();
        }
        $data = product::getListProductImExportInventory($shop_id, $page, $product_name, $product_category, $available);
        if(count($data) == 0) {
            return $this->respondNotFound();
        }
        return $this->respondSuccess($data);
    }

    public function getProductDetail(Request $request){
        if($request->input('shop_id') && $request->input('product_id')) {
            $product = new product();
            $data = $product->getProductDetail($request->input('shop_id'),$request->input('product_id'));
            if(count($data) == 0) {
                return $this->respondNotFound();
            }
            return $this->respondSuccess($data);
        }
        else {
            return $this->respondMissingParam();
        }
    }

    public function deleteProductById(Request $request) {
    	if($request->product_id) {
    		$query = product::deleteProductById($request->product_id);
			if($query){
				return $this->respondSuccess();
			}
    		return $this->respondError();
		}
		else {
			return $this->respondMissingParam();
		}
	}

    public function getListInventory(Request $request){
		$data = product::getListInventory($request);

		return $this->respondSuccess($data);
    }

    public function getListProductExtend(Request $request){
        if($request->input('shop_id')) {
            $shop_id = $request->input('shop_id');
            $data = product_extend::getListProductExtend($shop_id);
            if(count($data) == 0) {
                return $this->respondNotFound();
            }
            return $this->respondSuccess($data);
        }
        else {
            return $this->respondMissingParam();
        }
    }

    public function getListProductMaster(Request $request){
        if($request->input('shop_id')) {
            $shop_id = $request->input('shop_id');
            $data = product_master::getListProductMaster($shop_id);

            return $this->respondSuccess($data);
        }
        else {
            return $this->respondMissingParam();
        }
    }

    public function getProductUnit(Request $request){
        if($request->input('shop_id')) {
            $shop_id = $request->input('shop_id');
            $product_ids = $request->input('product_ids');
            $data = product_unit::getProductUnit($shop_id, $product_ids);
            return $this->respondSuccess($data);
        }
        else {
            return $this->respondMissingParam();
        }
    }

    public function getListUnitByProductMaster(Request $request) {
        $product_master = $request->input('product_master_id');
        $shop_id = $request->input('shop_id');
        if($product_master && $shop_id) {
            $data = product_unit::getListProductUnitByProductMaster($product_master, $shop_id);
            if(count($data) == 0) {
                return $this->respondNotFound();
            }
            return $this->respondSuccess($data);
        }
        else {
            return $this->respondMissingParam();
        }

    }

    public function getListProductExtendByShopid(Request $request) {
        $product_id = $request->input('product_id');
		$shop_id = $request->input('shop_id');
		
		$product_ids = $request->input('product_ids');
        if(($product_id || $product_ids) && $shop_id) {
            $data = product_extend::getListProductExtendByShopid($product_id, $shop_id, $product_ids);
            return $this->respondSuccess($data);
        }
        else {
            return $this->respondMissingParam();
        }
    }

    public function getListProductInInventory(Request $request) {
        $shop_id = $request->input('shop_id');
        $search_code = $request->input('search_code');
        $limit = $request->input('limit') ? $request->input('limit') : Constant::LIMIT_PAGINATION;
        $products = inventory_master::getListProductInInventory($shop_id, $search_code, $limit);
        if($products) {
            return $this->respondSuccess($products, __('messages.success'));
        }
        else {
            return $this->respondNotFound();
        }
    }

	public function newProduct(Request $request) {
		$result = DB::transaction(function () use ($request) {
			$req = Input::all();
			$shop_id = $request->shop_id;
			$req['shop_id'] = $shop_id;
			$req['nameSortproduct'] = Util::vnToStr($req['product_name']);
			$req['product_type'] = isset($req['product_type']) ? intval($req['product_type']) : Constant::PRODUCT_TYPE_GOODS;

			//combo
			if(isset($req['elememt_list']) && count($req['elememt_list']) > 0) {
				if($req['elememt_type'] == 0) {
					$req['combo'] = json_encode($req['elememt_list'], true);
				} else if($req['elememt_type'] == 1) {
					$req['product_material'] = json_encode($req['elememt_list'], true);
				}
			}

			// start upload image
			$product_upload_path = Util::getUploadPath('product');
			$name_of = [
				'image1' => '',
				'image2' => '',
				'image3' => '',
				'image4' => ''
			];
			if(isset($req["product_thumbnail1"])) {
				if($image_extension = $req['product_thumbnail1']->getClientOriginalExtension()) {
					
					$image_name = Util::getUploadFileName($image_extension);
					$req["product_thumbnail1"] = Util::uploadImage($req["product_thumbnail1"], $product_upload_path, $image_name, 'product');

					$name_of['image1'] = $image_name; 
				}
				else {
					$req["product_thumbnail1"] = null;
				}
			}

			if(isset($req["product_thumbnail2"])) {
				if($image_extension = $req['product_thumbnail2']->getClientOriginalExtension()) {
					$image_name = Util::getUploadFileName($image_extension);
					$req["product_thumbnail2"] = Util::uploadImage($req["product_thumbnail2"], $product_upload_path, $image_name, 'product');

					$name_of['image2'] = $image_name; 
				}
				else {
					$req["product_thumbnail2"] = null;
				}
			}

			if(isset($req["product_thumbnail3"])) {
				if($image_extension = $req['product_thumbnail3']->getClientOriginalExtension()) {
					$image_name = Util::getUploadFileName($image_extension);
					$req["product_thumbnail3"] = Util::uploadImage($req["product_thumbnail3"], $product_upload_path, $image_name, 'product');//

					$name_of['image3'] = $image_name; 
				}
				else {
					$req["product_thumbnail3"] = null;
				}
			}

			if(isset($req["product_thumbnail4"])) {
				if($image_extension = $req['product_thumbnail4']->getClientOriginalExtension()) {
					$image_name = Util::getUploadFileName($image_extension);
					$req["product_thumbnail4"] = Util::uploadImage($req["product_thumbnail4"], $product_upload_path, $image_name, 'product');

					$name_of['image4'] = $image_name; 
				}
				else {
					$req["product_thumbnail4"] = null;
				}
			}
			// end upload image

			$product_master = product_master::create($req);

			if(isset($req["unit_list"]) && $product_master) {
				try {
					$unit_list = $req["unit_list"];
					foreach ($unit_list as $key => $value) {
						$value["shop_id"] = $shop_id;
						$value["product_master_id"] = $product_master->product_master_id;
						$value['regdate'] = Util::getNow();
						product_unit::create($value);

						$product_master['list_units'] = product_unit::getListProductUnitByProductMaster($product_master->product_master_id, $shop_id);
					}

					if(!isset($req["product_list"]) || (isset($req["product_list"]) && count($req["product_list"]) == 0)) {
						$product_req = $req;
						$product_req['owner_shop_id'] = $shop_id;
						$product_req['product_master_id'] = $product_master->product_master_id;
						$product_req['unit_id'] = $product_master->primary_unit_id;
						$product_req['unit_name'] = $product_master->primary_unit_name;
						$product_req['product_type'] = $product_master->product_type;
						$product_req['product_unit_type'] = $product_master->product_unit_type;
						$product_req['combo'] = $product_master->combo;
						$product_req['product_material'] = $product_master->product_material;
						product::create($product_req);
					}
					//tmp not use
					else if(!$req["batch_flg"] && isset($req["product_list"])) {
						$product_list = $req["product_list"];
						foreach ($product_list as $key => $value) {
							$product = $req;
							$product["shop_id"] = $shop_id;
							$product["product_master_id"] = $product_master->product_master_id;
							$product["product_master_code"] = $product_master->product_code;
							$product["product_name"] = $product["product_name"].'-'.$value["product_name"];
							$product["product_code"] = $value["product_code"];
							$product["product_price"] = $value["product_price"];
							$product["unit_id"] = $product_master->primary_unit_id;
							$product["unit_name"] = $product_master->primary_unit_name;
							$product["place_tag"] = $product_master->place_tag;
							$product["alert_flg"] = $value["alert_flg"];
							$product["nameSortproduct"] = Util::vnToStr($value["product_name"]);
							$product["invalid"] = $value["invalid"];
							$product = product::create($product);
							if($product) {
								foreach ($value["feature"] as $key => $feature) {
									$feature["shop_id"] = $shop_id;
									$feature["product_id"] = $product->product_id;
									product_feature::create($feature);
								}
							}
						}
					}
					$product_master['image1'] = Util::getUrlFile($name_of['image1'], 'product');
					$product_master['image2'] = Util::getUrlFile($name_of['image2'], 'product');
					$product_master['image3'] = Util::getUrlFile($name_of['image3'], 'product');
					$product_master['image4'] = Util::getUrlFile($name_of['image4'], 'product');

					$product_master['list_products'] = product::getProductDetailByProductMasterId($product_master->product_master_id)->makeHidden('invalid');
					return $product_master;
				}
				catch (Exception $e) {
					return $e->getMessage();
				}
			}
		});

		if(is_object($result)) {
			return $this->respondSuccess($result);
		}
		else {
			return $this->respondError($result);
		}
	}

	public function updateProduct(Request $request) {
		$result = DB::transaction(function () use ($request) {
			$req = Input::all();
			$id = $req['id'];
			$shop_id = $req['shop_id'];
			$req['nameSortproduct'] = Util::vnToStr($req['product_name']);
			$req['product_type'] = isset($req['product_type']) ? intval($req['product_type']) : Constant::PRODUCT_TYPE_GOODS;
			$name_of = [
				'image1' => '',
				'image2' => '',
				'image3' => '',
				'image4' => ''
			];
			//combo
			if(isset($req["elememt_list"]) && count($req["elememt_list"]) > 0) {
				if($req["elememt_type"] == 0) {
					$req["combo"] = json_encode($req["elememt_list"], true);
					$req["product_material"] = null;
				} else if($req["elememt_type"] == 1) {
					$req["product_material"] = json_encode($req["elememt_list"], true);
					$req["combo"] = null;
				}
			}
			else {
				$req["combo"] = $req["product_material"] = null;
			}

			// start upload image
			$product_upload_path = Util::getUploadPath('product');

			if(isset($req["product_thumbnail1"])) {
				if($req['product_thumbnail1'] != '-1'){//-1 when remove this thumbnail
					if(!is_string($req['product_thumbnail1']) && $image_extension = $req['product_thumbnail1']->getClientOriginalExtension()) {
						$image_name = Util::getUploadFileName($image_extension);
						$req["product_thumbnail1"] = Util::uploadImage($req["product_thumbnail1"], $product_upload_path, $image_name, 'product');
						$name_of['image1'] = $image_name;
					}
				}
			}

			if(isset($req["product_thumbnail2"])) {
				if($req['product_thumbnail2'] != '-1'){//-1 when remove this thumbnail
					if(!is_string($req['product_thumbnail2']) && $image_extension = $req['product_thumbnail2']->getClientOriginalExtension()) {
						$image_name = Util::getUploadFileName($image_extension);
						$req["product_thumbnail2"] = Util::uploadImage($req["product_thumbnail2"], $product_upload_path, $image_name, 'product');
						$name_of['image2'] = $image_name;
					}
				}
			}

			if(isset($req["product_thumbnail3"])) {
				if($req['product_thumbnail3'] != '-1'){//-1 when remove this thumbnail
					if(!is_string($req['product_thumbnail3']) && $image_extension = $req['product_thumbnail3']->getClientOriginalExtension()) {
						$image_name = Util::getUploadFileName($image_extension);
						$req["product_thumbnail3"] = Util::uploadImage($req["product_thumbnail3"], $product_upload_path, $image_name, 'product');
						$name_of['image3'] = $image_name;
					}
				}
			}

			if(isset($req["product_thumbnail4"])) {
				if($req['product_thumbnail4'] != '-1'){//-1 when remove this thumbnail
					if(!is_string($req['product_thumbnail4']) && $image_extension = $req['product_thumbnail4']->getClientOriginalExtension()) {
						$image_name = Util::getUploadFileName($image_extension);
						$req["product_thumbnail4"] = Util::uploadImage($req["product_thumbnail4"], $product_upload_path, $image_name, 'product');
						$name_of['image4'] = $image_name;
					}
				}
			}
			// end upload image

			$product_master = new product_master();

			$product_master = $product_master->findById($id);
			
			if(!$product_master) {
				return __('messages.canNotFoundResource');
			}

			for($i = 1; $i <= 4; $i++){
				if(isset($req['product_thumbnail'.$i])){
					if($req['product_thumbnail'.$i] != '-1'){
						$req["product_thumbnail".$i] = $req["product_thumbnail".$i] ?? $product_master['product_thumbnail'.$i];
					}
					else{
						$req["product_thumbnail".$i] = null;
					}
				}
				else{
					$req["product_thumbnail".$i] = $product_master['product_thumbnail'.$i];
				}
			}
			
			if(!$product_master->update($req)) {
				return __('messages.canNotFoundResource');
			}
		

			if(isset($req["unit_list"])) {
				try {
					$unit_list = $req["unit_list"];
					foreach ($unit_list as $key => $value) {
						if(isset($value["id"]) && $value["id"] != "") {
							$product_unit = new product_unit();
							$product_unit = $product_unit->findById($value["id"]);
							if($product_unit) {
								$product_unit->update($value);
							}
						} else {
							$value["shop_id"] = $shop_id;
							$value["product_master_id"] = $id;
							$value['regdate'] = Util::getNow();
							product_unit::create($value);
						}
						$product_master['list_units'] = product_unit::getListProductUnitByProductMaster($id, $shop_id);
					}

					$product_req = [
						'available' => $product_master->available,
						'info1' => $product_master->info1,
						'info2' => $product_master->info2,
						'info3' => $product_master->info3,
						'info4' => $product_master->info4,
						'info5' => $product_master->info5,
						'info6' => $product_master->info6,
						'online_sell_flg' => $product_master->online_sell_flg,
						'point_get_flg' => $product_master->point_get_flg,
						'unit_id' => $product_master->primary_unit_id,
						'unit_name' => $product_master->primary_unit_name,
						'product_barcode' => $product_master->product_barcode,
						'product_category_id' => $product_master->product_category_id,
						'product_code' => $product_master->product_code,
						'product_name' => $product_master->product_name,
						'product_price' => $product_master->product_price,
						'product_tax' => $product_master->product_tax,
						'receiptflg' => $product_master->receiptflg,
						'short_name' => $product_master->short_name,
						'product_type' => $product_master->product_type,
						'product_unit_type' => $product_master->product_unit_type,
						'place_tag' => $product_master->place_tag,
						'supplier_id' => $product_master->supplier_id,
						'supplier_name' => $product_master->supplier_name,
						'combo' => $product_master->combo,
						'product_material' => $product_master->product_material,
					];

					product::updateProductByProductMasterId($product_master->product_master_id, $req['shop_id'], $product_req);
					$product_master['list_units'] = product_unit::getListProductUnitByProductMaster($id, $shop_id);
					$product_master['list_products'] = product::getProductDetailByProductMasterId($product_master->product_master_id)->makeHidden('invalid');
//					if(!$req["batch_flg"]) {
//						$product_list = $req["product_list"];
//						foreach ($product_list as $key => $value) {
//							if(isset($value["product_id"])) {
//								$product = new product();
//								$product = $product->findById($value["product_id"]);
//								if($product) {
//									$product->update($value);
//								}
//							} else {
//								$product = $req;
//								$product["shop_id"] = $shop_id;
//								$product["product_master_id"] = $product_master->product_master_id;
//								$product["product_master_code"] = $product_master->product_code;
//								$product["product_name"] = $product["product_name"].'-'.$value["product_name"];
//								$product["product_code"] = $value["product_code"];
//								$product["product_price"] = $value["product_price"];
//								$product["unit_id"] = $product_master->primary_unit_id;
//								$product["unit_name"] = $product_master->primary_unit_name;
//								$product["alert_flg"] = $value["alert_flg"];
//								$product["nameSortproduct"] = Util::vnToStr($value["product_name"]);
//								$product["invalid"] = $value["invalid"];
//								$product = product::create($product);
//								if($product) {
//									foreach ($value["feature"] as $key => $feature) {
//										$feature["shop_id"] = $shop_id;
//										$feature["product_id"] = $product->product_id;
//										product_feature::create($feature);
//									}
//								}
//							}
//						}
//					}
					for($i = 1; $i <= 4 ; $i++){
						$key_name = 'image'.$i;
						if($name_of[$key_name] != ''){
							$product_master[$key_name] = Util::getUrlFile($name_of[$key_name], 'product');
						}
						else{
							$product_master[$key_name] = Util::getUrlFile($product_master['product_thumbnail'.$i], 'product');
						}
					}
					return $product_master;
				}
				catch (Exception $e) {
					return $e->getMessage();
				}
			}
		});

		if(is_object($result)) {
			return $this->respondSuccess($result);
		}
		else {
			return $this->respondError($result);
		}
	}

    public function exportProductExcel(Request $request) {
        $shop_id = $request->input('shop_id');
        if(!$request->file('product_import')) {
            return $this->respondMissingParam();
        }
        $request->file('product_import')->move(storage_path('import_excel_transaction'), $shop_id.'_product.xls');
        $data_product = (new ProductsImport)->toArray($shop_id.'_product.xls', 'import_excel_transaction');
        $data = product::exportProductExcelTransaction($data_product);
        return $this->respondSuccess($data);
    }
}
