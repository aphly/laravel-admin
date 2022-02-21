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
                    'url' => ''
                ];
            }else if($routeActionName=='edit'){
                return [
                    'name' => 'required',
                    'url' => '',
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

//'controller' => Rule::requiredIf(function () {
//    if ($this->input('is_leaf')) {
//        return true;
//    } else {
//        return false;
//    }
//}),

    public function messages()
    {
        return [
            'name.required' => '菜单名称必填',
        ];
    }


}
