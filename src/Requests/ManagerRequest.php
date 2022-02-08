<?php

namespace Aphly\LaravelAdmin\Requests;


use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Requests\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class ManagerRequest extends FormRequest
{

    public function rules()
    {
        return [
            //'username' => 'required|between:4,32|alpha_num',
            'username' => 'required',
            'password' => 'required|between:6,64|alpha_num',
        ];
    }

    public function attributes()
    {
        return [
            'username'      => '用户名',
            'password'      => '密码',
        ];
    }

    public function messages()
    {
        return [
            'username.required' => '请输入用户名',
            'password.required' => '请输入密码',
        ];
    }

}
