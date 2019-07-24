<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseDetailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'type' => 'required',
            'parent_course_id' => 'required',
            'index_sort' => 'required'
        ];
    }

}
