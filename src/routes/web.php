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
    Route::match(['get', 'post'],'/s', 'Aphly\LaravelAdmin\Controllers\TestController@index');

    Route::prefix('admin')->group(function () {
        Route::get('/manager/index', 'Aphly\LaravelAdmin\Controllers\ManagerController@index');
        Route::match(['get', 'post'],'/manager/add', 'Aphly\LaravelAdmin\Controllers\ManagerController@add');
    });
});

Route::middleware(['web'])->group(function () {
    Route::match(['get', 'post'],'/admin/login', 'Aphly\LaravelAdmin\Controllers\AdminController@login');

    Route::middleware(['ManagerAuth'])->group(function () {
        Route::get('/admin/index', 'Aphly\LaravelAdmin\Controllers\AdminController@index');
        Route::get('/admin/logout', 'Aphly\LaravelAdmin\Controllers\AdminController@logout');
    });
});
