<?php

namespace Aphly\LaravelAdmin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class TestController extends Controller
{

    public function index()
    {
        $data=['title'=>'后台登录'];
        return view('laravel-admin::admin.login',['data'=>$data]);
    }

}
