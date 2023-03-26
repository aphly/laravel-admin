<?php

namespace Aphly\LaravelAdmin\Controllers;

use Aphly\Laravel\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

class Controller extends AdminController
{
    function rbacRoutes(){
        $data = [];
        $routes = Route::getRoutes();
        foreach ($routes as $route) {
            $controller = !empty($route->action["controller"]) ?  $route->action["controller"] : '';
            $middleware = !empty($route->action["middleware"]) ? $route->action["middleware"] : [];
            if($middleware && in_array('rbac',$middleware)){
                if($controller){
                    $controller_arr = explode('@',$controller);
                    $data[$controller_arr[0]][] = [
                        'class' => $controller_arr[0],
                        'function'=>$controller_arr[1],
                        'class@function'=>$controller,
                        "name" => !empty($route->action["as"]) ?   $route->action["as"] : '',
                        "uri" => '/'.$route->uri,
                        "method" => implode(',',$route->methods)
                    ];
                }
            }
        }
        return $data;
    }
}
