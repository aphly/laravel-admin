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
                DB::table('manager')->truncate();
                $post['username'] = 'admin';
                $password = 'asdasd';
                $post['uuid'] = $post['token'] = Helper::uuid();
                $post['token_expire'] = time();
                $post['password'] = Hash::make($password);
                $manager = Manager::create($post);

                DB::table('menu')->truncate();
                $data=[];
                $data[] =['name' => '系统后台','url' =>'','pid'=>0,'is_leaf'=>0];
                $data[] =['name' => '系统管理','url' =>'','pid'=>1,'is_leaf'=>0];
                $data[] =['name' => '系统用户','url' =>'/admin/manager/index','pid'=>2,'is_leaf'=>1];
                $data[] =['name' => '用户列表','url' =>'/admin/user/index','pid'=>2,'is_leaf'=>1];
                $data[] =['name' => '角色管理','url' =>'/admin/role/index','pid'=>2,'is_leaf'=>1];
                $data[] =['name' => '权限管理','url' =>'/admin/permission/index','pid'=>2,'is_leaf'=>1];
                $data[] =['name' => '菜单管理','url' =>'/admin/menu/index','pid'=>2,'is_leaf'=>1];
                DB::table('menu')->insert($data);

                DB::table('role')->truncate();
                $data=[];
                $data[] =['name' => '后台角色','pid'=>0,'is_leaf'=>0];
                $data[] =['name' => '管理员','pid'=>1,'is_leaf'=>1];
                $data[] =['name' => '前台用户组','pid'=>0,'is_leaf'=>0];
                $data[] =['name' => 'LV0','pid'=>3,'is_leaf'=>1];
                $data[] =['name' => 'LV1','pid'=>3,'is_leaf'=>1];
                $data[] =['name' => 'LV2','pid'=>3,'is_leaf'=>1];
                $data[] =['name' => 'LV3','pid'=>3,'is_leaf'=>1];
                $data[] =['name' => 'LV4','pid'=>3,'is_leaf'=>1];
                $data[] =['name' => 'LV5','pid'=>3,'is_leaf'=>1];
                $data[] =['name' => 'LV6','pid'=>3,'is_leaf'=>1];
                $data[] =['name' => 'LV7','pid'=>3,'is_leaf'=>1];
                $data[] =['name' => 'LV8','pid'=>3,'is_leaf'=>1];
                $data[] =['name' => 'LV9','pid'=>3,'is_leaf'=>1];
                DB::table('role')->insert($data);

                DB::table('role_menu')->truncate();
                $data=[];
                $data[] =['role_id' => 2,'menu_id'=>1];
                $data[] =['role_id' => 2,'menu_id'=>2];
                $data[] =['role_id' => 2,'menu_id'=>3];
                $data[] =['role_id' => 2,'menu_id'=>4];
                $data[] =['role_id' => 2,'menu_id'=>5];
                $data[] =['role_id' => 2,'menu_id'=>6];
                $data[] =['role_id' => 2,'menu_id'=>7];
                DB::table('role_menu')->insert($data);

                DB::table('user_role')->truncate();
                $data=[];
                $data[] =['uuid' => $manager->uuid,'role_id'=>2];
                DB::table('user_role')->insert($data);
                return '初始化成功！超级管理员帐户:'.$post['username'].' 密码:'.$password.' 登录地址：/admin/login';
            }else{
                return '已初始化';
            }
        }else{
            return '不允许初始化';
        }
    }



}
