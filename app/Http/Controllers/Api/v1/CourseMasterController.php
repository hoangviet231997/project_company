<?php
namespace App\Http\Controllers\Api\v1;

use App\Helpers\Util;
use App\Models\course_master;
use Illuminate\Http\Request;

class CourseMasterController extends Controller
{
    public function getListCourseMaster(Request $request) {
        $data = course_master::getListCourseMaster($request->shop_id, $request->name, $request->description);
        return $this->respondSuccess($data);
    }

    public function getCourseMaster(Request $request) {
        if($request->id) {
            $data = course_master::getCourseMaster($request->id, $request->shop_id);
            return $this->respondSuccess($data);
        }
        else {
            return $this->respondMissingParam();
        }
    }

    public function newCourseMaster(Request $request) {
        if(isset($request->name) && isset($request->image) && isset($request->description))
        {
            if($request->hasFile('image')) {
                $data = $request->except(['token', 'id']);
                $query =course_master::updateOrInsertCourseMaster($data);
            }
            else{
                return 'messages.file_fail';
            }
            if(gettype($query) != 'string'){
                return $this->respondSuccess($query);
            }
            else{
                return $this->respondError(__($query));
            }
        }
        else{
            return $this->respondMissingParam();
        }
    }

    public function updateCourseMaster (Request $request)
    {
        if(isset($request->name) && isset($request->image) && isset($request->description))
        {
            $data = $request->except(['token', 'id']);
            $id = $request->id;
            if($request->hasFile('image'))
            {
                $file_name= $id.'.'.$request->image->getClientOriginalExtension();
                if(file_exists(public_path("/upload/course-master/{$file_name}"))) {
                    \File::delete(public_path("/upload/course-master/{$file_name}"));

                }
                $request->image= Util::uploadImage($data['image'],'/upload/course-master/',$file_name);
                $data['image'] =$_SERVER['APP_URL'].'/upload/course-master/'.$request->image;
            }
            else {
                return 'messages.file_fail';
            }
            $query =course_master::updateOrInsertCourseMaster($data, $id);
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

    public function deleteCourseMaster (Request $request) {
        if($request->id)
        {
            $data =course_master::deleteCourseMaster($request->shop_id, $request->id);
            if($data == 'messages.success') {
                return $this->respondSuccess();
            }
            return $this->respondError();
        }
        else {
            return $this->respondMissingParam();
        }
    }
}
