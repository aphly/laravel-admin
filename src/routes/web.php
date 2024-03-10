<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('admin/init', 'Aphly\LaravelAdmin\Controllers\InitController@index');

Route::middleware(['web'])->group(function () {

    Route::prefix('admin_client')->group(function () {
        Route::get('notice/index', 'Aphly\LaravelAdmin\Controllers\Client\NoticeController@index');
        Route::get('notice/detail', 'Aphly\LaravelAdmin\Controllers\Client\NoticeController@detail');

        Route::get('msg/index', 'Aphly\LaravelAdmin\Controllers\Client\MsgController@index');
        Route::get('msg/detail', 'Aphly\LaravelAdmin\Controllers\Client\MsgController@detail');
    });

    Route::prefix('admin')->group(function () {

        Route::middleware(['managerAuth'])->group(function () {

            Route::middleware(['rbac'])->group(function () {
                Route::get('home/index', 'Aphly\LaravelAdmin\Controllers\HomeController@index');

                $route_arr = [
                    ['manager', '\ManagerController'], ['role', '\RoleController'], ['api', '\ApiController'],
                    ['menu', '\MenuController'],  ['config', '\ConfigController'], ['module', '\ModuleController'],
                    ['dict', '\DictController'],  ['level', '\LevelController'],  ['notice', '\NoticeController'],
                    ['msg', '\MsgController'],['comm', '\CommController'],['links','\LinksController']
                ];

                foreach ($route_arr as $val) {
                    Route::get( $val[0] . '/index', 'Aphly\LaravelAdmin\Controllers' . $val[1] . '@index');
                    Route::match(['get', 'post'],  $val[0] . '/add', 'Aphly\LaravelAdmin\Controllers' . $val[1] . '@add');
                    Route::match(['get', 'post'],  $val[0] . '/edit', 'Aphly\LaravelAdmin\Controllers' . $val[1] . '@edit');
                    Route::post( $val[0] . '/del', 'Aphly\LaravelAdmin\Controllers' . $val[1] . '@del');
                }

                Route::match(['get', 'post'], 'comm/module', 'Aphly\LaravelAdmin\Controllers\CommController@module');

                $route_arr = [
                    ['failed_login', '\FailedLoginController'],['upload_file', '\UploadFileController'],
                ];

                foreach ($route_arr as $val) {
                    Route::get( $val[0] . '/index', 'Aphly\LaravelAdmin\Controllers' . $val[1] . '@index');
                    Route::match(['get', 'post'],  $val[0] . '/edit', 'Aphly\LaravelAdmin\Controllers' . $val[1] . '@edit');
                    Route::post( $val[0] . '/del', 'Aphly\LaravelAdmin\Controllers' . $val[1] . '@del');
                }

                Route::match(['get', 'post'], 'manager/role', 'Aphly\LaravelAdmin\Controllers\ManagerController@role');

                Route::match(['get', 'post'], 'role/api', 'Aphly\LaravelAdmin\Controllers\RoleController@api');
                Route::match(['get', 'post'], 'role/menu', 'Aphly\LaravelAdmin\Controllers\RoleController@menu');

                Route::get('role/tree', 'Aphly\LaravelAdmin\Controllers\RoleController@tree');
                Route::get('api/tree', 'Aphly\LaravelAdmin\Controllers\ApiController@tree');
                Route::get('menu/tree', 'Aphly\LaravelAdmin\Controllers\MenuController@tree');
                Route::get('level/tree', 'Aphly\LaravelAdmin\Controllers\LevelController@tree');
                Route::get('level/rebuild', 'Aphly\LaravelAdmin\Controllers\LevelController@rebuild');
                Route::get('links/tree', 'Aphly\LaravelAdmin\Controllers\LinksController@tree');


                Route::match(['post'],'notice/img', 'Aphly\LaravelAdmin\Controllers\NoticeController@uploadImg');
                Route::match(['post'],'msg/img', 'Aphly\LaravelAdmin\Controllers\MsgController@uploadImg');

                Route::get('module/install', 'Aphly\LaravelAdmin\Controllers\ModuleController@install');
                Route::get('module/import', 'Aphly\LaravelAdmin\Controllers\ModuleController@import');

                Route::get('user/index', 'Aphly\LaravelAdmin\Controllers\UserController@index');
                Route::match(['get', 'post'],'user/edit', 'Aphly\LaravelAdmin\Controllers\UserController@edit');
                Route::match(['get', 'post'],'user/password', 'Aphly\LaravelAdmin\Controllers\UserController@password');
                Route::post('user/del', 'Aphly\LaravelAdmin\Controllers\UserController@del');
                Route::match(['get', 'post'],'user/avatar', 'Aphly\LaravelAdmin\Controllers\UserController@avatar');
                Route::match(['get', 'post'],'user/verify', 'Aphly\LaravelAdmin\Controllers\UserController@verify');


            });
        });
    });

});
