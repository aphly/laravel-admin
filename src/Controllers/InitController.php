<?php

namespace Aphly\LaravelAdmin\Controllers;

use Aphly\Laravel\Libs\Helper;
use Aphly\LaravelAdmin\Models\Manager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InitController extends Controller
{
    public function index()
    {
        if(config('admin.init')){
            $user = DB::table('manager')->where('username', 'admin')->first();
            if(!$user){
                $post['username'] = 'admin';
                $password = 'asdasd';
                $post['uuid'] = $post['token'] = Helper::uuid();
                $post['token_expire'] = time();
                $post['password'] = Hash::make($password);
                $manager = Manager::create($post);

                $data=[];
                $data[] =['name' => '系统后台','url' =>'','pid'=>0,'is_leaf'=>0];
                $data[] =['name' => '用户管理','url' =>'','pid'=>1,'is_leaf'=>0];
                $data[] =['name' => '系统用户','url' =>'/admin/manager/index','pid'=>2,'is_leaf'=>1];
                $data[] =['name' => '角色管理','url' =>'/admin/role/index','pid'=>2,'is_leaf'=>1];
                $data[] =['name' => '权限管理','url' =>'/admin/permission/index','pid'=>2,'is_leaf'=>1];
                $data[] =['name' => '菜单管理','url' =>'/admin/menu/index','pid'=>2,'is_leaf'=>1];
                DB::table('menu')->insert($data);

                $data=[];
                $data[] =['name' => '管理员'];
                DB::table('role')->insert($data);

                $data=[];
                $data[] =['role_id' => 1,'menu_id'=>1];
                $data[] =['role_id' => 1,'menu_id'=>2];
                $data[] =['role_id' => 1,'menu_id'=>3];
                $data[] =['role_id' => 1,'menu_id'=>4];
                $data[] =['role_id' => 1,'menu_id'=>5];
                $data[] =['role_id' => 1,'menu_id'=>6];
                DB::table('role_menu')->insert($data);

                $data=[];
                $data[] =['uuid' => $manager->uuid,'role_id'=>1];
                DB::table('user_role')->insert($data);
                return '初始化成功！超级管理员帐户:'.$post['username'].' 密码:'.$password;
            }else{
                return '已初始化';
            }
        }else{
            return '不允许初始化';
        }
    }



}