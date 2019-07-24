<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class course_detail extends Model
{
    protected $table= 'course_detail';
    protected $guarded = [];
    public $timestamps= true;

    public static function getListCourse($shop_id, $name, $type, $parent_course_id) {
        $query = course_detail::where([
            'course_detail.shop_id' => $shop_id,
            'course_detail.invalid' => 0,
        ])->select
        (['course_detail.*',
            DB::raw('product.product_name as product_name'),
            DB::raw('course_master.name as course_name')
        ])->join('product','course_detail.product_id','=','product.product_id')
            ->join('course_master','course_detail.parent_course_id','=','course_master.id')
            ->orderBy('index_sort','asc');

        if (!is_null($name)) {
            $query->where('course_detail.name', 'like', '%'.$name.'%');
        }
        if (!is_null($type)) {
            $query->where('type',$type);
        }
        if (!is_null($parent_course_id)) {
            $query->where('parent_course_id',$parent_course_id);
        }
        $query = $query->get()->makeHidden('invalid');
        return $query;
    }

    public static function getCourseDetail ($id , $shop_id) {
        $query = course_detail::where([
            'course_detail.id'      => $id,
            'course_detail.shop_id' => $shop_id,
            'course_detail.invalid' => 0
        ])->join('product','course_detail.product_id','=','product.product_id')
            ->select('course_detail.*','product.product_name as product_name')
            ->first();
        if($query){
            $query = $query->makeHidden('invalid');
        }
        return $query;
    }

    public static function countExistedName ($name , $shop_id,$id = null, $product_id = null, $type = null, $parent_course_id = null)
    {
        $count = course_detail::where([
            'name'    => $name,
            'shop_id' => $shop_id,
            'invalid' => 0,

        ]);

        if(!is_null($id)){
            $count = $count->where('id','<>', $id);
        }
        return $count->count();
    }

    public static function updateOrInsertCourseDetail($data, $id=null){

        if(isset($data['name']))
        {
            $data['created_at']=date('Y-m-d H:i:s');
            $data['updated_at']=date('Y-m-d H:i:s');

            if(course_detail::countExistedName(
                    $data['name'],
                    $data['shop_id'],
                    $data['product_id'],
                    $data['parent_course_id'],
                    $data['type'],
                    $id) > 0)
            {
                if(!is_null($id)){
                    // dang cap nhat
                    $old_name = course_detail::where([
                        'id'    => $id,
                        'shop_id' => $data['shop_id'],
                        'invalid' => 0 ])->value('name');

                    if( $old_name != $data['name']){
                        // cap nhat ma co sua ten
                        return 'messages.existed_data';
                    }
                }
                else {  // dang them ma bi trung
                    return 'messages.existed_data';
                }
            }
        }
        if(is_null($id)) {
            $last_id =course_detail::insertGetId($data);
            if($last_id){
                $response =course_detail::where('id', $last_id)->first() ;
                return $response;
            }
        }
        else{
            $query =course_detail::updateOrInsert([ 'id' => $id ], $data);
            if($query){
                return 'messages.success';
            }
        }
        return 'messages.error';
    }

    public static function deleteCourseDetail($shop_id, $id) {
        $query = course_detail::where([
            'id'      => $id,
            'shop_id' => $shop_id,
            'invalid' => 0
        ])->update(['invalid' => 1]);
        if(!$query){
            return 'messages.error';
        }
        return 'messages.success';
    }
}
