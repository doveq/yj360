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
	Route::get('/login', 'LoginController@admin');
	Route::post('/doLogin', 'LoginController@doAdminLogin');
	Route::get('/', '\Admin\IndexController@index');
});

Route::get('/login', 'LoginController@index');
Route::get('/register', 'LoginController@register');
Route::post('/doRegister', 'LoginController@doRegister');
Route::get('/', 'IndexController@index');
