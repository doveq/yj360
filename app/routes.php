<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/*
Route::get('/', function()
{
	return View::make('hello');
});
*/


// 后台管理路由组
Route::group(array('prefix' => 'admin'), function(){
	// 需要使用完整命名空间
	Route::get('/test', '\Admin\IndexController@test');
	Route::Controller('/', '\Admin\IndexController');
});

Route::Controller('/', 'IndexController');
