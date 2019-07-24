<?php

namespace App\Helper;

use App\Helpers\Util;
use App\Models\account_push;
use App\Models\order;
use App\Models\push_log;

class PushHelper
{
	public static function pushAppByOrderId($order_id, $shop_id, $push_type, $device_id) {
		$order = order::getOrderById($order_id, $shop_id);
		if($order) {
			$push_infos = account_push::getPushInfoShopByAccountServiceIds($order->account_service_ids, $shop_id, $device_id);
			$data = self::formartDataPush($order, $shop_id, $push_type);
			self::pushApp($push_infos, $data);
		}
	}

	public static function getOrderStatusMsg($order_status, $table_name, $langcode, $is_user = false, $is_new = false) {
		$msg = '';
		$msg_table_name = $table_name ? $table_name . ' ' : '';
		$msg_from_user = $is_user == true ? ' ' . __('messages.from_customer', [], $langcode) : '';
		if($is_new || $order_status == 0) {
			$msg = $msg_table_name . __('messages.has_new_order', [], $langcode);
		}
		else if($order_status == 1) {
			$msg = $msg_table_name . __('messages.has_update_order', [], $langcode);
		}
		return $msg . $msg_from_user;
	}

	public static function formartDataPush($order, $shop_id, $push_type) {
		if($order) {
			$order_json = json_encode(order::getOrderAndOrderProductByOrderId($order->id, $shop_id));

			$data = [
				'order_id' => $order->id,
				'order_json' => $order_json,
				'order_status' => $order->status,
				'table_name' => $order->table_name,
				'order_last_update' => $order->last_update_local,
				'shop_id' => $order->shop_id,
				'push_type' => $push_type,
				'version_code' => $order->version_code,
			];

			if(self::overDataSize($data, 1)) {
				$data['order_json'] = '';
			}
		}
		//Push call (waiter, payment)
		else {
			$data = [
				'order_id' => '',
				'order_json' => '',
				'order_status' => '',
				'table_name' => '',
				'order_last_update' => '',
				'shop_id' => $shop_id,
				'push_type' => $push_type,
				'version_code' => '',
			];
		}

		return $data;
	}

	public static function pushApp($push_infos, $data) {
		if(
			Util::getParam($push_infos, 'android') &&
			(
				count(Util::getParam($push_infos['android'], 'vi')) ||
				count(Util::getParam($push_infos['android'], 'en')) ||
				count(Util::getParam($push_infos['android'], 'ja'))
			)
		) {
			self::pushAndroid($push_infos['android'], $data);
		}

		if(
			Util::getParam($push_infos, 'ios') &&
			(
				count(Util::getParam($push_infos['ios'], 'vi')) ||
				count(Util::getParam($push_infos['ios'], 'en')) ||
				count(Util::getParam($push_infos['ios'], 'ja'))
			)
		) {
			self::pushIos($push_infos['ios'], $data);
		}
	}

	private static function overDataSize($data, $os_type = 0) {
		//ios limit 2kB
		if($os_type) {
			$limit_size = 1.5*1024;
		}
		//android limit 4kB
		else {
			$limit_size = 3.5*1024;
		}
		$serialized_data = serialize($data);
		$data_size = mb_strlen($serialized_data, '8bit');
		return $data_size > $limit_size;
	}

	private static function pushAndroid($push_infos, $data) {
		$debug_log = new push_log();
		$debug_log->name = 'push_log';
		$debug_log->log = json_encode($push_infos);
		$debug_log->save();

		$url = 'https://fcm.googleapis.com/fcm/send';
		$key = 'AIzaSyAuYwgGBACV9gn4_IVzSG35rKxEEa_K0b0';

		$headers = [
			'Authorization: key='.$key,
			'Content-Type: application/json'
		];

		foreach ($push_infos as $langcode => $push_ids) {
			$data['msg'] = self::getOrderStatusMsg($data['order_status'], $data['table_name'], $langcode);

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			$fields = [
				'registration_ids' => $push_ids,
				'data' => $data,
			];

			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

			curl_exec($ch);
			curl_close($ch);
		}
	}

	private static function pushIos($push_infos, $data) {}
}
