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
	
	// 开发使用，创建修改数据
	Route::get('/sql', function(){
		$sql = new Sql();
		$sql->up();
		echo "sql ok !";
	});

	// 需要使用完整命名空间
	Route::get('/login', '\Admin\LoginController@index');
	Route::Controller('/', '\Admin\IndexController');
});

Route::Controller('/', 'IndexController');
