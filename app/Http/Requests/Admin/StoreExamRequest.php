<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreExamRequest extends FormRequest
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
            'exam_name' => 'required|unique:exam,exam_name',
            'language' => 'required',
            'exam_category_id' => 'required|numeric',
            'organization_id' => 'required|numeric',
            'teacher_id' => 'required|numeric',
            'exam_duration' => 'required|numeric|min:1',
            'total_marks' => 'required|numeric|min:1',
            'passing_marks' => 'required|numeric|min:1',
            'total_questions' => 'required|numeric|min:1',
            // 'has_sections' => 'required|numeric',
            'questions_type' => 'required|numeric',
            'submit_type' => 'required|numeric',
            'is_negative_marking' => 'required|numeric',
            'negative_marking_no' => 'nullable|numeric|between:0.01,99.99',
            'video_link' => 'required'
        ];
    }
}
