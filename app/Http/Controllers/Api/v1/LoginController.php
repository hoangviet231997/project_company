<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\Util;
use App\Models\facility;
use Illuminate\Http\Request;

use App\Models\account;
use App\Models\account_push;
use App\Models\role_permission;
use App\Models\asset;
use App\Models\shop;

class LoginController extends Controller {
    public function login(Request $request) {
        $shop_id = $request->input('shop_id');
        $account_agency_id = $request->input('account_agency_id');
		if(
		    ($request->input('user') && $request->input('pass')) ||
            ($shop_id && $account_agency_id)
        ){
			if($request->input('user') && $request->input('pass')) {
				$user = $request->input('user');
				$pass = $request->input('pass');
				$account = account::getAccount($user, sha1($pass));
			} else {
			    $account = account::getAccountAgencyByAccountId($shop_id, $account_agency_id);
            }
//			else {
//				$token = $_REQUEST['token'];
//				$account = account::getAccountByToken($token);
//			}

			if($account) {
				if($request->input('push_id') && $request->input('device_id')) {
					account_push::saveAccountPush(
						$account->id, $account->main_shopid, $request->input('push_id'),
						$request->input('device_id'), $request->input('device_type'), $request->input('build_version'),
						$request->input('device_name'), $request->input('os_version'), $request->input('app_type'),
						$request->input('langcode')
					);
				}

				$main_shop = $account['main_shop'];
				$main_account_shop = $account['main_account_shop'];

				$assets = asset::getAssetByShopId($main_shop->id);
				$roles = role_permission::getRolePermissionByShopId($main_shop->id);
				//$role_account = role_permission::getRolePermissionById($main_shop->id, $main_account_shop->role_permission_id);
                $role_account = role_permission::getRoleAccount($main_shop->id, $main_account_shop->role_permission_id);

                $facilitys = facility::getFacilityIdByShop($main_shop->id);
                $shop = shop::getShopDetailById($main_shop->id);
				$data = [
					'id' => $account->id,
					'token' => $main_account_shop->token,
					'shop_id' => $main_shop->id,
					'shop_name' => $main_shop->name,
					'shop_logo_image' => $shop->logo_image,
					'shop_type' => $shop->type,
					'username' => $account->username,
					'full_name' => $account->full_name,
					'phone' => $account->phone,
					'push_flg' => $account->push_flg,
					'role' => $account->role,
					'role_shop' => $account->role_shop,
                    'role_account' => $role_account,
					'chain_flg' => $account->is_chain,
					'expire_date' => $main_shop->expire_date,
					'login_count' => $account->login_count,
					'langcode' => $account->langcode,
					'format_currency' => $main_shop->format_currency,
					'table_type' => $main_shop->table_type,
					'assets' => $assets,
					'roles' => $roles,
                    'facilitys' => $facilitys,
                    'chains' => [],
                    'web_title' => $shop->web_title,
                    'sidebar_color' => $shop->sidebar_color,
                    'sidebar_text_color' => $shop->sidebar_text_color,
                    'sidebar_text_selected_color' => $shop->sidebar_text_selected_color,
				];

				return $this->respondSuccess($data);
			}
			else {
				return $this->respondError(__('messages.password_incorrect'));
			}
        }
        else {
        	return $this->respondMissingParam();
		}
    }

