<?php

namespace Aphly\LaravelAdmin\Controllers;

use Aphly\Laravel\Libs\Helper;
use Aphly\LaravelAdmin\Models\Manager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class InitController extends Controller
{

    public function index()
    {
        $post['username'] = 'admin';
        $post['uuid'] = $post['token'] = Helper::uuid();
        $post['token_expire'] = time();
        $post['password'] = Hash::make('asdasd');
        return Manager::create($post);
    }

    public function add()
    {
        $data = [];
        for($i=1;$i<=100;$i++){
            $data[] =['uuid' => Str::random(4),'content' =>Str::random(8),'user_id'=>2];
        }
        DB::table('manager')->insert($data);
        return 'ok';
    }




}
