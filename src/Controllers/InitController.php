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
                DB::table('admin_manager')->truncate();
                $post['uuid'] = $post['token'] = Helper::uuid();
                $post['username'] = 'admin';
                $password = 'asdasd';
                $post['token_expire'] = time();
                $post['level_id'] = $this->level_id;
                $post['password'] = Hash::make($password);
                $manager = Manager::create($post);

                DB::table('admin_level')->truncate();
                $data=[];
                $data[] =['id'=>1,'name' => '系统平台','pid'=>0,'uuid'=>$manager->uuid,'type'=>1,'status'=>1,'module_id'=>$this->module_id];
                $data[] =['id'=>2,'name' => '管理中心','pid'=>1,'uuid'=>$manager->uuid,'type'=>1,'status'=>1,'module_id'=>$this->module_id];
                DB::table('admin_level')->insert($data);
                (new LevelPath)->rebuild();

                DB::table('admin_role')->truncate();
                $data=[];
                $data[] =['id'=>1,'name' => '超级管理员','level_id' => 1,'uuid'=>$manager->uuid,'data_perm' => 3,'module_id'=>$this->module_id];
                $data[] =['id'=>2,'name' => '管理员','level_id' => 2,'uuid'=>$manager->uuid,'data_perm' => 3,'module_id'=>$this->module_id];
                $data[] =['id'=>3,'name' => '默认角色','level_id' => 2,'uuid'=>$manager->uuid,'data_perm' => 1,'module_id'=>$this->module_id];
                DB::table('admin_role')->insert($data);

                DB::table('admin_menu')->truncate();
                $data=[];
                $data[] =['id'=>1,'name' => '清除缓存','route' =>'admin/cache','pid'=>0,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];

                $data[] =['id'=>3,'name' => '系统管理','route' =>'','pid'=>0,'type'=>1,'uuid'=>$manager->uuid,'module_id'=>$this->module_id,'sort'=>0];

                $data[] =['id'=>4,'name' => '权限管理','route' =>'','pid'=>3,'uuid'=>$manager->uuid,'type'=>1,'module_id'=>$this->module_id,'sort'=>60];

                $data[] =['id'=>5,'name' => '层级管理','route' =>'admin/level/index','pid'=>4,'uuid'=>$manager->uuid,'type'=>2,'module_id'=>$this->module_id,'sort'=>100];
                $data[] =['id'=>6,'name' => '层级增加','route' =>'admin/level/add','pid'=>5,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>7,'name' => '层级修改','route' =>'admin/level/edit','pid'=>5,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>8,'name' => '层级删除','route' =>'admin/level/del','pid'=>5,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>9,'name' => '层级树形','route' =>'admin/level/tree','pid'=>5,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>10,'name' => '层级重建','route' =>'admin/level/rebuild','pid'=>5,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];

                $data[] =['id'=>11,'name' => '用户管理','route' =>'admin/manager/index','pid'=>4,'uuid'=>$manager->uuid,'type'=>2,'module_id'=>$this->module_id,'sort'=>99];
                $data[] =['id'=>12,'name' => '用户增加','route' =>'admin/manager/add','pid'=>11,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>99];
                $data[] =['id'=>13,'name' => '用户修改','route' =>'admin/manager/edit','pid'=>12,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>99];
                $data[] =['id'=>14,'name' => '用户删除','route' =>'admin/manager/del','pid'=>13,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>99];
                $data[] =['id'=>15,'name' => '用户角色','route' =>'admin/manager/role','pid'=>14,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>99];

                $data[] =['id'=>16,'name' => '角色管理','route' =>'admin/role/index','pid'=>4,'uuid'=>$manager->uuid,'type'=>2,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>17,'name' => '角色增加','route' =>'admin/role/add','pid'=>16,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>18,'name' => '角色修改','route' =>'admin/role/edit','pid'=>16,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>19,'name' => '角色删除','route' =>'admin/role/del','pid'=>16,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>20,'name' => '角色接口','route' =>'admin/role/api','pid'=>16,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>21,'name' => '角色菜单','route' =>'admin/role/menu','pid'=>16,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>22,'name' => '角色树形','route' =>'admin/role/tree','pid'=>16,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];

                $data[] =['id'=>23,'name' => '菜单管理','route' =>'admin/menu/index','pid'=>4,'uuid'=>$manager->uuid,'type'=>2,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>24,'name' => '菜单增加','route' =>'admin/menu/add','pid'=>23,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>25,'name' => '菜单修改','route' =>'admin/menu/edit','pid'=>23,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>26,'name' => '菜单删除','route' =>'admin/menu/del','pid'=>23,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>27,'name' => '菜单树形','route' =>'admin/menu/tree','pid'=>23,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];

                $data[] =['id'=>28,'name' => '接口管理','route' =>'admin/api/index','pid'=>4,'uuid'=>$manager->uuid,'type'=>2,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>29,'name' => '接口增加','route' =>'admin/api/add','pid'=>28,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>30,'name' => '接口修改','route' =>'admin/api/edit','pid'=>28,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>31,'name' => '接口删除','route' =>'admin/api/del','pid'=>28,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>32,'name' => '接口树形','route' =>'admin/api/tree','pid'=>28,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];

                $data[] =['id'=>33,'name' => '基础设置','route' =>'','pid'=>3,'uuid'=>$manager->uuid,'type'=>1,'module_id'=>$this->module_id,'sort'=>90];

                $data[] =['id'=>34,'name' => '模块管理','route' =>'admin/module/index','pid'=>33,'uuid'=>$manager->uuid,'type'=>2,'module_id'=>$this->module_id,'sort'=>101];
                $data[] =['id'=>35,'name' => '模块增加','route' =>'admin/module/add','pid'=>34,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>36,'name' => '模块修改','route' =>'admin/module/edit','pid'=>34,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>37,'name' => '模块删除','route' =>'admin/module/del','pid'=>34,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>38,'name' => '模块安装','route' =>'admin/module/install','pid'=>34,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];

                $data[] =['id'=>39,'name' => '字典管理','route' =>'admin/dict/index','pid'=>33,'uuid'=>$manager->uuid,'type'=>2,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>40,'name' => '字典增加','route' =>'admin/dict/add','pid'=>39,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>41,'name' => '字典修改','route' =>'admin/dict/edit','pid'=>39,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>42,'name' => '字典删除','route' =>'admin/dict/del','pid'=>39,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];

                $data[] =['id'=>43,'name' => '配置管理','route' =>'admin/config/index','pid'=>33,'uuid'=>$manager->uuid,'type'=>2,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>44,'name' => '配置增加','route' =>'admin/config/add','pid'=>43,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>45,'name' => '配置修改','route' =>'admin/config/edit','pid'=>43,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>46,'name' => '配置删除','route' =>'admin/config/del','pid'=>43,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];

                $data[] =['id'=>47,'name' => '运营管理','route' =>'','pid'=>3,'uuid'=>$manager->uuid,'type'=>1,'module_id'=>$this->module_id,'sort'=>40];

                $data[] =['id'=>48,'name' => '错误登录','route' =>'admin/failed_login/index','pid'=>47,'uuid'=>$manager->uuid,'type'=>2,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>49,'name' => '错误修改','route' =>'admin/failed_login/edit','pid'=>48,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>50,'name' => '错误删除','route' =>'admin/failed_login/del','pid'=>48,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];

                $data[] =['id'=>51,'name' => '统计管理','route' =>'admin/statistics/index','pid'=>47,'uuid'=>$manager->uuid,'type'=>2,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>52,'name' => '统计详情','route' =>'admin/statistics/detail','pid'=>51,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>53,'name' => '统计删除','route' =>'admin/statistics/del','pid'=>51,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];

                $data[] =['id'=>55,'name' => '文件管理','route' =>'admin/upload_file/index','pid'=>47,'uuid'=>$manager->uuid,'type'=>2,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>56,'name' => '文件增加','route' =>'admin/upload_file/add','pid'=>55,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>57,'name' => '文件修改','route' =>'admin/upload_file/edit','pid'=>55,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>58,'name' => '文件删除','route' =>'admin/upload_file/del','pid'=>55,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];

                $data[] =['id'=>59,'name' => '公告管理','route' =>'admin/notice/index','pid'=>47,'uuid'=>$manager->uuid,'type'=>2,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>60,'name' => '公告增加','route' =>'admin/notice/add','pid'=>59,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>61,'name' => '公告修改','route' =>'admin/notice/edit','pid'=>59,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>62,'name' => '公告删除','route' =>'admin/notice/del','pid'=>59,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>63,'name' => '公告图片','route' =>'admin/notice/img','pid'=>59,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];

                $data[] =['id'=>2,'name' => '首页','route' =>'admin/home/index','pid'=>0,'uuid'=>$manager->uuid,'type'=>1,'module_id'=>$this->module_id,'sort'=>10000];

                $data[] =['id'=>64,'name' => '公告','route' =>'admin_client/notice/index','pid'=>2,'uuid'=>$manager->uuid,'type'=>2,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>65,'name' => '公告详情','route' =>'admin_client/notice/detail','pid'=>64,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];

                $data[] =['id'=>66,'name' => '消息','route' =>'admin_client/msg/index','pid'=>2,'uuid'=>$manager->uuid,'type'=>2,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>67,'name' => '消息详情','route' =>'admin_client/msg/detail','pid'=>66,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];

                $data[] =['id'=>68,'name' => '消息管理','route' =>'admin/msg/index','pid'=>47,'uuid'=>$manager->uuid,'type'=>2,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>69,'name' => '消息增加','route' =>'admin/msg/add','pid'=>68,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>70,'name' => '消息修改','route' =>'admin/msg/edit','pid'=>68,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>71,'name' => '消息删除','route' =>'admin/msg/del','pid'=>68,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>72,'name' => '消息图片','route' =>'admin/msg/img','pid'=>68,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];

                $data[] =['id'=>73,'name' => '工单管理','route' =>'admin/work_order/index','pid'=>47,'uuid'=>$manager->uuid,'type'=>2,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>74,'name' => '工单回复','route' =>'admin/work_order/edit','pid'=>73,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>75,'name' => '工单删除','route' =>'admin/work_order/del','pid'=>73,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];

                $data[] =['id'=>76,'name' => '工单','route' =>'admin_client/work_order/index','pid'=>2,'uuid'=>$manager->uuid,'type'=>2,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>77,'name' => '工单提交','route' =>'admin_client/work_order/add','pid'=>76,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>78,'name' => '工单查看','route' =>'admin_client/work_order/edit','pid'=>76,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];
                $data[] =['id'=>79,'name' => '工单删除','route' =>'admin_client/work_order/del','pid'=>76,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$this->module_id,'sort'=>0];

                DB::table('admin_menu')->insert($data);

                DB::table('admin_role_menu')->truncate();
                $data=[];
                for($i=1;$i<=79;$i++){
                    $data[] =['role_id' => 1,'menu_id'=>$i];
                }
                for($i=31;$i<=79;$i++){
                    $data[] =['role_id' => 2,'menu_id'=>$i];
                }
                for($i=1;$i<=1;$i++){
                    $data[] =['role_id' => 3,'menu_id'=>$i];
                }
                DB::table('admin_role_menu')->insert($data);

