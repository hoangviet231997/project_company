<?php
namespace App\Http\Controllers\Api\v1;
use App\Models\course_detail;
use App\Http\Requests\CourseDetailRequest;
use Illuminate\Http\Request;

class CourseDetailController extends Controller
{
    public function getListCourseDetail (Request $request) {
        $data = course_detail::getListCourse($request->shop_id, $request->name, $request->type, $request->parent_course_id);
        return $this->respondSuccess($data);
    }

    public function getCourseDetail (Request $request) {
        if($request->id){
            $data = course_detail::getCourseDetail($request->id, $request->shop_id);
            return $this->respondSuccess($data);
        }
        else{
            return $this->respondMissingParam();
        }
    }

    public function newCourseDetail (Request $request) {
        if(isset($request->name) && isset($request->product_id) && isset($request->type) && isset($request->parent_course_id)){
            $data = $request->except(['token', 'id']);
            $query =course_detail::updateOrInsertCourseDetail($data);
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

    public function updateCourseDetail (Request $request)
    {
        if(isset($request->id) && isset($request->name) && isset($request->product_id) && isset($request->type) && isset($request->parent_course_id)){
            $data = $request->except(['token', 'id']);
            $id = $request->id;
            $query =course_detail::updateOrInsertCourseDetail($data, $id);
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

    public function deleteCourseDetail (Request $request) {
        if($request->id){
            $data =course_detail::deleteCourseDetail($request->shop_id, $request->id);
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
