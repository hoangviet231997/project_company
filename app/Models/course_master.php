<?php

namespace App\Models;

use App\Helpers\Util;
use Illuminate\Database\Eloquent\Model;

class course_master extends Model
{
    protected $table = 'course_master';
    protected $guarded = [];
    public $timestamps = true;

    public static function getListCourseMaster($shop_id, $name, $description)
    {
        $query = course_master::where([
            'shop_id' => $shop_id,
            'invalid' => 0
        ]);
        if (!is_null($name)) {
            $query->where('name', 'like', '%' . $name . '%');
        }
        if (!is_null($description)) {
            $query->where('description', 'like', '%' . $description . '%');
        }
        $query = $query->get()->makeHidden('invalid');
        return $query;
    }

    public static function getCourseMaster($id, $shop_id)
    {
        $query = course_master::where([
            'id' => $id,
            'shop_id' => $shop_id,
            'invalid' => 0
        ])->first();
        if ($query) {
            $query = $query->makeHidden('invalid');
        }
        return $query;
    }

    public static function countExistedName($name, $shop_id, $id = null)
    {
        $count = course_master::where([
            'name' => $name,
            'shop_id' => $shop_id,
            'invalid' => 0]);

        if (!is_null($id)) {
            $count = $count->where('id', '<>', $id);
        }
        return $count->count();
    }

    public static function updateOrInsertCourseMaster($data, $id = null)
    {

        if (isset($data['name'])) {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');

            if (course_master::countExistedName(
                    $data['name'],
                    $data['shop_id'],
                    $data['image'],
                    $data['description'],
                    $id) > 0) {
                if (!is_null($id)) {
                    // dang cap nhat
                    $old_name = course_master::where([
                        'id' => $id,
                        'shop_id' => $data['shop_id'],
                        'invalid' => 0])->value('name');

                    if ($old_name != $data['name']) {
                        // cap nhat ma co sua ten
                        return 'messages.existed_data';
                    }
                } else {  // dang them ma bi trung
                    return 'messages.existed_data';
                }
            }
        }
        $data['description'] = !is_null($data['description']) ? $data['description'] : null;

        if (is_null($id)) {
            $last_id = course_master::insertGetId($data);
            if ($last_id != false) {
                $image_url = '';
                if (isset($data['image'])) {
                    $image_extension = $data['image']->getClientOriginalExtension();
                    $image_name = $last_id . '.' . $image_extension;
                    $do_upload = Util::uploadImage($data['image'], '/upload/course-master/', $image_name);
                    if (!$do_upload) {
                        return 0;
                    } else {
                        $image_url = $_SERVER['APP_URL'] . '/upload/course-master/' . $image_name;
                        course_master::where('id', $last_id)->update(['image' => $image_url]);
                    }
                }
            }
            if ($last_id) {
                $response = course_master::where('id', $last_id)->first();
                return $response;
            }
        } else {
            $query = course_master::updateOrInsert(['id' => $id], $data);
            if ($query) {
                return 'messages.success';
            }
        }
        return 'messages.error';
    }

    public static function deleteCourseMaster($shop_id, $id)
    {
        $query = course_master::where([
            'id' => $id,
            'shop_id' => $shop_id,
            'invalid' => 0
        ])->update(['invalid' => 1]);
        if (!$query) {
            return 'messages.error';
        }
        return 'messages.success';
    }
}