//                DB::table('admin_api')->truncate();
//                $data=[];
//                $data[] =['id'=>1,'name' => '清除缓存','route' =>'admin/cache','pid'=>0,'type'=>2,'module_id'=>$this->module_id,'sort'=>0];
//                DB::table('admin_api')->insert($data);

//                DB::table('admin_role_api')->truncate();
//                $data=[];
//                for($i=1;$i<=1;$i++){
//                    $data[] =['role_id' => 1,'api_id'=>$i];
//                }
//                DB::table('admin_role_api')->insert($data);

                DB::table('admin_manager_role')->truncate();
                $data=[];
                $data[] =['uuid' => $manager->uuid,'role_id'=>1];
                $data[] =['uuid' => $manager->uuid,'role_id'=>2];
                DB::table('admin_manager_role')->insert($data);

                $data=[];
                $data[] =['name' => '状态','uuid'=>$manager->uuid,'key'=>'status','module_id'=>$this->module_id];
                $data[] =['name' => '用户状态','uuid'=>$manager->uuid,'key'=>'user_status','module_id'=>$this->module_id];
                $data[] =['name' => '用户性别','uuid'=>$manager->uuid,'key'=>'user_gender','module_id'=>$this->module_id];
                $data[] =['name' => '是否','uuid'=>$manager->uuid,'key'=>'yes_no','module_id'=>$this->module_id];
                $data[] =['name' => '数据权限','uuid'=>$manager->uuid,'key'=>'data_perm','module_id'=>$this->module_id];
                $data[] =['name' => '菜单类型','uuid'=>$manager->uuid,'key'=>'menu_type','module_id'=>$this->module_id];
                DB::table('admin_dict')->insert($data);

                $data=[];
                $data[] =['dict_id' => 1,'name'=>'开启','value'=>'1'];
                $data[] =['dict_id' => 1,'name'=>'关闭','value'=>'0'];
                $data[] =['dict_id' => 2,'name'=>'正常','value'=>'1'];
                $data[] =['dict_id' => 2,'name'=>'冻结','value'=>'2'];
                $data[] =['dict_id' => 3,'name'=>'男','value'=>'1'];
                $data[] =['dict_id' => 3,'name'=>'女','value'=>'2'];
                $data[] =['dict_id' => 4,'name'=>'是','value'=>'1'];
                $data[] =['dict_id' => 4,'name'=>'否','value'=>'0'];
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
