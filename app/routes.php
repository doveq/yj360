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


// 前台登录认证
Route::filter('indexLogin', function()
{
    if( !Auth::check() || Auth::user()->status != 1 )
    {
        return Redirect::to('/login');
    }
});


// 开发使用，创建修改数据库
Route::get('/admin/sql', function(){
	$sql = new Sql();
	$sql->up();
	echo "sql ok !";
});

// 后台未登录可以访问页面
Route::get('/admin/login', 'LoginController@admin');
Route::post('/admin/doLogin', 'LoginController@doAdminLogin');
Route::get('/admin/prompt', '\Admin\PromptController@index');

// 后台管理路由组,需要后台登录认证
Route::group(array('prefix' => 'admin', 'before' => 'adminLogin'), function(){
	Route::get('/', '\Admin\IndexController@index');
	Route::get('/userList', '\Admin\UserController@showList');
	Route::get('/userEdit/{id}', '\Admin\UserController@showEdit');
	Route::post('/doUserEdit', '\Admin\UserController@doEdit');
	Route::post('/doUserDel', '\Admin\UserController@doDel');

<<<<<<< HEAD
    // Route::get('/subjectList', '\Admin\SubjectController@showList');
    // Route::get('/subjectAdd', '\Admin\SubjectController@showAdd');
    // Route::get('/subjectEdit/{id}', '\Admin\SubjectController@showEdit');
    // Route::post('/doSubjectAdd', '\Admin\SubjectController@doAdd');
    // Route::post('/doSubjectEdit', '\Admin\SubjectController@doEdit');
=======
    Route::get('/subjectList', '\Admin\SubjectController@showList');    
    Route::get('/subjectAdd', '\Admin\SubjectController@showAdd');
    Route::get('/subjectEdit/{id}', '\Admin\SubjectController@showEdit');
    Route::post('/doSubjectAdd', '\Admin\SubjectController@doAdd');
    Route::post('/doSubjectEdit', '\Admin\SubjectController@doEdit');
    
    Route::get('/topicList', '\Admin\TopicController@showList');
    Route::get('/topicAdd', '\Admin\TopicController@showAdd');
    Route::post('/doTopicAdd', '\Admin\TopicController@doAdd');
>>>>>>> FETCH_HEAD
});

Route::group(array('prefix' => 'admin', 'before' => 'adminLogin'), function(){
    Route::resource('/subject', '\Admin\SubjectController');
    Route::resource('/subject_item', '\Admin\SubjectItemController');
});

// 前台路由
Route::get('/register', 'LoginController@register');
Route::post('/doRegister', 'LoginController@doRegister');
Route::get('/login', 'LoginController@index');
Route::post('/doLogin', 'LoginController@doLogin');
Route::get('/logout', 'LoginController@logout');
Route::get('/', 'IndexController@index');

Route::group(array('before' => 'indexLogin'), function(){
	// flash录音
	Route::get('/recorder', 'RecorderController@index');
	Route::post('/recorder/upload', 'RecorderController@upload');
});



