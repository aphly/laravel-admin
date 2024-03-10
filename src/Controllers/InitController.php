<?php

namespace Aphly\LaravelAdmin\Controllers;

use Aphly\Laravel\Libs\Helper;
use Aphly\Laravel\Models\Comm;
use Aphly\Laravel\Models\LevelPath;
use Aphly\Laravel\Models\Manager;
use Aphly\Laravel\Models\Menu;
use Aphly\Laravel\Models\Module;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InitController extends Controller
{
    public $level_id = 1;

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

                DB::table('admin_comm')->truncate();
                $app = Comm::create(['name'=>'本地','host'=>config('base.local_host'),'auth_key'=>time(),'status'=>1]);
                if(!$app->id) {
                    return '本地已存在';
                }
                $module = Module::create(['name' => 'admin', 'classname' => 'Aphly\LaravelAdmin', 'comm_id' => $app->id, 'status' => 1]);
                if(!$module->id){
                    return '模块已存在';
                }
                DB::table('admin_level')->truncate();
                $data = [];
                $data[] = ['id' => 1, 'name' => '系统平台', 'pid' => 0, 'uuid' => $manager->uuid, 'type' => 1, 'status' => 1, 'module_id' => $module->id];
                $data[] = ['id' => 2, 'name' => '管理中心', 'pid' => 1, 'uuid' => $manager->uuid, 'type' => 1, 'status' => 1, 'module_id' => $module->id];
                DB::table('admin_level')->insert($data);
                (new LevelPath)->rebuild();

                DB::table('admin_role')->truncate();
                $data = [];
                $data[] = ['id' => 1, 'name' => '超级管理员', 'level_id' => 1, 'uuid' => $manager->uuid, 'data_perm' => 3, 'module_id' => $module->id];
                $data[] = ['id' => 2, 'name' => '管理员', 'level_id' => 2, 'uuid' => $manager->uuid, 'data_perm' => 3, 'module_id' => $module->id];
                DB::table('admin_role')->insert($data);

                DB::table('admin_menu')->truncate();
                Menu::create(['name' => '清除缓存', 'route' => 'admin/cache', 'pid' => 0, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0]);
                $menu = Menu::create(['name' => '首页', 'route' => 'admin/home/index', 'pid' => 0, 'uuid' => $manager->uuid, 'type' => 1, 'module_id' => $module->id, 'sort' => 10000]);
                if ($menu) {
                    $menu2 = Menu::create(['name' => '公告', 'route' => 'admin_client/notice/index', 'pid' => $menu->id, 'uuid' => $manager->uuid, 'type' => 2, 'module_id' => $module->id, 'sort' => 0]);
                    if ($menu2) {
                        Menu::create(['name' => '公告详情', 'route' => 'admin_client/notice/detail', 'pid' => $menu2->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0]);
                    }

                    $menu2 = Menu::create(['name' => '消息', 'route' => 'admin_client/msg/index', 'pid' => $menu->id, 'uuid' => $manager->uuid, 'type' => 2, 'module_id' => $module->id, 'sort' => 0]);
                    if ($menu2) {
                        Menu::create(['name' => '消息详情', 'route' => 'admin_client/msg/detail', 'pid' => $menu2->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0]);
                    }

                }

                $menu = Menu::create(['name' => '系统管理', 'route' => '', 'pid' => 0, 'type' => 1, 'uuid' => $manager->uuid, 'module_id' => $module->id, 'sort' => 0]);
                if ($menu) {
                    $menu2 = Menu::create(['name' => '权限管理', 'route' => '', 'pid' => $menu->id, 'uuid' => $manager->uuid, 'type' => 1, 'module_id' => $module->id, 'sort' => 60]);
                    if ($menu2) {
                        $menu3 = Menu::create(['name' => '层级管理', 'route' => 'admin/level/index', 'pid' => $menu2->id, 'uuid' => $manager->uuid, 'type' => 2, 'module_id' => $module->id, 'sort' => 100]);
                        if ($menu3) {
                            $data = [];
                            $data[] = ['name' => '层级增加', 'route' => 'admin/level/add', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0];
                            $data[] = ['name' => '层级修改', 'route' => 'admin/level/edit', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0];
                            $data[] = ['name' => '层级删除', 'route' => 'admin/level/del', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0];
                            $data[] = ['name' => '层级树形', 'route' => 'admin/level/tree', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0];
                            $data[] = ['name' => '层级重建', 'route' => 'admin/level/rebuild', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0];
                            DB::table('admin_menu')->insert($data);
                        }

                        $menu3 = Menu::create(['name' => '管理员', 'route' => 'admin/manager/index', 'pid' => $menu2->id, 'uuid' => $manager->uuid, 'type' => 2, 'module_id' => $module->id, 'sort' => 99]);
                        if ($menu3) {
                            $data = [];
                            $data[] = ['name' => '管理员增加', 'route' => 'admin/manager/add', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 99];
                            $data[] = ['name' => '管理员修改', 'route' => 'admin/manager/edit', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 99];
                            $data[] = ['name' => '管理员删除', 'route' => 'admin/manager/del', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 99];
                            $data[] = ['name' => '管理员角色', 'route' => 'admin/manager/role', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 99];
                            DB::table('admin_menu')->insert($data);
                        }

                        $menu3 = Menu::create(['name' => '角色管理', 'route' => 'admin/role/index', 'pid' => $menu2->id, 'uuid' => $manager->uuid, 'type' => 2, 'module_id' => $module->id, 'sort' => 0]);
                        if ($menu3) {
                            $data = [];
                            $data[] = ['name' => '角色增加', 'route' => 'admin/role/add', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0];
                            $data[] = ['name' => '角色修改', 'route' => 'admin/role/edit', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0];
                            $data[] = ['name' => '角色删除', 'route' => 'admin/role/del', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0];
                            $data[] = ['name' => '角色接口', 'route' => 'admin/role/api', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0];
                            $data[] = ['name' => '角色菜单', 'route' => 'admin/role/menu', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0];
                            $data[] = ['name' => '角色树形', 'route' => 'admin/role/tree', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0];
                            DB::table('admin_menu')->insert($data);
                        }

                        $menu3 = Menu::create(['name' => '菜单管理', 'route' => 'admin/menu/index', 'pid' => $menu2->id, 'uuid' => $manager->uuid, 'type' => 2, 'module_id' => $module->id, 'sort' => 0]);
                        if ($menu3) {
                            $data = [];
                            $data[] = ['name' => '菜单增加', 'route' => 'admin/menu/add', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0];
                            $data[] = ['name' => '菜单修改', 'route' => 'admin/menu/edit', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0];
                            $data[] = ['name' => '菜单删除', 'route' => 'admin/menu/del', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0];
                            $data[] = ['name' => '菜单树形', 'route' => 'admin/menu/tree', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0];
                            DB::table('admin_menu')->insert($data);
                        }

                        $menu3 = Menu::create(['name' => '接口管理', 'route' => 'admin/api/index', 'pid' => $menu2->id, 'uuid' => $manager->uuid, 'type' => 2, 'module_id' => $module->id, 'sort' => 0]);
                        if ($menu3) {
                            $data = [];
                            $data[] = ['name' => '接口增加', 'route' => 'admin/api/add', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0];
                            $data[] = ['name' => '接口修改', 'route' => 'admin/api/edit', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0];
                            $data[] = ['name' => '接口删除', 'route' => 'admin/api/del', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0];
                            $data[] = ['name' => '接口树形', 'route' => 'admin/api/tree', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0];
                            DB::table('admin_menu')->insert($data);
                        }
                    }

                    $menu2 = Menu::create(['name' => '基础设置', 'route' => '', 'pid' => $menu->id, 'uuid' => $manager->uuid, 'type' => 1, 'module_id' => $module->id, 'sort' => 90]);
                    if ($menu2) {
                        $menu3 = Menu::create(['name' => '通信管理', 'route' => 'admin/comm/index', 'pid' => $menu2->id, 'uuid' => $manager->uuid, 'type' => 2, 'module_id' => $module->id, 'sort' => 101]);
                        if ($menu3) {
                            $data = [];
                            $data[] = ['name' => '通信增加', 'route' => 'admin/comm/add', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0];
                            $data[] = ['name' => '通信修改', 'route' => 'admin/comm/edit', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0];
                            $data[] = ['name' => '通信删除', 'route' => 'admin/comm/del', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0];
                            $data[] = ['name' => '通信模块', 'route' => 'admin/comm/module', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0];
                            DB::table('admin_menu')->insert($data);
                        }

                        $menu3 = Menu::create(['name' => '用户管理', 'route' => 'admin/user/index', 'pid' => $menu2->id, 'uuid' => $manager->uuid, 'type' => 2, 'module_id' => $module->id, 'sort' => 101]);
                        if ($menu3) {
                            $data=[];
                            $data[] =['name' => '用户编辑','route' =>'admin/user/edit','pid'=>$menu3->id,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$module->id,'sort'=>0];
                            $data[] =['name' => '用户密码','route' =>'admin/user/password','pid'=>$menu3->id,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$module->id,'sort'=>0];
                            $data[] =['name' => '用户删除','route' =>'admin/user/del','pid'=>$menu3->id,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$module->id,'sort'=>0];
                            $data[] =['name' => '用户头像','route' =>'admin/user/avatar','pid'=>$menu3->id,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$module->id,'sort'=>0];
                            $data[] =['name' => '邮箱校验','route' =>'admin/user/verify','pid'=>$menu3->id,'uuid'=>$manager->uuid,'type'=>3,'module_id'=>$module->id,'sort'=>0];
                            DB::table('admin_menu')->insert($data);
                        }

                        $menu3 = Menu::create(['name' => '导航管理', 'route' => 'admin/links/index', 'pid' => $menu2->id, 'uuid' => $manager->uuid, 'type' => 2, 'module_id' => $module->id, 'sort' => 0]);
                        if ($menu3) {
                            $data = [];
                            $data[] = ['name' => '导航增加', 'route' => 'admin/links/add', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0];
                            $data[] = ['name' => '导航修改', 'route' => 'admin/links/edit', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0];
                            $data[] = ['name' => '导航删除', 'route' => 'admin/links/del', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0];
                            $data[] = ['name' => '导航树形', 'route' => 'admin/links/tree', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0];
                            DB::table('admin_menu')->insert($data);
                        }

                        $menu3 = Menu::create(['name' => '字典管理', 'route' => 'admin/dict/index', 'pid' => $menu2->id, 'uuid' => $manager->uuid, 'type' => 2, 'module_id' => $module->id, 'sort' => 0]);
                        if ($menu3) {
                            $data = [];
                            $data[] = ['name' => '字典增加', 'route' => 'admin/dict/add', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0];
                            $data[] = ['name' => '字典修改', 'route' => 'admin/dict/edit', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0];
                            $data[] = ['name' => '字典删除', 'route' => 'admin/dict/del', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0];
                            DB::table('admin_menu')->insert($data);
                        }

                        $menu3 = Menu::create(['name' => '配置管理', 'route' => 'admin/config/index', 'pid' => $menu2->id, 'uuid' => $manager->uuid, 'type' => 2, 'module_id' => $module->id, 'sort' => 0]);
                        if ($menu3) {
                            $data = [];
                            $data[] = ['name' => '配置增加', 'route' => 'admin/config/add', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0];
                            $data[] = ['name' => '配置修改', 'route' => 'admin/config/edit', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0];
                            $data[] = ['name' => '配置删除', 'route' => 'admin/config/del', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0];
                            DB::table('admin_menu')->insert($data);
                        }

                    }

                    $menu2 = Menu::create(['name' => '运营管理', 'route' => '', 'pid' => $menu->id, 'uuid' => $manager->uuid, 'type' => 1, 'module_id' => $module->id, 'sort' => 40]);
                    if ($menu2) {
                        $menu3 = Menu::create(['name' => '错误登录', 'route' => 'admin/failed_login/index', 'pid' => $menu2->id, 'uuid' => $manager->uuid, 'type' => 2, 'module_id' => $module->id, 'sort' => 0]);
                        if ($menu3) {
                            $data = [];
                            $data[] = ['name' => '错误修改', 'route' => 'admin/failed_login/edit', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0];
                            $data[] = ['name' => '错误删除', 'route' => 'admin/failed_login/del', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0];
                            DB::table('admin_menu')->insert($data);
                        }

                        $menu3 = Menu::create(['name' => '文件管理', 'route' => 'admin/upload_file/index', 'pid' => $menu2->id, 'uuid' => $manager->uuid, 'type' => 2, 'module_id' => $module->id, 'sort' => 0]);
                        if ($menu3) {
                            $data = [];
                            $data[] = ['name' => '文件增加', 'route' => 'admin/upload_file/add', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0];
                            $data[] = ['name' => '文件修改', 'route' => 'admin/upload_file/edit', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0];
                            $data[] = ['name' => '文件删除', 'route' => 'admin/upload_file/del', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0];
                            DB::table('admin_menu')->insert($data);
                        }

                        $menu3 = Menu::create(['name' => '公告管理', 'route' => 'admin/notice/index', 'pid' => $menu2->id, 'uuid' => $manager->uuid, 'type' => 2, 'module_id' => $module->id, 'sort' => 0]);
                        if ($menu3) {
                            $data = [];
                            $data[] = ['name' => '公告增加', 'route' => 'admin/notice/add', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0];
                            $data[] = ['name' => '公告修改', 'route' => 'admin/notice/edit', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0];
                            $data[] = ['name' => '公告删除', 'route' => 'admin/notice/del', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0];
                            $data[] = ['name' => '公告图片', 'route' => 'admin/notice/img', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0];
                            DB::table('admin_menu')->insert($data);
                        }

                        $menu3 = Menu::create(['name' => '消息管理', 'route' => 'admin/msg/index', 'pid' => $menu2->id, 'uuid' => $manager->uuid, 'type' => 2, 'module_id' => $module->id, 'sort' => 0]);
                        if ($menu3) {
                            $data = [];
                            $data[] = ['name' => '消息增加', 'route' => 'admin/msg/add', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0];
                            $data[] = ['name' => '消息修改', 'route' => 'admin/msg/edit', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0];
                            $data[] = ['name' => '消息删除', 'route' => 'admin/msg/del', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0];
                            $data[] = ['name' => '消息图片', 'route' => 'admin/msg/img', 'pid' => $menu3->id, 'uuid' => $manager->uuid, 'type' => 3, 'module_id' => $module->id, 'sort' => 0];
                            DB::table('admin_menu')->insert($data);
                        }

                    }

                }

                DB::table('admin_role_menu')->truncate();
                $menuData = Menu::where(['module_id' => $module->id])->get();
                $data = [];
                foreach ($menuData as $val) {
                    $data[] = ['role_id' => 1, 'menu_id' => $val->id];
                }
                foreach ($menuData as $val) {
                    $data[] = ['role_id' => 2, 'menu_id' => $val->id];
                }
                DB::table('admin_role_menu')->insert($data);

                DB::table('admin_manager_role')->truncate();
                $data = [];
                $data[] = ['uuid' => $manager->uuid, 'role_id' => 1];
                $data[] = ['uuid' => $manager->uuid, 'role_id' => 2];
                DB::table('admin_manager_role')->insert($data);

                $data = [];
                $data[] = ['name' => '状态', 'uuid' => $manager->uuid, 'key' => 'status', 'module_id' => $module->id];
                $data[] = ['name' => '用户状态', 'uuid' => $manager->uuid, 'key' => 'user_status', 'module_id' => $module->id];
                $data[] = ['name' => '用户性别', 'uuid' => $manager->uuid, 'key' => 'user_gender', 'module_id' => $module->id];
                $data[] = ['name' => '是否', 'uuid' => $manager->uuid, 'key' => 'yes_no', 'module_id' => $module->id];
                $data[] = ['name' => '数据权限', 'uuid' => $manager->uuid, 'key' => 'data_perm', 'module_id' => $module->id];
                $data[] = ['name' => '菜单类型', 'uuid' => $manager->uuid, 'key' => 'menu_type', 'module_id' => $module->id];
                DB::table('admin_dict')->insert($data);

                $data = [];
                $data[] = ['dict_id' => 1, 'name' => '开启', 'value' => '1'];
                $data[] = ['dict_id' => 1, 'name' => '关闭', 'value' => '0'];
                $data[] = ['dict_id' => 2, 'name' => '正常', 'value' => '1'];
                $data[] = ['dict_id' => 2, 'name' => '冻结', 'value' => '2'];
                $data[] = ['dict_id' => 3, 'name' => '男', 'value' => '1'];
                $data[] = ['dict_id' => 3, 'name' => '女', 'value' => '2'];
                $data[] = ['dict_id' => 4, 'name' => '是', 'value' => '1'];
                $data[] = ['dict_id' => 4, 'name' => '否', 'value' => '0'];
                $data[] = ['dict_id' => 5, 'name' => '自己', 'value' => '1'];
                $data[] = ['dict_id' => 5, 'name' => '本部门', 'value' => '2'];
                $data[] = ['dict_id' => 5, 'name' => '本部门及下属部门', 'value' => '3'];
                $data[] = ['dict_id' => 6, 'name' => '目录', 'value' => '1'];
                $data[] = ['dict_id' => 6, 'name' => '菜单', 'value' => '2'];
                $data[] = ['dict_id' => 6, 'name' => '按钮', 'value' => '3'];
                DB::table('admin_dict_value')->insert($data);

                return '初始化成功！超级管理员帐户:' . $post['username'] . ' 密码:' . $password . ' 登录地址：admin/login';

            }else{
                return '已初始化';
            }
        }else{
            return '不允许初始化';
        }
    }



}
