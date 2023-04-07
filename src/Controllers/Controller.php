<?php

namespace Aphly\LaravelAdmin\Controllers;

use Aphly\Laravel\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

class Controller extends AdminController
{
    function getRoutes($type='all'){
        $data = [];
        $routes = Route::getRoutes();
        foreach ($routes as $route) {
            $controller = !empty($route->action["controller"]) ?  $route->action["controller"] : '';
            if($type=='all'){
                $arr = $this->_getRoutes($route,$controller);
                if($arr){
                    $data[$arr['class']][] = $arr;
                }
            }else if($type=='rbac'){
                $middleware = !empty($route->action["middleware"]) ? $route->action["middleware"] : [];
                if($middleware && in_array('rbac',$middleware)){
                    $arr = $this->_getRoutes($route,$controller);
                    if($arr){
                        $data[$arr['class']][] = $arr;
                    }
                }
            }
        }
        return $data;
    }

    function _getRoutes($route,$controller){
        $arr = [];
        if($controller){
            $controller_arr = explode('@',$controller);
            $class = $controller_arr[0]??'';
            if(strstr($class,'App\Http\Controllers') || strstr($class,'Aphly')){
                $arr = [
                    'class' => $class,
                    'function'=>$controller_arr[1]??'',
                    'perm'=>$controller,
                    "name" => !empty($route->action["as"]) ?   $route->action["as"] : '',
                    "url" => $route->uri,
                    "method" => implode(',',$route->methods)
                ];
            }
        }
        return $arr;
    }

}
