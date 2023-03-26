<?php

namespace Aphly\LaravelAdmin\Requests;

use Aphly\Laravel\Requests\FormRequest;

class PermissionRequest extends FormRequest
{

    public function rules()
    {
        if($this->isMethod('post')){
            $str = $this->route()->getAction()['controller'];
            list($routeControllerName, $routeActionName) = explode('@',$str);
            if($routeActionName=='add'){
                return [
                    'name' => 'required',
                    'controller' => 'requiredIf:is_leaf,1',
                    'status' => 'numeric',
                    'is_leaf' => 'numeric',
                    'sort' => 'numeric',
                ];
            }else if($routeActionName=='edit'){
                return [
                    'name' => 'required',
                    'controller' => 'requiredIf:is_leaf,1',
                    'status' => 'numeric',
                    'is_leaf' => 'numeric',
                    'sort' => 'numeric',
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
            'name.required' => '权限名称必填',
            'controller.required' => '控制器必填',
        ];
    }


}
