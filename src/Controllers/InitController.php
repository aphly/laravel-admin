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
                $data[] =['id'=>1,'name' => '系统平台','pid'=>0,'type'=>1,'status'=>1,'module_id'=>$this->module_id];
                $data[] =['id'=>2,'name' => '管理中心','pid'=>1,'type'=>1,'status'=>1,'module_id'=>$this->module_id];
                DB::table('admin_level')->insert($data);
                (new LevelPath)->rebuild();

                DB::table('admin_role')->truncate();
                $data=[];
                $data[] =['id'=>1,'name' => '超级管理员','level_id' => 1,'data_perm' => 3,'module_id'=>$this->module_id];
                $data[] =['id'=>2,'name' => '管理员','level_id' => 2,'data_perm' => 3,'module_id'=>$this->module_id];
                $data[] =['id'=>3,'name' => '初始角色','level_id' => 2,'data_perm' => 1,'module_id'=>$this->module_id];
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
                $data[] =['id'=>1,'name' => '首页','route' =>'admin/home/index','pid'=>0,'type'=>2,'module_id'=>$this->module_id,'sort'=>10000];
                $data[] =['id'=>2,'name' => '系统管理','route' =>'','pid'=>0,'type'=>1,'module_id'=>$this->module_id,'sort'=>0];

                $data[] =['id'=>3,'name' => '用户权限','route' =>'','pid'=>2,'type'=>1,'module_id'=>$this->module_id,'sort'=>60];

                $data[] =['id'=>4,'name' => '层级管理','route' =>'admin/level/index','pid'=>3,'type'=>2,'module_id'=>$this->module_id,'sort'=>100];
                $data[] =['id'=>5,'name' => '层级增加','route' =>'admin/level/add','pid'=>4,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>6,'name' => '层级修改','route' =>'admin/level/edit','pid'=>4,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>7,'name' => '层级删除','route' =>'admin/level/del','pid'=>4,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>8,'name' => '层级树形','route' =>'admin/level/tree','pid'=>4,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];

                $data[] =['id'=>9,'name' => '用户管理','route' =>'admin/manager/index','pid'=>3,'type'=>2,'module_id'=>$this->module_id,'sort'=>99];
                $data[] =['id'=>10,'name' => '用户增加','route' =>'admin/manager/add','pid'=>9,'type'=>3,'module_id'=>$this->module_id,'sort'=>99];
                $data[] =['id'=>11,'name' => '用户修改','route' =>'admin/manager/edit','pid'=>9,'type'=>3,'module_id'=>$this->module_id,'sort'=>99];
                $data[] =['id'=>12,'name' => '用户删除','route' =>'admin/manager/del','pid'=>9,'type'=>3,'module_id'=>$this->module_id,'sort'=>99];
                $data[] =['id'=>13,'name' => '用户角色','route' =>'admin/manager/role','pid'=>9,'type'=>3,'module_id'=>$this->module_id,'sort'=>99];

                $data[] =['id'=>14,'name' => '角色管理','route' =>'admin/role/index','pid'=>3,'type'=>2,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>15,'name' => '角色增加','route' =>'admin/role/add','pid'=>14,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>16,'name' => '角色修改','route' =>'admin/role/edit','pid'=>14,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>17,'name' => '角色删除','route' =>'admin/role/del','pid'=>14,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>18,'name' => '角色权限','route' =>'admin/role/permission','pid'=>14,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>19,'name' => '角色菜单','route' =>'admin/role/menu','pid'=>14,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>20,'name' => '角色树形','route' =>'admin/role/tree','pid'=>14,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];

                $data[] =['id'=>21,'name' => '菜单管理','route' =>'admin/menu/index','pid'=>3,'type'=>2,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>22,'name' => '菜单增加','route' =>'admin/menu/add','pid'=>21,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>23,'name' => '菜单修改','route' =>'admin/menu/edit','pid'=>21,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>24,'name' => '菜单删除','route' =>'admin/menu/del','pid'=>21,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>25,'name' => '菜单树形','route' =>'admin/menu/tree','pid'=>21,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];

                $data[] =['id'=>26,'name' => '权限管理','route' =>'admin/permission/index','pid'=>3,'type'=>2,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>27,'name' => '权限增加','route' =>'admin/permission/add','pid'=>26,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>28,'name' => '权限修改','route' =>'admin/permission/edit','pid'=>26,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>29,'name' => '权限删除','route' =>'admin/permission/del','pid'=>26,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>30,'name' => '权限树形','route' =>'admin/permission/tree','pid'=>26,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];

                $data[] =['id'=>31,'name' => '基础设置','route' =>'','pid'=>2,'type'=>1,'module_id'=>$this->module_id,'sort'=>90];

                $data[] =['id'=>32,'name' => '模块管理','route' =>'admin/module/index','pid'=>31,'type'=>2,'module_id'=>$this->module_id,'sort'=>101];
                $data[] =['id'=>33,'name' => '模块增加','route' =>'admin/module/add','pid'=>32,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>34,'name' => '模块修改','route' =>'admin/module/edit','pid'=>32,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>35,'name' => '模块删除','route' =>'admin/module/del','pid'=>32,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>36,'name' => '模块安装','route' =>'admin/module/install','pid'=>32,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];

                $data[] =['id'=>37,'name' => '字典管理','route' =>'admin/dict/index','pid'=>31,'type'=>2,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>38,'name' => '字典增加','route' =>'admin/dict/add','pid'=>37,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>39,'name' => '字典修改','route' =>'admin/dict/edit','pid'=>37,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>40,'name' => '字典删除','route' =>'admin/dict/del','pid'=>37,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];

                $data[] =['id'=>41,'name' => '配置管理','route' =>'admin/config/index','pid'=>31,'type'=>2,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>42,'name' => '配置增加','route' =>'admin/config/add','pid'=>41,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>43,'name' => '配置修改','route' =>'admin/config/edit','pid'=>41,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>44,'name' => '配置删除','route' =>'admin/config/del','pid'=>41,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];

                $data[] =['id'=>45,'name' => '运营管理','route' =>'','pid'=>2,'type'=>1,'module_id'=>$this->module_id,'sort'=>40];

                $data[] =['id'=>46,'name' => '错误登录','route' =>'admin/failed_login/index','pid'=>45,'type'=>2,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>47,'name' => '错误修改','route' =>'admin/failed_login/edit','pid'=>46,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>48,'name' => '错误删除','route' =>'admin/failed_login/del','pid'=>46,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];

                $data[] =['id'=>49,'name' => '禁止访问','route' =>'admin/banned/index','pid'=>45,'type'=>2,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>50,'name' => '禁止增加','route' =>'admin/banned/add','pid'=>49,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>51,'name' => '禁止修改','route' =>'admin/banned/edit','pid'=>49,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>52,'name' => '禁止删除','route' =>'admin/banned/del','pid'=>49,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];

                $data[] =['id'=>53,'name' => '文件管理','route' =>'admin/upload_file/index','pid'=>45,'type'=>2,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>54,'name' => '文件增加','route' =>'admin/upload_file/add','pid'=>53,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>55,'name' => '文件修改','route' =>'admin/upload_file/edit','pid'=>53,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>56,'name' => '文件删除','route' =>'admin/upload_file/del','pid'=>53,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];

                DB::table('admin_menu')->insert($data);

                DB::table('admin_role_menu')->truncate();
                $data=[];
                for($i=1;$i<=56;$i++){
                    $data[] =['role_id' => 1,'menu_id'=>$i];
                }
                for($i=31;$i<=56;$i++){
                    $data[] =['role_id' => 2,'menu_id'=>$i];
                }
                for($i=1;$i<=1;$i++){
                    $data[] =['role_id' => 3,'menu_id'=>$i];
                }
                DB::table('admin_role_menu')->insert($data);

                DB::table('admin_permission')->truncate();
                $data=[];
                $data[] =['id'=>1,'name' => '清除缓存','route' =>'admin/cache','pid'=>0,'type'=>2,'module_id'=>$this->module_id,'sort'=>0];
                DB::table('admin_permission')->insert($data);

                DB::table('admin_role_permission')->truncate();
                $data=[];
                for($i=1;$i<=1;$i++){
                    $data[] =['role_id' => 1,'permission_id'=>$i];
                }
                DB::table('admin_role_permission')->insert($data);

                DB::table('admin_manager_role')->truncate();
                $data=[];
                $data[] =['uuid' => $manager->uuid,'role_id'=>1];
                $data[] =['uuid' => $manager->uuid,'role_id'=>2];
                DB::table('admin_manager_role')->insert($data);

                $data=[];
                $data[] =['name' => '状态','key'=>'status','module_id'=>$this->module_id];
                $data[] =['name' => '用户状态','key'=>'user_status','module_id'=>$this->module_id];
                $data[] =['name' => '用户性别','key'=>'user_gender','module_id'=>$this->module_id];
                $data[] =['name' => '是否','key'=>'yes_no','module_id'=>$this->module_id];
                $data[] =['name' => '数据权限','key'=>'data_perm','module_id'=>$this->module_id];
                $data[] =['name' => '菜单类型','key'=>'menu_type','module_id'=>$this->module_id];
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
                $data[] =['dict_id' => 5,'name'=>'自己','value'=>'1'];
                $data[] =['dict_id' => 5,'name'=>'本部门','value'=>'2'];
                $data[] =['dict_id' => 5,'name'=>'本部门及下属部门','value'=>'3'];
                $data[] =['dict_id' => 6,'name'=>'目录','value'=>'1'];
                $data[] =['dict_id' => 6,'name'=>'菜单','value'=>'2'];
                $data[] =['dict_id' => 6,'name'=>'按钮','value'=>'3'];
                DB::table('admin_dict_value')->insert($data);

                $data=[];
                $data[] =['id'=>1,'name' => 'admin-mod','key' => 'admin','status'=>1,'sort'=>0,'classname'=>'-'];
                $data[] =['id'=>2,'name' => 'common-mod','key' => 'common','status'=>0,'sort'=>0,'classname'=>'\Aphly\LaravelCommon\Models\Module'];
                $data[] =['id'=>4,'name' => 'payment-mod','key' => 'payment','status'=>0,'sort'=>0,'classname'=>'\Aphly\LaravelPayment\Models\Module'];
                $data[] =['id'=>101,'name' => 'novel-mod','key' => 'novel','status'=>0,'sort'=>0,'classname'=>'\Aphly\LaravelNovel\Models\Module'];
                $data[] =['id'=>102,'name' => 'shop-mod','key' => 'shop','status'=>0,'sort'=>0,'classname'=>'\Aphly\LaravelShop\Models\Module'];
                $data[] =['id'=>103,'name' => 'company-mod','key' => 'company','status'=>0,'sort'=>0,'classname'=>'\Aphly\LaravelCompany\Models\Module'];
                DB::table('admin_module')->insert($data);

                return '初始化成功！超级管理员帐户:'.$post['username'].' 密码:'.$password.' 登录地址：admin/login';
            }else{
                return '已初始化';
            }
        }else{
            return '不允许初始化';
        }
    }



}
