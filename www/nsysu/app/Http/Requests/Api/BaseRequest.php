<?php

namespace App\Http\Requests\Api;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest as LaravelFormRequest;
use App\Traits\ApiResponseHelper;

abstract class BaseRequest extends LaravelFormRequest
{
    use ApiResponseHelper;

    abstract public function rules();

    abstract public function authorize();

    protected function failedValidation(Validator $validator)
    {
        $errors = join(' ', $validator->errors()->all());
        throw new HttpResponseException($this->apiRespFail('E0001', $errors));
    }
}