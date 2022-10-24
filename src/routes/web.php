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

Route::prefix('center')->middleware(['web'])->group(function () {
    Route::get('/seccode', 'Aphly\LaravelAdmin\Controllers\SeccodeController@index');
    Route::get('/seccode/{code}', 'Aphly\LaravelAdmin\Controllers\SeccodeController@check');
    Route::get('/banned', 'Aphly\LaravelAdmin\Controllers\BannedController@banned')->name('banned');
});

Route::get('/admin/init', 'Aphly\LaravelAdmin\Controllers\InitController@index');

Route::middleware(['web'])->group(function () {

    Route::prefix('admin')->middleware(['managerAuth'])->group(function () {
        Route::match(['get', 'post'],'/login', 'Aphly\LaravelAdmin\Controllers\HomeController@login')->name('adminLogin');
        Route::get('/index', 'Aphly\LaravelAdmin\Controllers\HomeController@layout');
        Route::get('/logout', 'Aphly\LaravelAdmin\Controllers\HomeController@logout');
        Route::get('/cache', 'Aphly\LaravelAdmin\Controllers\HomeController@cache');

        Route::middleware(['rbac'])->group(function () {
            Route::get('/home/index', 'Aphly\LaravelAdmin\Controllers\HomeController@index');

            Route::get('/manager/index', 'Aphly\LaravelAdmin\Controllers\ManagerController@index');
            Route::match(['get', 'post'],'/manager/add', 'Aphly\LaravelAdmin\Controllers\ManagerController@add');
            Route::match(['get', 'post'],'/manager/{uuid}/edit', 'Aphly\LaravelAdmin\Controllers\ManagerController@edit')->where('uuid', '[0-9]+');
            Route::post('/manager/del', 'Aphly\LaravelAdmin\Controllers\ManagerController@del');
            Route::match(['get', 'post'],'/manager/{uuid}/role', 'Aphly\LaravelAdmin\Controllers\ManagerController@role')->where('uuid', '[0-9]+');

            Route::get('/role/index', 'Aphly\LaravelAdmin\Controllers\RoleController@index');
            Route::match(['get', 'post'],'/role/add', 'Aphly\LaravelAdmin\Controllers\RoleController@add');
            Route::match(['get', 'post'],'/role/{id}/edit', 'Aphly\LaravelAdmin\Controllers\RoleController@edit')->where('id', '[0-9]+');
            Route::post('/role/del', 'Aphly\LaravelAdmin\Controllers\RoleController@del');
            Route::match(['get', 'post'],'/role/{id}/permission', 'Aphly\LaravelAdmin\Controllers\RoleController@permission')->where('id', '[0-9]+');
            Route::match(['get', 'post'],'/role/{id}/menu', 'Aphly\LaravelAdmin\Controllers\RoleController@menu')->where('id', '[0-9]+');
            Route::get('/role/show', 'Aphly\LaravelAdmin\Controllers\RoleController@show');
            Route::post('/role/save', 'Aphly\LaravelAdmin\Controllers\RoleController@save');

            Route::get('/permission/index', 'Aphly\LaravelAdmin\Controllers\PermissionController@index');
            Route::match(['get', 'post'],'/permission/add', 'Aphly\LaravelAdmin\Controllers\PermissionController@add');
            Route::match(['get', 'post'],'/permission/{id}/edit', 'Aphly\LaravelAdmin\Controllers\PermissionController@edit')->where('id', '[0-9]+');
            Route::post('/permission/del', 'Aphly\LaravelAdmin\Controllers\PermissionController@del');
            Route::get('/permission/show', 'Aphly\LaravelAdmin\Controllers\PermissionController@show');
            Route::post('/permission/save', 'Aphly\LaravelAdmin\Controllers\PermissionController@save');

            Route::get('/menu/index', 'Aphly\LaravelAdmin\Controllers\MenuController@index');
            Route::match(['get', 'post'],'/menu/add', 'Aphly\LaravelAdmin\Controllers\MenuController@add');
            Route::match(['get', 'post'],'/menu/{id}/edit', 'Aphly\LaravelAdmin\Controllers\MenuController@edit')->where('id', '[0-9]+');
            Route::post('/menu/del', 'Aphly\LaravelAdmin\Controllers\MenuController@del');
            Route::get('/menu/show', 'Aphly\LaravelAdmin\Controllers\MenuController@show');
            Route::post('/menu/save', 'Aphly\LaravelAdmin\Controllers\MenuController@save');

            $route_arr = [
                ['dict','\DictController'],['module','\ModuleController'],['config','\ConfigController'],['banned','\BannedController']
            ];

            Route::get('/module/install', 'Aphly\LaravelAdmin\Controllers\ModuleController@install');

            foreach ($route_arr as $val){
                Route::get('/'.$val[0].'/index', 'Aphly\LaravelAdmin\Controllers'.$val[1].'@index');
                Route::get('/'.$val[0].'/form', 'Aphly\LaravelAdmin\Controllers'.$val[1].'@form');
                Route::post('/'.$val[0].'/save', 'Aphly\LaravelAdmin\Controllers'.$val[1].'@save');
                Route::post('/'.$val[0].'/del', 'Aphly\LaravelAdmin\Controllers'.$val[1].'@del');
            }

        });
    });

});
