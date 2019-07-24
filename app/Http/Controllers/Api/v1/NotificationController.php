<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\Util;
use App\Models\alert_board;
use Illuminate\Http\Request;
use DB;

class NotificationController extends Controller
{

    public function getListNotification(Request $request)
    {
        $shop_id = $request->input('shop_id');
        $title = $request->input('title');
        $type = $request->input('type');
        $data = alert_board::getListNotification($shop_id, $type, $title);
        return $this->respondSuccess($data);
    }

    public function getNotificationDetail(Request $request)
    {
        if ($request->id) {
            $data = alert_board::getNotification($request->id, $request->created_shop_id);
            return $this->respondSuccess($data);
        }
        return $this->respondMissingParam();
    }

    public function newNotification(Request $request)
    {
        if (isset($request->shop_ids) && $request->type && $request->message) {
            $data = $request->except(['token', 'id']);
            if (!$request->file('img_url')) {
                $data['img_url'] = null;
            }

            $query = alert_board::updateOrInsertNotification($data);
            if (gettype($query) != 'string') {
                return $this->respondSuccess($query);
            } else {
                return $this->respondError(__($query));
            }
        } else {
            return $this->respondMissingParam();
        }
    }

    public function updateNotification(Request $request)
    {
        if (isset($request->shop_ids) && isset($request->shop_id)) {
            $data = $request->except(['token', 'id']);
            $id = $request->id;
            if ($request->file('img_url')) {
                $file_name = $id . '.' . $request->img_url->getClientOriginalExtension();
                if (file_exists(public_path("/upload/Notification/{$file_name}"))) {
                    \File::delete(public_path("/upload/Notification/{$file_name}"));
                }
                $request->img_url = Util::uploadImage($data['img_url'], '/upload/Notification/', $file_name);
                $data['img_url'] = $_SERVER['APP_URL'] . '/upload/Notification/' . $request->img_url;
            }
            $query = alert_board::updateOrInsertNotification($data, $id);
            if ($query == 'messages.success') {
                return $this->respondSuccess();
            } else {
                return $this->respondError(__($query));
            }
        } else {
            return $this->respondMissingParam();
        }
    }

    public function deleteNotification(Request $request)
    {
        if ($request->id) {
            $data = alert_board::deleteNotification($request->id, $request->shop_id);
            if ($data == 'messages.success') {
                return $this->respondSuccess();
            }
            return $this->respondError();
        } else {
            return $this->respondMissingParam();
        }
    }

    public function getListNotificationByCurrentShop(Request $request)
    {
        $shop_id = $request->input('shop_id');
        $data = alert_board::getListNotificationByCurrentShop($shop_id);
        return $this->respondSuccess($data);
    }
}
