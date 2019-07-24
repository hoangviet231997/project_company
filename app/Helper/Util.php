<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

use App\Helper\Constant;
use App\Models\shop_order_statistic;
use App\Models\transaction;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgotPassword;

class Util
{
    public static function vnToStr($str){
        $unicode = array(
            'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd'=>'đ',
            'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i'=>'í|ì|ỉ|ĩ|ị',
            'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
            'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'D'=>'Đ',
            'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
            'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        );
        foreach($unicode as $non =>$uni){
            $str = preg_replace("/($uni)/i", $non, $str);
        }
        $str = str_replace(' ','_',$str);
        return $str;
    }

	public static function injectUserName($user_name) {
		return str_replace(' ', '', strtolower($user_name));
	}

	public static function getToken($length = 20) {
		return substr(md5(date('Y-m-d H:i:s').microtime()), 0, $length);
	}

	public static function getAccessToken($length = 64) {
		return substr(md5(date('Y-m-d H:i:s').microtime()).md5(date('Y-m-d H:i:s').microtime()), 0, $length);
	}

	//ESMS
	// public static function sendSMS($phone_receive, $content){
	// 	$API_key = "F1990A85C846F9209772AF3CC185B2";
	// 	$secret_key = "703C947FE42034C163452021F57773";
	// 	$send_content = urlencode($content);
	// 	$data="http://rest.esms.vn/MainService.svc/json/SendMultipleMessage_V4_get?Phone=$phone_receive&ApiKey=$API_key&SecretKey=$secret_key&Content=$send_content&Brandname=QCAO_ONLINE&SmsType=2";
	// 	$curl = curl_init($data); 
	// 	curl_setopt($curl, CURLOPT_FAILONERROR, true); 
	// 	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); 
	// 	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
	// 	$result = curl_exec($curl); 

	// 	$obj = json_decode($result,true);
	// 	if($obj['CodeResult']==100)
	// 	{
	// 		return true;
	// 	}
	// 	else
	// 	{
	// 		return false;
	// 	}
	// }

	//VIETGUYS
	public static function sendSMS($phone_receive, $content) {
		$account = 'posapp';
		$password = 'bpzsr';
		$service_id = 'Verify';
		$send_content = urlencode($content);
		$api = "https://cloudsms.vietguys.biz:4438/api/index.php?u=$account&pwd=$password&from=$service_id&phone=$phone_receive&sms=$send_content&type=8&json=1";

		$curl = curl_init($api);
		curl_setopt($curl, CURLOPT_FAILONERROR, true); 
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); 
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 

		$result = curl_exec($curl);
		$obj = json_decode($result,true);

		if($obj['error'] == 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public static function uploadImage($image, $upload_path, $file_name, $type = null){
		if(!is_null($image) && $image->isValid()){
			$upload_path = public_path($upload_path); //folder public/upload

			$image->move($upload_path, $file_name);

			if($type) {
				return Util::getUrlFile($file_name, $type);
			}
			else {
				return $file_name;
			}
        }
        else{
            return null;
        }
	}

	public static function generateOTP($length = 4){
		return rand(pow(10, $length-1), pow(10, $length)-1);
	}

	public static function getNow() {
		return date('Y-m-d H:i:s');
	}

	public static function getDateSearch($date, $from = true) {
    	if($from) {
			return date('Y-m-d 00:00:00', strtotime($date));
		}
		else {
			return date('Y-m-d 23:59:59', strtotime($date));
		}
	}

	public static function uploadImageBase64($shop_id,$data) {
		$img_url = $shop_id."_".uniqid().".jpg";
		$path = public_path().'/upload/product/' . $img_url;
		if (file_put_contents($path, base64_decode(substr($data, strpos($data, ",")+1)))) {
			return $img_url;
		}
		return '';
	}

	public static function checkImageBase64($data) {
		if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
			$data = substr($data, strpos($data, ',') + 1);
			$type = strtolower($type[1]); // jpg, png, gif
			if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
				return false;
			}
		} else {
			return false;
		}
		return true;
	}

	public static function getBusinessDateTimestamp($date, $business_start_hour, $return_date = false) {
		if(!$business_start_hour) {
			$business_start_hour = Constant::SHOP_BUSINESS_START_HOUR;
		}
		$business_start_hour = explode(':', $business_start_hour);
		$business_seconds = $business_start_hour[0] * 3600 + $business_start_hour[1] * 60 + $business_start_hour[2];
		$business_datetime = strtotime("-{$business_seconds} seconds", strtotime($date));
		if($return_date) {
			return strtotime(date('Y-m-d', $business_datetime));
		}
		else {
			return $business_datetime;
		}
	}

