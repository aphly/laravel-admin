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

        Route::middleware(['rbac'])->group(function () {
            Route::get('/cache', 'Aphly\LaravelAdmin\Controllers\HomeController@cache');

            Route::get('/home/index', 'Aphly\LaravelAdmin\Controllers\HomeController@index');

			$route_arr = [
				['manager','\ManagerController'],['role','\RoleController'],['permission','\PermissionController'],
				['menu','\MenuController'],['banned','\BannedController'],['config','\ConfigController'],['module','\ModuleController'],
				['dict','\DictController']
			];

			foreach ($route_arr as $val){
				Route::get('/'.$val[0].'/index', 'Aphly\LaravelAdmin\Controllers'.$val[1].'@index');
				Route::match(['get', 'post'],'/'.$val[0].'/add', 'Aphly\LaravelAdmin\Controllers'.$val[1].'@add');
				Route::match(['get', 'post'],'/'.$val[0].'/edit', 'Aphly\LaravelAdmin\Controllers'.$val[1].'@edit');
				Route::post('/'.$val[0].'/del', 'Aphly\LaravelAdmin\Controllers'.$val[1].'@del');
			}

			Route::match(['get', 'post'],'/manager/role', 'Aphly\LaravelAdmin\Controllers\ManagerController@role');

			Route::match(['get', 'post'],'/role/{id}/permission', 'Aphly\LaravelAdmin\Controllers\RoleController@permission')->where('id', '[0-9]+');
			Route::match(['get', 'post'],'/role/{id}/menu', 'Aphly\LaravelAdmin\Controllers\RoleController@menu')->where('id', '[0-9]+');

			Route::get('/role/show', 'Aphly\LaravelAdmin\Controllers\RoleController@show');
			Route::get('/permission/show', 'Aphly\LaravelAdmin\Controllers\PermissionController@show');
			Route::get('/menu/show', 'Aphly\LaravelAdmin\Controllers\MenuController@show');

			Route::get('/module/install', 'Aphly\LaravelAdmin\Controllers\ModuleController@install');
		});
    });

});