    /*public function getLayout(Request $request) {
    	$json = <<<EOD
{
"totalPage": 1,
"currentPage": 1,
      "layout": [
        {
            "type": "userBanner",
            "image": "https://i.imgur.com/MAz4DgB.png",
            "barcode": "BEAU00231",
            "imageBarcode": "https://i.imgur.com/HwPAFl0.png",
            "title": "Customer Name",
            "memberTier": "Thành viên mới"
        },
        {
            "type": "sliderBanner",
            "itemType": 1,
            "items": [
                {
                    "image": "https://i.imgur.com/Kh73tGU.png",
                    "url": "http://www.google.com.vn"
                },
                {
                    "image": "https://i.imgur.com/Kh73tGU.png",
                    "url": "http://www.google.com.vn"
                },
                {
                    "image": "https://i.imgur.com/Kh73tGU.png",
                    "url": "http://www.google.com.vn"
                }
            ]
        },
        {
            "type": "menu",
            "items": [
                {
                    "title": "Đặt lịch",
                    "moduleId": "store",
                    "image": "https://i.imgur.com/D7RrXYv.png",
                    "url": "https://sendo.vn",
                    "textColor": "0xFF57bab8"
                },
                {
                    "title": "Mua hàng",
                    "moduleId": "store",
                    "image": "https://i.imgur.com/iNXYEeH.png",
                    "url": "https://sendo.vn",
                    "textColor": "0xFFef7c72"
                },
                {
                    "title": "Ưu đãi",
                    "subtitle": "10",
                    "moduleId": "store",
                    "textColor": "0xFF57bab8",
                    "url": "https://sendo.vn",
                    "image": "https://i.imgur.com/EsrIOka.png"
                }
            ]
        },
        {
            "type": "itemList",
            "itemType": 1,
            "fontSize": 20,
            "column": 2,
            "title": "KHUYẾN MÃI",
            "listId": "list123",
            "loadMoreTitle": "Xem toàn bộ",
            "itemTitleColor": "0xFF1d1d26",
            "priceSize": 13,
            "salePriceSize": 16,
            "hasLoadMore": true,
            "priceColor": "0x801d1d26",
            "subtitleSize": 12,
            "salePriceColor": "0xFFef7c72",
            "items": [
                {
                    "title": "Product Name 1",
                    "price": 120000,
                    "image": "https://i.imgur.com/ATik6tf.png",
                    "url": "https://sendo.vn",
                    "salePrice": 80000
                },
                {
                    "title": "Product Name 2",
                    "price": 420000,
                    "image": "https://i.imgur.com/OCxBIq0.png",
                    "url": "https://sendo.vn",
                    "salePrice": 120000
                },
                {
                    "title": "Product Name 3",
                    "price": 120000,
                    "image": "https://i.imgur.com/P5vq277.png",
                    "url": "https://sendo.vn",
                    "salePrice": 80000
                },
                {
                    "title": "Product Name 4",
                    "price": 420000,
                    "image": "https://i.imgur.com/XcMCEFY.png",
                    "url": "https://sendo.vn",
                    "salePrice": 120000
                }
            ]
        }
    ]
}
EOD;
//		{
//			"type": "sliderBanner",
//            "itemType": 2,
//            "title": "BỘ SƯU TẬP MẪU TÓC",
//            "fontSize": 20,
//            "loadMoreTitle": "Xem toàn bộ",
//            "listId": "list123",
//            "hasLoadMore": true,
//            "itemTitleColor": "0xFF57bab8",
//            "itemTitleSize": 17,
//            "items": [
//                {
//					"image": "https://i.imgur.com/3nyTjN8.png",
//                    "title": "Hairstyles cutting Summer 2019 ",
//                    "url": "https://sendo.vn",
//                    "subtitle": "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod ..."
//                },
//                {
//					"image": "https://i.imgur.com/3nyTjN8.png",
//                    "title": "Hairstyles cutting Summer 2019 ",
//                    "url": "https://sendo.vn",
//                    "subtitle": "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod ..."
//                },
//                {
//					"image": "https://i.imgur.com/3nyTjN8.png",
//                    "title": "Hairstyles cutting Summer 2019 ",
//                    "url": "https://sendo.vn",
//                    "subtitle": "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod ..."
//                }
//            ]
//        },
//		{
//			"type": "itemList",
//            "itemType": 2,
//            "fontSize": 20,
//            "column": 1,
//            "title": "CHƯƠNG TRÌNH ĐÀO TẠO",
//            "loadMoreTitle": "Xem toàn bộ",
//            "itemTitleColor": "0xFF1d1d26",
//            "priceSize": 18,
//            "listId": "list123",
//            "itemTitleSize": 17,
//            "salePriceSize": 16,
//            "hasLoadMore": true,
//            "priceColor": "0x801d1d26",
//            "subtitleSize": 14,
//            "salePriceColor": "0xFFef7c72",
//            "items": [
//                {
//					"title": "Hair Cutting Professional",
//                    "subtitle": "Lorem ipsum dolor sit Lorem ipsum dolor",
//                    "price": 5200000,
//                    "isNew": true,
//                    "url": "https://sendo.vn",
//                    "image": "https://i.imgur.com/GLezK0N.png"
//                },
//                {
//					"title": "Make Up Professional",
//                    "subtitle": "Lorem ipsum dolor sit Lorem ipsum dolor Lorem ipsum dolor amet",
//                    "price": 11200000,
//                    "url": "https://sendo.vn",
//                    "image": "https://i.imgur.com/pHyBUdv.png"
//                },
//                {
//					"title": "Aroma Therapy",
//                    "subtitle": "Lorem ipsum dolor sit Lorem ipsum dolor Lorem ipsum dolor amet",
//                    "price": 7000000,
//                    "url": "https://sendo.vn",
//                    "image": "https://i.imgur.com/Wndh19Q.png"
//                }
//            ]
//        },
//		{
//			"type": "cardList",
//            "itemType": 1,
//            "fontSize": 20,
//            "hasLoadMore": false,
//            "listId": "list123",
//            "title": "Dành cho bạn",
//            "itemTitleColor": "0x801d1d26",
//            "itemTitleSize": 17,
//            "subtitleSize": 16,
//            "items": [
//                {
//					"title": "Chào tháng ba với Caramel Macchiato phiên bản mới",
//                    "image": "https://i.imgur.com/ATik6tf.png",
//                    "url": "https://sendo.vn",
//                    "textColor": "0xFF000000"
//                },
//                {
//					"title": "Chào tháng ba với Caramel Macchiato phiên bản mới",
//                    "image": "https://i.imgur.com/ATik6tf.png",
//                    "url": "https://sendo.vn",
//                    "textColor": "0xFF000000"
//                },
//                {
//					"title": "Chào tháng ba với Caramel Macchiato phiên bản mới",
//                    "image": "https://i.imgur.com/ATik6tf.png",
//                    "url": "https://sendo.vn",
//                    "textColor": "0xFF000000"
//                },
//                {
//					"title": "Chào tháng ba với Caramel Macchiato phiên bản mới",
//                    "image": "https://i.imgur.com/ATik6tf.png",
//                    "url": "https://sendo.vn",
//                    "textColor": "0xFF000000"
//                }
//            ]
//        },
//		{
//			"type": "cardList",
//            "itemType": 2,
//            "fontSize": 20,
//            "listId": "list123",
//            "hasLoadMore": false,
//            "title": "Dành cho bạn",
//            "itemTitleColor": "0x801d1d26",
//            "itemTitleSize": 17,
//            "subtitleSize": 14,
//            "items": [
//                {
//					"title": "Chanh sả đá xay, thử ngay chỉ 45k",
//                    "subtitle": "The cofffee  house gửi bạn ưu đãi đồng giá 45k/ly tất cả sản phẩm đá xay trong menu. Áp dụng khi nhập mã DAXAY trong đơn hàng giao hàng tận nơi từ 18-19/5",
//                    "image": "https://i.imgur.com/ATik6tf.png",
//                    "url": "https://sendo.vn",
//                    "textColor": "0xFF000000"
//                },
//                {
//					"title": "Chanh sả đá xay, thử ngay chỉ 45k",
//                    "subtitle": "The cofffee  house gửi bạn ưu đãi đồng giá 45k/ly tất cả sản phẩm đá xay trong menu. Áp dụng khi nhập mã DAXAY trong đơn hàng giao hàng tận nơi từ 18-19/5",
//                    "image": "https://i.imgur.com/ATik6tf.png",
//                    "url": "https://sendo.vn",
//                    "textColor": "0xFF000000"
//                },
//                {
//					"title": "Chanh sả đá xay, thử ngay chỉ 45k",
//                    "subtitle": "The cofffee  house gửi bạn ưu đãi đồng giá 45k/ly tất cả sản phẩm đá xay trong menu. Áp dụng khi nhập mã DAXAY trong đơn hàng giao hàng tận nơi từ 18-19/5",
//                    "image": "https://i.imgur.com/ATik6tf.png",
//                    "url": "https://sendo.vn",
//                    "textColor": "0xFF000000"
//                },
//                {
//					"title": "Chanh sả đá xay, thử ngay chỉ 45k",
//                    "subtitle": "The cofffee  house gửi bạn ưu đãi đồng giá 45k/ly tất cả sản phẩm đá xay trong menu. Áp dụng khi nhập mã DAXAY trong đơn hàng giao hàng tận nơi từ 18-19/5",
//                    "image": "https://i.imgur.com/ATik6tf.png",
//                    "url": "https://sendo.vn",
//                    "textColor": "0xFF000000"
//                }
//            ]
//        }
    	$json_arr = json_decode($json, true);

    	if($request->list_id) {
			foreach ($json_arr as $json_key => $json_val) {
				if($json_key == 'layout') {
					foreach ($json_val as $key => $val) {
						if(
							!array_key_exists('listId', $val) ||
							(array_key_exists('listId', $val) && $val['listId'] != $request->list_id)
						) {
							unset($json_val[$key]);
						}
					}
				}
			}
			$json_arr_new = [
				'totalPage' => '1',
				'currentPage' => '1',
				'layout' => array_values($json_val),
			];

			return $this->respondSuccess($json_arr_new);
		}

		return $this->respondSuccess($json_arr);
	}*/

