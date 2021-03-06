<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeacherRequest extends FormRequest
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
            'first_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone_no' => 'required|numeric|regex:/[6-9]{1}[0-9]{9}/|digits:10',
            'alt_phone_no' => 'nullable|regex:/[6-9]{1}[0-9]{9}/|digits:10',
            'password' => 'required',
            'dob' => 'required',
            'specialties' => 'required',
            'experience' => 'required|numeric',
            'organization_id' => 'required|numeric',
            'education' => 'required',
            'address' => 'required',
            'overview' => 'required'
        ];
    }
}
