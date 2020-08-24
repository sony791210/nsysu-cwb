<?php

namespace Ksd\Adminer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEmployee extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'name' => 'required',
            'displayName'     => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:6|max:20',
            'checkPassword' => 'required|same:password'
        ];
    }

    public function messages()
    {
        return [
            'employee_username.required' => '請填入帳戶名稱',
            'displayName.required'    => '請填入姓名',
            'email.required'   => '請填入email',
            'email.email'      => 'email格式錯誤',
            'password.min'     => '密碼確認請輸入至少6個字元',
            'password.max'     => '密碼確認請輸入最多20個字元',
            'password.required'     => '請填入密碼',
            'checkPassword.min'     => '確認密碼 - 請輸入至少6個字元',
            'checkPassword.max'     => '確認密碼 - 請輸入最多20個字元',
            'checkPassword.required'     => '請填入確認密碼',
            'checkPassword.same'    => '兩次输入密碼不一致'
        ];
    }
}