	public function getLayout(Request $request) {
//		if(Util::getIp() == '14.161.35.94') {
//
//		}
//		else {
			$json = <<<EOD
{
"totalPage": 1,
"currentPage": 1,
      "layout": [
        {
            "type": "userBanner",
            "image": "https://i.imgur.com/MAz4DgB.png",
            "barcode": "BEAU00231",
            "imageBarcode": "https://i.imgur.com/HwPAFl0.png",
            "title": "Customer Name",
            "memberTier": "Thành viên mới"
        },
        {
            "type": "sliderBanner",
            "itemType": 1,
            "items": [
                {
                    "image": "https://i.imgur.com/Kh73tGU.png",
                    "url": "http://www.google.com.vn"
                },
                {
                    "image": "https://i.imgur.com/Kh73tGU.png",
                    "url": "http://www.google.com.vn"
                },
                {
                    "image": "https://i.imgur.com/Kh73tGU.png",
                    "url": "http://www.google.com.vn"
                }
            ]
        },
        {
            "type": "menu",
            "items": [
                {
                    "title": "Đặt lịch",
                    "moduleId": "store",
                    "image": "https://i.imgur.com/D7RrXYv.png",
                    "url": "https://sendo.vn",
                    "textColor": "0xFF57bab8"
                },
                {
                    "title": "Mua hàng",
                    "moduleId": "store",
                    "image": "https://i.imgur.com/iNXYEeH.png",
                    "url": "https://sendo.vn",
                    "textColor": "0xFFef7c72"
                },
                {
                    "title": "Ưu đãi",
                    "subtitle": "10",
                    "moduleId": "store",
                    "textColor": "0xFF57bab8",
                    "url": "https://sendo.vn",
                    "image": "https://i.imgur.com/EsrIOka.png"
                }
            ]
        },
        {
            "type": "itemList",
            "itemType": 1,
            "fontSize": 20,
            "column": 2,
            "title": "KHUYẾN MÃI",
            "listId": "list123",
            "loadMoreTitle": "Xem toàn bộ",
            "itemTitleColor": "0xFF1d1d26",
            "priceSize": 13,
            "salePriceSize": 16,
            "hasLoadMore": true,
            "priceColor": "0x801d1d26",
            "subtitleSize": 12,
            "salePriceColor": "0xFFef7c72",
            "items": [
                {
                    "title": "Product Name 1",
                    "price": 120000,
                    "image": "https://i.imgur.com/ATik6tf.png",
                    "url": "https://sendo.vn",
                    "salePrice": 80000
                },
                {
                    "title": "Product Name 2",
                    "price": 420000,
                    "image": "https://i.imgur.com/OCxBIq0.png",
                    "url": "https://sendo.vn",
                    "salePrice": 120000
                },
                {
                    "title": "Product Name 3",
                    "price": 120000,
                    "image": "https://i.imgur.com/P5vq277.png",
                    "url": "https://sendo.vn",
                    "salePrice": 80000
                },
                {
                    "title": "Product Name 4",
                    "price": 420000,
                    "image": "https://i.imgur.com/XcMCEFY.png",
                    "url": "https://sendo.vn",
                    "salePrice": 120000
                }
            ]
        }
    ]
}
EOD;

			$json_arr = json_decode($json, true);

			if($request->list_id) {
				foreach ($json_arr as $json_key => $json_val) {
					if($json_key == 'layout') {
						foreach ($json_val as $key => $val) {
							if(
								!array_key_exists('listId', $val) ||
								(array_key_exists('listId', $val) && $val['listId'] != $request->list_id)
							) {
								unset($json_val[$key]);
							}
						}
					}
				}
				$json_arr_new = [
					'totalPage' => '1',
					'currentPage' => '1',
					'layout' => array_values($json_val),
				];

				return $this->respondSuccess($json_arr_new);
			}

			return $this->respondSuccess($json_arr);
//		}
	}
}
