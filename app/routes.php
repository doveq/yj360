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


// 后台登录认证
Route::filter('adminLogin', function()
{
    if( !Auth::check() || Auth::user()->type != -1 || Auth::user()->status != 1 )
    {
        return Redirect::to('/admin/login');
    }
});

// 后台未登录可以访问页面
Route::get('/admin/login', 'LoginController@admin');
Route::post('/admin/doLogin', 'LoginController@doAdminLogin');

// 后台管理路由组,需要后台登录认证
Route::group(array('prefix' => 'admin', 'before' => 'adminLogin'), function(){

	// 开发使用，创建修改数据库
	Route::get('/sql', function(){
		$sql = new Sql();
		$sql->up();
		echo "sql ok !";
	});
	
	Route::get('/', '\Admin\IndexController@index');
	Route::get('/userList', '\Admin\UserController@showList');
});


// 前台路由
Route::get('/register', 'LoginController@register');
Route::post('/doRegister', 'LoginController@doRegister');
Route::get('/login', 'LoginController@index');
Route::post('/doLogin', 'LoginController@doLogin');
Route::get('/logout', 'LoginController@logout');
Route::get('/', 'IndexController@index');
