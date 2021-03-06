<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExamSectionRequest extends FormRequest
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
            // 'section_name' => 'required|unique:exam_sections,section_name,'.$this->id,
            'section_name' => 'required',
            'questions_type' => 'required',
            'submit_type' => 'required',
            'section_duration' => 'nullable|numeric',
            'total_marks' => 'required|numeric|min:1',
            'cutoff' => 'nullable|numeric',
            'total_questions' => 'required|numeric|min:1',
            'is_negative_marking' => 'required|numeric',
            'negative_marking_no' => 'nullable|numeric|between:0.01,99.99'
        ];
    }
}
