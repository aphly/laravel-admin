<?php

namespace Aphly\LaravelAdmin\Requests;

use Aphly\Laravel\Requests\FormRequest;

class MenuRequest extends FormRequest
{

    public function rules()
    {
        if($this->isMethod('post')){
            $str = $this->route()->getAction()['controller'];
            list($routeControllerName, $routeActionName) = explode('@',$str);
            if($routeActionName=='add'){
                return [
                    'name' => 'required',
                    'status' => 'numeric',
                    'is_leaf' => 'numeric',
                    'sort' => 'numeric',
                ];
            }else if($routeActionName=='edit'){
                return [
                    'name' => 'required',
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
            'name.required' => '菜单名称必填',
        ];
    }


}
