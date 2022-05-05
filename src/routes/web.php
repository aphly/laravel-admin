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

Route::get('/admin/init', 'Aphly\LaravelAdmin\Controllers\InitController@index');

Route::middleware(['web'])->group(function () {

    Route::prefix('admin')->middleware(['managerAuth'])->group(function () {
        Route::match(['get', 'post'],'/login', 'Aphly\LaravelAdmin\Controllers\IndexController@login')->name('adminLogin');
        Route::get('/index', 'Aphly\LaravelAdmin\Controllers\IndexController@layout');
        Route::get('/logout', 'Aphly\LaravelAdmin\Controllers\IndexController@logout');
        Route::get('/cache', 'Aphly\LaravelAdmin\Controllers\IndexController@cache');

        Route::middleware(['rbac'])->group(function () {
            Route::get('/index/index', 'Aphly\LaravelAdmin\Controllers\IndexController@index');

            Route::get('/manager/index', 'Aphly\LaravelAdmin\Controllers\ManagerController@index');
            Route::match(['get', 'post'],'/manager/add', 'Aphly\LaravelAdmin\Controllers\ManagerController@add');
            Route::match(['get', 'post'],'/manager/{uuid}/edit', 'Aphly\LaravelAdmin\Controllers\ManagerController@edit')->where('uuid', '[0-9]+');
            Route::post('/manager/del', 'Aphly\LaravelAdmin\Controllers\ManagerController@del');
            Route::match(['get', 'post'],'/manager/{uuid}/role', 'Aphly\LaravelAdmin\Controllers\ManagerController@role')->where('uuid', '[0-9]+');

            Route::get('/user/index', 'Aphly\LaravelAdmin\Controllers\UserController@index');
            Route::match(['get', 'post'],'/user/{uuid}/edit', 'Aphly\LaravelAdmin\Controllers\UserController@edit')->where('uuid', '[0-9]+');
            Route::match(['get', 'post'],'/user/{uuid}/password', 'Aphly\LaravelAdmin\Controllers\UserController@password')->where('uuid', '[0-9]+');
            Route::post('/user/del', 'Aphly\LaravelAdmin\Controllers\UserController@del');
            Route::match(['get', 'post'],'/user/{uuid}/role', 'Aphly\LaravelAdmin\Controllers\UserController@role')->where('uuid', '[0-9]+');
            Route::match(['get', 'post'],'/user/{uuid}/avatar', 'Aphly\LaravelAdmin\Controllers\UserController@avatar')->where('uuid', '[0-9]+');

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

//            Route::get('/dictionary/index', 'Aphly\LaravelAdmin\Controllers\DictionaryController@index');
//            Route::match(['get', 'post'],'/dictionary/add', 'Aphly\LaravelAdmin\Controllers\DictionaryController@add');
//            Route::match(['get', 'post'],'/dictionary/{id}/edit', 'Aphly\LaravelAdmin\Controllers\DictionaryController@edit')->where('id', '[0-9]+');
//            Route::post('/dictionary/del', 'Aphly\LaravelAdmin\Controllers\DictionaryController@del');
//            Route::get('/dictionary/show', 'Aphly\LaravelAdmin\Controllers\DictionaryController@show');
//            Route::post('/dictionary/save', 'Aphly\LaravelAdmin\Controllers\DictionaryController@save');

            Route::get('/dict/index', 'Aphly\LaravelAdmin\Controllers\DictController@index');
            Route::get('/dict/form', 'Aphly\LaravelAdmin\Controllers\DictController@form');
            Route::post('/dict/save', 'Aphly\LaravelAdmin\Controllers\DictController@save');
            Route::post('/dict/del', 'Aphly\LaravelAdmin\Controllers\DictController@del');

            Route::get('/module/index', 'Aphly\LaravelAdmin\Controllers\ModuleController@index');
            Route::get('/module/form', 'Aphly\LaravelAdmin\Controllers\ModuleController@form');
            Route::post('/module/save', 'Aphly\LaravelAdmin\Controllers\ModuleController@save');
            Route::post('/module/del', 'Aphly\LaravelAdmin\Controllers\ModuleController@del');
        });
    });

});
