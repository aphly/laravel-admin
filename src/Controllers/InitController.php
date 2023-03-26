<?php

namespace Aphly\LaravelAdmin\Controllers;

use Aphly\Laravel\Libs\Helper;
use Aphly\Laravel\Models\LevelPath;
use Aphly\Laravel\Models\Manager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InitController extends Controller
{
    public $level_id = 1;
    public $module_id = 1;

    public function index()
    {
        if(config('admin.init')){
            $user = DB::table('admin_manager')->where('username', 'admin')->first();
            if(empty($user)){
                DB::table('admin_level')->truncate();
                $data=[];
                $data[] =['id'=>1,'name' => '系统平台','pid'=>0,'is_leaf'=>0,'status'=>1];
                $data[] =['id'=>2,'name' => '管理中心','pid'=>1,'is_leaf'=>1,'status'=>1];
                $data[] =['id'=>3,'name' => '公司','pid'=>1,'is_leaf'=>1,'status'=>1];
                DB::table('admin_level')->insert($data);
                (new LevelPath)->rebuild();

                DB::table('admin_role')->truncate();
                $data=[];
                $data[] =['id'=>1,'name' => '超级管理员','level_id'=>1,'module_id'=>$this->module_id];
                $data[] =['id'=>2,'name' => '管理员','level_id'=>2,'module_id'=>$this->module_id];
                DB::table('admin_role')->insert($data);

                DB::table('admin_manager')->truncate();
                $post['uuid'] = $post['token'] = Helper::uuid();
                $post['username'] = 'admin';
                $password = 'asdasd';
                $post['token_expire'] = time();
                $post['level_id'] = $this->level_id;
                $post['password'] = Hash::make($password);
                $manager = Manager::create($post);

                DB::table('admin_menu')->truncate();
                $data=[];
                $data[] =['id'=>1,'name' => '系统管理','url' =>'','pid'=>0,'is_leaf'=>0,'level_id'=>$this->level_id,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>2,'name' => '模块管理','url' =>'/admin/module/index','pid'=>1,'is_leaf'=>1,'level_id'=>$this->level_id,'module_id'=>$this->module_id,'sort'=>101];
                $data[] =['id'=>3,'name' => '层级管理','url' =>'/admin/level/index','pid'=>1,'is_leaf'=>1,'level_id'=>$this->level_id,'module_id'=>$this->module_id,'sort'=>100];
                $data[] =['id'=>4,'name' => '管理员','url' =>'/admin/manager/index','pid'=>1,'is_leaf'=>1,'level_id'=>$this->level_id,'module_id'=>$this->module_id,'sort'=>99];

                $data[] =['id'=>5,'name' => '管理权限','url' =>'','pid'=>1,'is_leaf'=>0,'level_id'=>$this->level_id,'module_id'=>$this->module_id,'sort'=>90];
                $data[] =['id'=>6,'name' => '角色管理','url' =>'/admin/role/index','pid'=>5,'is_leaf'=>1,'level_id'=>$this->level_id,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>7,'name' => '权限管理','url' =>'/admin/permission/index','pid'=>5,'is_leaf'=>1,'level_id'=>$this->level_id,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>8,'name' => '菜单管理','url' =>'/admin/menu/index','pid'=>5,'is_leaf'=>1,'level_id'=>$this->level_id,'module_id'=>$this->module_id,'sort'=>0];

                $data[] =['id'=>9,'name' => '其他设置','url' =>'','pid'=>1,'is_leaf'=>0,'level_id'=>$this->level_id,'module_id'=>$this->module_id,'sort'=>60];
                $data[] =['id'=>10,'name' => '字典管理','url' =>'/admin/dict/index','pid'=>9,'is_leaf'=>1,'level_id'=>$this->level_id,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>11,'name' => '配置管理','url' =>'/admin/config/index','pid'=>9,'is_leaf'=>1,'level_id'=>$this->level_id,'module_id'=>$this->module_id,'sort'=>0];

                $data[] =['id'=>12,'name' => '运营记录','url' =>'','pid'=>1,'is_leaf'=>0,'level_id'=>$this->level_id,'module_id'=>$this->module_id,'sort'=>40];
                $data[] =['id'=>13,'name' => '错误登录','url' =>'/admin/failed_login/index','pid'=>12,'is_leaf'=>1,'level_id'=>$this->level_id,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>14,'name' => '禁止访问','url' =>'/admin/banned/index','pid'=>12,'is_leaf'=>1,'level_id'=>$this->level_id,'module_id'=>$this->module_id,'sort'=>0];

                DB::table('admin_menu')->insert($data);

                DB::table('admin_role_menu')->truncate();
                $data=[];
                for($i=1;$i<=14;$i++){
                    $data[] =['role_id' => 1,'menu_id'=>$i];
                }
                for($i=9;$i<=14;$i++){
                    $data[] =['role_id' => 2,'menu_id'=>$i];
                }
                DB::table('admin_role_menu')->insert($data);

                DB::table('admin_manager_role')->truncate();
                $data=[];
                $data[] =['uuid' => $manager->uuid,'role_id'=>1];
                $data[] =['uuid' => $manager->uuid,'role_id'=>2];
                DB::table('admin_manager_role')->insert($data);

                $data=[];
                $data[] =['name' => '状态','key'=>'status','level_id'=>$this->level_id,'module_id'=>$this->module_id];
                $data[] =['name' => '用户状态','key'=>'user_status','level_id'=>$this->level_id,'module_id'=>$this->module_id];
                $data[] =['name' => '用户性别','key'=>'user_gender','level_id'=>$this->level_id,'module_id'=>$this->module_id];
                $data[] =['name' => '是否','key'=>'yes_no','level_id'=>$this->level_id,'module_id'=>$this->module_id];
                DB::table('admin_dict')->insert($data);

                $data=[];
                $data[] =['dict_id' => 1,'name'=>'开启','value'=>'1'];
                $data[] =['dict_id' => 1,'name'=>'关闭','value'=>'2'];
                $data[] =['dict_id' => 2,'name'=>'正常','value'=>'1'];
                $data[] =['dict_id' => 2,'name'=>'冻结','value'=>'2'];
                $data[] =['dict_id' => 3,'name'=>'男','value'=>'1'];
                $data[] =['dict_id' => 3,'name'=>'女','value'=>'2'];
                $data[] =['dict_id' => 4,'name'=>'是','value'=>'1'];
                $data[] =['dict_id' => 4,'name'=>'否','value'=>'2'];
                DB::table('admin_dict_value')->insert($data);

                $data=[];
                $data[] =['id'=>1,'name' => 'admin-mod','key' => 'admin','status'=>1,'sort'=>0,'classname'=>'-'];
                $data[] =['id'=>2,'name' => 'common-mod','key' => 'common','status'=>0,'sort'=>0,'classname'=>'\Aphly\LaravelCommon\Controllers\Admin\InstallController'];
                $data[] =['id'=>4,'name' => 'payment-mod','key' => 'payment','status'=>0,'sort'=>0,'classname'=>'\Aphly\LaravelPayment\Controllers\Admin\InstallController'];
                $data[] =['id'=>101,'name' => 'novel-mod','key' => 'novel','status'=>0,'sort'=>0,'classname'=>'\Aphly\LaravelNovel\Controllers\Admin\InstallController'];
                $data[] =['id'=>102,'name' => 'shop-mod','key' => 'shop','status'=>0,'sort'=>0,'classname'=>'\Aphly\LaravelShop\Controllers\Admin\InstallController'];
                DB::table('admin_module')->insert($data);

                return '初始化成功！超级管理员帐户:'.$post['username'].' 密码:'.$password.' 登录地址：/admin/login';
            }else{
                return '已初始化';
            }
        }else{
            return '不允许初始化';
        }
    }



}
