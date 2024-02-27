<?php

namespace Aphly\LaravelAdmin\Controllers;

use Aphly\Laravel\Exceptions\ApiException;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{

    public function index()
    {
        $res['title'] = '';
        return $this->makeView('laravel-admin::home.index',['res'=>$res]);
    }

    public function cache()
    {
        Cache::flush();
        throw new ApiException(['code'=>0,'msg'=>'缓存已清空','data'=>['redirect'=>'/admin/index']]);
    }

}
