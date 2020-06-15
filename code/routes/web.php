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
|这里是您可以为您的应用程序******注册web路由******的地方。这些
|路由由RouteServiceProvider在其中一个组中加载
|包含“web”中间件组。现在创造一些伟大的东西!
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login','ProjectController@login');
Route::post('/check_login','ProjectController@check_login');
Route::any('/index','ProjectController@index');

Route::get('/out','ProjectController@out');

Route::get('/register','ProjectController@register');
Route::post('/check_register','ProjectController@check_register');
Route::any('/check_user','ProjectController@check_user');
Route::any('/insert','ProjectController@insert');

Route::any('/add_thing','ProjectController@add_thing');
Route::any('/add_thing_op','ProjectController@add_thing_op');

Route::any('/delete_thing','ProjectController@delete_thing');

Route::any('/update_thing','ProjectController@update_thing');
Route::any('/update_thing_op','ProjectController@update_thing_op');


Route::any('/accept','ProjectController@accept');
Route::any('/un_accept','ProjectController@un_accept');

Route::any('/list','ProjectController@list');
Route::any('/list_do','ProjectController@list_do');
Route::any('/list_end','ProjectController@list_end');
Route::any('/del_list_end','ProjectController@del_list_end');
Route::any('/list_all','ProjectController@list_all');
Route::any('/add_list','ProjectController@add_list');
Route::any('/add_list_op','ProjectController@add_list_op');
Route::any('/update_list','ProjectController@update_list');
Route::any('/update_list_op','ProjectController@update_list_op');


Route::any('/delSelect','ProjectController@delSelect');

Route::any('/find_friend','ProjectController@find_friend');
Route::any('/add_friend','ProjectController@add_friend');
Route::any('/delete_friend','ProjectController@delete_friend');
