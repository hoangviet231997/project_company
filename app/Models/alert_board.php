<?php

namespace App\Models;

use App\Helpers\Util;
use Illuminate\Database\Eloquent\Model;

class alert_board extends Model
{
    protected $table = 'alert_board';
    protected $guarded = [];
    public $timestamps = false;

    public static function getListNotification($shop_id, $type, $title)
    {
        $query = alert_board::where([
            'invalid' => 0,
            'created_shop_id' => $shop_id
        ]);

        if ($type) {
            $query->where(['type' => $type]);
        }
        if ($title) {
            $query->whereRaw("(title like '%{$title}%' or message like '%{$title}%')");
        }

        $query = $query->get()->makeHidden('invalid');
        return $query;
    }

    public static function getNotification($id, $created_shop_id)
    {
        $query = alert_board::where([
            'id' => $id,
            'created_shop_id' => $created_shop_id,
            'invalid' => 0
        ])->first();
        if ($query) {
            $query = $query->makeHidden('invalid');
        }
        return $query;
    }

    public static function updateOrInsertNotification($data, $id = null)
    {
        if (isset($data['shop_id'])) {
            alert_board::where(['created_shop_id' => $data['shop_id']]);
            $data['created_shop_id'] = $data['shop_id'];
            unset($data['shop_id']);
        }
        if (isset($data['shop_ids'])) {
            $list_shop = explode(',', $data['shop_ids']);
            foreach ($list_shop as $key => $value) {
                if (!trim($value)) {
                    unset($list_shop[$key]);
                }
            }
            $list_shop = implode(',', $list_shop);
        }
        if (is_null($id)) {
            $data['invalid'] = 0;
            $data['shop_ids'] = $list_shop;
            $data['type'] = isset($data['type']) ? $data['type'] : 0;
            $data['title'] = isset($data['title']) ? $data['title'] : null;
            $data['title_color'] = isset($data['title_color']) ? $data['title_color'] : null;
            $data['message'] = isset($data['message']) ? $data['message'] : null;
            $data['detail_url'] = isset($data['detail_url']) ? $data['detail_url'] : null;
            $data['sub_url'] = isset($data['sub_url']) ? $data['sub_url'] : null;
            $data['popup_flg'] = isset($data['popup_flg']) ? $data['popup_flg'] : 0;
            $data['regdate'] = date('Y-m-d H:i:s');
            $last_id = alert_board::insertGetId($data);
            if ($last_id != false) {
                if (isset($data['img_url']) && is_object($data['img_url'])) {
                    $image_extension = $data['img_url']->getClientOriginalExtension();
                    $image_name = $last_id . '.' . $image_extension;
                    $do_upload = Util::uploadImage($data['img_url'], '/upload/Notification/', $image_name);
                    if (!$do_upload) {
                        return 0;
                    } else {
                        $image_url = $_SERVER['APP_URL'] . '/upload/Notification/' . $image_name;
                        alert_board::where('id', $last_id)->update(['img_url' => $image_url]);
                    }
                }
            }

            if ($last_id) {
                $response = alert_board::where('id', $last_id)->first();
                return $response;
            }
        } else {
            $data['updatedate'] = date('Y-m-d H:i:s');
            $query = alert_board::updateOrInsert(['id' => $id], $data);
            if ($query) {
                return 'messages.success';
            }
        }
        return 'messages.error';
    }

    public static function deleteNotification($id, $shop_id) {
        $query = alert_board::where([
            'id' => $id,
            'created_shop_id' => $shop_id
        ])->update(['invalid' => 1]);

        if (!$query) {
            return 'messages.error';
        }
        return 'messages.success';
    }

    public static function getListNotificationByCurrentShop($shop_id)
    {
    	//or created_shop_id = '{$shop_id}'
        $data = alert_board::where(['invalid' => 0])
            ->whereRaw("((shop_ids like '%,{$shop_id},%' or shop_ids like '{$shop_id},%' or shop_ids like '%,{$shop_id}' or shop_ids = '{$shop_id}'))")
            ->orderBy('regdate', 'desc')
            ->orderBy('updatedate', 'desc')->get();
        return $data;
    }
}
