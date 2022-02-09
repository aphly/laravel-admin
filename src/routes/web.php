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

Route::get('/s', 'Aphly\LaravelAdmin\Controllers\AdminController@login');
Route::get('/admin/login', 'Aphly\LaravelAdmin\Controllers\AdminController@login');
//Route::get('/', function () {
//    dd('xxx');
//    return view("laravel-admin::test");
//});

//Route::get('/admin/login', 'Aphly\LaravelAdmin\Controllers\AdminController@login');
//
Route::middleware(['ManagerAuth'])->group(function () {
    Route::get('/admin/index', 'Aphly\LaravelAdmin\Controllers\AdminController@index');
    Route::get('/admin/logout', 'Aphly\LaravelAdmin\Controllers\AdminController@logout');
});
