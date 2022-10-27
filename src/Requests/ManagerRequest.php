<?php

namespace Aphly\LaravelAdmin\Requests;

use Aphly\Laravel\Requests\FormRequest;

class ManagerRequest extends FormRequest
{

    public function rules()
    {
        if($this->isMethod('post')){
            $str = $this->route()->getAction()['controller'];
            list($routeControllerName, $routeActionName) = explode('@',$str);
            if($routeActionName=='add'){
                return [
                    'username' => 'required|between:4,32|alpha_num|unique:admin_manager',
                    'nickname' => 'nullable|string',
                    'phone' => 'nullable|numeric|regex:/^1[0-9]{10}$/',
                    'email' => 'nullable|email:filter',
                    'password' => 'required|between:6,64|alpha_num',
                    'gender' => 'numeric',
                ];
            }else if($routeActionName=='edit'){
                return [
                    'password' => 'nullable|between:6,64|alpha_num',
                ];
            }
        }
        return [];
    }

//    public function attributes()
//    {
//        return [
//            'username'      => '用户名',
//            'password'      => '密码',
//        ];
//    }

    public function messages()
    {
        return [
            'username.required' => '请输入用户名',
            'password.required' => '请输入密码',
            'password.alpha_num' => '密码只能是字母和数字',
        ];
    }


}
