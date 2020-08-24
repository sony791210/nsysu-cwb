<?php

namespace Ksd\Adminer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployee extends FormRequest
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
            'id'       => 'required',
            'name'  => 'required',
            'displayName'     => 'required',
            'email'    => 'required|email'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '請填入帳戶名稱',
            'displayName.required'    => '請填入姓名',
            'email.required'   => '請填入email',
            'email.email'      => 'email格式錯誤'
        ];
    }
}
