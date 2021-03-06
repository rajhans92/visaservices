<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreExamScheduleRequest extends FormRequest
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
            'exam_display_name' => 'required|unique:exam_schedule,exam_display_name',
            'exam_id' => 'required|numeric',
            'sponsored_by' => 'required|numeric',
            'start_date' => 'required',
            'end_date' => 'required',
            'result_date' => 'required',
            'no_of_winner' => 'required|numeric|min:1',
            'prize_amount' => 'required|numeric|min:1',
            'user_limit' => 'required|numeric|min:1',
            'reminder' => 'nullable|numeric|min:1'
        ];
    }
}
