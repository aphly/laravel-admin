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
Route::match(['get', 'post'],'/admin/test', 'Aphly\LaravelAdmin\Controllers\AdminController@test');

Route::middleware(['web'])->group(function () {

    Route::prefix('admin')->middleware(['ManagerAuth'])->group(function () {
        Route::match(['get', 'post'],'/login', 'Aphly\LaravelAdmin\Controllers\IndexController@login');
        Route::get('/index', 'Aphly\LaravelAdmin\Controllers\IndexController@layout');
        Route::get('/index/index', 'Aphly\LaravelAdmin\Controllers\IndexController@index');
        Route::get('/logout', 'Aphly\LaravelAdmin\Controllers\IndexController@logout');

        Route::get('/manager/index', 'Aphly\LaravelAdmin\Controllers\ManagerController@index');
        Route::match(['get', 'post'],'/manager/add', 'Aphly\LaravelAdmin\Controllers\ManagerController@add');
        Route::match(['get', 'post'],'/manager/{id}/edit', 'Aphly\LaravelAdmin\Controllers\ManagerController@edit')->where('id', '[0-9]+');
        Route::post('/manager/del', 'Aphly\LaravelAdmin\Controllers\ManagerController@del');
        Route::match(['get', 'post'],'/manager/{id}/role', 'Aphly\LaravelAdmin\Controllers\ManagerController@role')->where('id', '[0-9]+');

        Route::get('/role/index', 'Aphly\LaravelAdmin\Controllers\RoleController@index');
        Route::match(['get', 'post'],'/role/add', 'Aphly\LaravelAdmin\Controllers\RoleController@add');
        Route::match(['get', 'post'],'/role/{id}/edit', 'Aphly\LaravelAdmin\Controllers\RoleController@edit')->where('id', '[0-9]+');
        Route::post('/role/del', 'Aphly\LaravelAdmin\Controllers\RoleController@del');
        Route::match(['get', 'post'],'/role/{id}/permission', 'Aphly\LaravelAdmin\Controllers\RoleController@permission')->where('id', '[0-9]+');

        Route::get('/permission/index', 'Aphly\LaravelAdmin\Controllers\PermissionController@index');
        Route::match(['get', 'post'],'/permission/add', 'Aphly\LaravelAdmin\Controllers\PermissionController@add');
        Route::match(['get', 'post'],'/permission/{id}/edit', 'Aphly\LaravelAdmin\Controllers\PermissionController@edit')->where('id', '[0-9]+');
        Route::post('/permission/del', 'Aphly\LaravelAdmin\Controllers\PermissionController@del');

    });

});
