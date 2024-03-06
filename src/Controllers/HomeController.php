<?php

namespace Aphly\LaravelAdmin\Controllers;

class HomeController extends Controller
{

    public function index()
    {
        $res['title'] = '';
        return $this->makeView('laravel-admin::home.index',['res'=>$res]);
    }

}