	public static function getPrefixZero($num, $total_length) {
		$num_length = strlen($num);
		for($i = $num_length; $i < $total_length; $i++) {
			$num = '0' . $num;
		}
		return $num;
	}

	public static function getOrderCode($shop_id) {
		return $shop_id ? shop_order_statistic::getOrderCodeByShopId($shop_id) : substr(md5(date('Y-m-d H:i:s')), 0, 5);
	}

	public static function getLocalTime(){
		return time().rand(1000, 9999);
	}

	public static function getParam($data, $key, $default = null) {
    	if(is_object($data)) {
			return $data->$key ?? $default;
		}
		else {
			return $data[$key] ?? $default;
		}
	}

	public static function getLocalId($shop_id) {
		$shop_id = self::getPrefixZero($shop_id, 6);
		return time().rand(100, 999).$shop_id.rand(100, 999);
	}

	public static function genTransactionID($shop_id, $type, $prefix = '') {
		$arr_prefix = [
			1 => 'TBH',
			2 => 'TKH',
			3 => 'TVN',
			4 => 'TK',
			10 => 'CCD',
			11 => 'CTD',
			12 => 'CNH',
			14 => 'CNKNCC',
			15 => 'CKH',
		];

		$code = isset($arr_prefix[$type]) ? $arr_prefix[$type] : 'K';
		if($prefix) {
			$code = $prefix;
		}

		$total_record = transaction::getCountTransactionByShopId($shop_id) + 1;

		return $code.self::getPrefixZero($total_record, 6);
	}

	public static function getUrlFile($file, $type) {
    	if(!$file) {
    		return '';
		}
    	else if(!preg_match('/http/', $file)) {
			$type_path = $type ? "/$type" : '';
			return env('APP_URL')."/upload{$type_path}/{$file}";
		}
		else {
			return $file;
		}
	}

	public static function getUploadPath($type = null) {
    	$type_path = $type ? $type.'/' : '';
    	return "/upload/{$type_path}";
	}

	public static function getUploadFileName($extension, $shop_id = '') {
		return $shop_id.'_'.substr(md5(date('Y-m-d H:i:s').microtime()), 0, 10).'.'.$extension;
	}

	public static function getCheckSumPublicApp($app_id, $send_datetime, $secret_token) {
		$data_json = json_encode([
			'app_id' => $app_id,
			'send_datetime' => $send_datetime
		]);

		return md5($secret_token.$data_json).md5($data_json);
	}

	/*public static function sendEmail($email, $subject, $content) {
		Mail::to($email)->send(new ForgotPassword($content, $subject, 'anhquoc4062@gmail.com', 'Anh Quốc'));
		return true;
	}*/

	public static function sendMail($mails, $subject, $msg) {
        $subject = "=?utf-8?B?" . base64_encode($subject) . "?=";
        $headers = "MIME-Version: 1.0\n";
        $headers .= "Content-Type: text/html; charset=utf-8\n";
        $headers .= "From: PosApp.vn <support@posapp.vn>";

        if($mails && is_array($mails)) {
            foreach ($mails as $mail) {
                mail($mail, $subject, $msg, $headers);
            }
        }
        else if(mail($mails, $subject, $msg, $headers)) {
            return true;
        }

        return false;
    }

    public static function getIp() {
		if (isset($_SERVER['HTTP_CLIENT_IP']))
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_X_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if(isset($_SERVER['REMOTE_ADDR']))
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'UNKNOWN';

		return $ipaddress;
	}

	public static function changeTextShopConstantRolePermission($role_permissions, $shop_type) {
		if($shop_type == Constant::SHOP_TYPE_DISTRIBUTOR) {
			foreach ($role_permissions as &$permissions) {
				foreach ($permissions as $permission => &$permission_text) {
					if($permission == 55) {
						$permission_text = __('role_permission.manage_customer_agency');
					}
//					if(!in_array($permission, Constant::$DEFAULT_ALL_PERMISSIONS_SHOP_TYPE_DISTRIBUTOR)) {
//						unset($permissions[$permission]);
//					}
				}
			}
		}

		return $role_permissions;
	}
}
