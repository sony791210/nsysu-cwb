<?php

namespace Ksd\Adminer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Hash;
use Log;

class UpdateEmployeePassword extends FormRequest
{
    use \Ksd\Adminer\Traits\EmployeeManager;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // 驗證舊密碼
        if (Hash::check($this->input('old_password'), $this->getCurrentEmployee()->employee_password)) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old_password' => 'required',
            'password' => 'required|min:6|max:20'
        ];
    }

    public function messages()
    {
        return [
            'old_password.required' => '請輸入舊密碼',
            'password.required' => '請輸入新密碼',
            'password.min' => '新密碼請輸入至少6個字元',
            'password.max' => '新密碼請輸入最多20個字元',
        ];
    }

    public function forbiddenResponse()
    {
        return back()->withErrors(['舊密碼驗證錯誤']);
    }
}
