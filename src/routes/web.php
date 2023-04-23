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

    Route::prefix('admin')->group(function () {
        Route::get('blocked', 'Aphly\LaravelAdmin\Controllers\LoginController@blocked')->name('adminBlocked');
        Route::get('not_active', 'Aphly\LaravelAdmin\Controllers\LoginController@notActive')->name('adminNotActive');

        Route::middleware(['managerAuth'])->group(function () {
            Route::match(['get', 'post'], '/login', 'Aphly\LaravelAdmin\Controllers\LoginController@index')->name('adminLogin');
            Route::get('logout', 'Aphly\LaravelAdmin\Controllers\LoginController@logout');
            Route::get('role', 'Aphly\LaravelAdmin\Controllers\LoginController@role');
            Route::get('choose_role', 'Aphly\LaravelAdmin\Controllers\LoginController@chooseRole');

            Route::get('index', 'Aphly\LaravelAdmin\Controllers\HomeController@layout');
            Route::middleware(['rbac'])->group(function () {
                Route::get('home/index', 'Aphly\LaravelAdmin\Controllers\HomeController@index');
                Route::get('cache', 'Aphly\LaravelAdmin\Controllers\HomeController@cache');

                $route_arr = [
                    ['manager', '\ManagerController'], ['role', '\RoleController'], ['api', '\ApiController'],
                    ['menu', '\MenuController'], ['banned', '\BannedController'], ['config', '\ConfigController'], ['module', '\ModuleController'],
                    ['dict', '\DictController'],  ['level', '\LevelController']
                ];

                foreach ($route_arr as $val) {
                    Route::get( $val[0] . '/index', 'Aphly\LaravelAdmin\Controllers' . $val[1] . '@index');
                    Route::match(['get', 'post'],  $val[0] . '/add', 'Aphly\LaravelAdmin\Controllers' . $val[1] . '@add');
                    Route::match(['get', 'post'],  $val[0] . '/edit', 'Aphly\LaravelAdmin\Controllers' . $val[1] . '@edit');
                    Route::post( $val[0] . '/del', 'Aphly\LaravelAdmin\Controllers' . $val[1] . '@del');
                }

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

                Route::get('module/install', 'Aphly\LaravelAdmin\Controllers\ModuleController@install');

            });
        });
    });

});
