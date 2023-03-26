<?php

namespace Aphly\LaravelAdmin\Requests;

use Aphly\Laravel\Requests\FormRequest;

class RoleRequest extends FormRequest
{

    public function rules()
    {
        if($this->isMethod('post')){
            $str = $this->route()->getAction()['controller'];
            list($routeControllerName, $routeActionName) = explode('@',$str);
            if($routeActionName=='add'){
                return [
                    'name' => 'required',
                ];
            }else if($routeActionName=='edit'){
                return [
                    'name' => 'required',
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
            'name.required' => '请输入角色名',
        ];
    }


}
