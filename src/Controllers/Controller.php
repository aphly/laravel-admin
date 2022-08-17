<?php

namespace Aphly\LaravelAdmin\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class Controller extends \Aphly\Laravel\Controllers\Controller
{

    public $manager = null;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $auth = Auth::guard('manager');
            if($auth->check()){
                $this->manager = $auth->user();
                View::share("manager",$this->manager);
            }else{
                View::share("manager",[]);
            }
            return $next($request);
        });
        parent::__construct();
    }

    public function index_url($post): string
    {
        if (!empty($post['pid'])) {
            return $this->index_url . '?pid=' . $post['pid'];
        } else {
            return $this->index_url;
        }
    }
}
