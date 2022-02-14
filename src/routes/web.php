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

Route::middleware(['web'])->group(function () {

    Route::prefix('admin')->middleware(['ManagerAuth'])->group(function () {
        Route::match(['get', 'post'],'/login', 'Aphly\LaravelAdmin\Controllers\AdminController@login');
        Route::get('/index', 'Aphly\LaravelAdmin\Controllers\AdminController@layout');
        Route::get('/index/index', 'Aphly\LaravelAdmin\Controllers\AdminController@index');
        Route::get('/logout', 'Aphly\LaravelAdmin\Controllers\AdminController@logout');

        Route::get('/manager/index', 'Aphly\LaravelAdmin\Controllers\ManagerController@index');
        Route::match(['get', 'post'],'/manager/add', 'Aphly\LaravelAdmin\Controllers\ManagerController@add');
        Route::match(['get', 'post'],'/manager/{id}/edit', 'Aphly\LaravelAdmin\Controllers\ManagerController@edit')->where('id', '[0-9]+');
        Route::post('/manager/{id}/del', 'Aphly\LaravelAdmin\Controllers\ManagerController@del')->where('id', '[0-9]+');

    });

});
