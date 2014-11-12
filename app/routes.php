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
	// Route::get('/userList', '\Admin\UserController@showList');
	// Route::get('/userEdit/{id}', '\Admin\UserController@showEdit');
	// Route::post('/doUserEdit', '\Admin\UserController@doEdit');
	// Route::post('/doUserDel', '\Admin\UserController@doDel');

    Route::get('/topic', '\Admin\TopicController@index');
    Route::get('/topic/add', '\Admin\TopicController@showAdd');
    Route::post('/topic/doAdd', '\Admin\TopicController@doAdd');
    Route::get('/topic/edit', '\Admin\TopicController@showEdit');
    Route::post('/topic/doEdit', '\Admin\TopicController@doEdit');
    Route::get('/topic/doDel', '\Admin\TopicController@doDel');
    Route::get('/topic/column', '\Admin\TopicController@showColumn');
    Route::get('/topic/exam', '\Admin\TopicController@showExam');

    // 试卷
    Route::get('/examPaper', '\Admin\ExamPaperController@index');
    Route::get('/examPaper/add', '\Admin\ExamPaperController@showAdd');
    Route::post('/examPaper/doAdd', '\Admin\ExamPaperController@doAdd');
    Route::get('/examPaper/edit', '\Admin\ExamPaperController@showEdit');
    Route::post('/examPaper/doEdit', '\Admin\ExamPaperController@doEdit');
    Route::post('/examPaper/editStatus', '\Admin\ExamPaperController@editStatus');
    Route::get('/examPaper/clist', '\Admin\ExamPaperController@showClist');
    Route::get('/examPaper/child', '\Admin\ExamPaperController@showChild');
    Route::get('/examPaper/child/edit', '\Admin\ExamPaperController@editClist');
    Route::get('/examPaper/qlist', '\Admin\ExamPaperController@showQlist');
    Route::post('/examPaper/del', '\Admin\ExamPaperController@doDel');
    Route::get('/examPaper/column', '\Admin\ExamPaperController@showColumn');
    Route::get('/examPaper/addColumn', '\Admin\ExamPaperController@showAddColumn');
    Route::post('/examPaper/doEditQuestion', '\Admin\ExamPaperController@doEditQuestion');

    Route::resource('examSort', 'Admin\ExamSortController');
});

Route::group(array('prefix' => 'admin', 'before' => 'adminLogin'), function(){
    Route::resource('user', 'Admin\UserController');
    // Route::resource('subject', 'Admin\SubjectController');
    // Route::resource('subject_item', 'Admin\SubjectItemController');
    // Route::resource('subject_item_relation', 'Admin\SubjectItemRelationController');
    // Route::resource('item_content', 'Admin\ItemContentController');
    // Route::resource('subject_content', 'Admin\SubjectContentController');
    // Route::resource('content_exam', 'Admin\ContentExamController');

    Route::resource('product', 'Admin\ProductController');
    Route::resource('log', 'Admin\LogController');
    Route::resource('loginlog', 'Admin\LoginlogController');
    Route::resource('textbook_item', 'Admin\TextbookItemController');

    Route::resource('classes', 'Admin\ClassesController');
    Route::resource('classmate', 'Admin\ClassmateController');

    Route::resource('message', 'Admin\MessageController');
    Route::resource('feedback', 'Admin\FeedbackController');
    Route::resource('favorite', 'Admin\FavoriteController');
    Route::resource('uploadbank', 'Admin\UploadbankController');
    Route::resource('training', 'Admin\TrainingController');

    Route::get('/column/question', 'Admin\ColumnController@questionList');
    Route::resource('column', 'Admin\ColumnController');
    Route::resource('sort', 'Admin\SortController');
    Route::resource('questions', 'Admin\QuestionsController');

    Route::get('/{column}.json', '\Admin\JsonController@index');

    Route::get('/select', 'Admin\SelectController@index');
    Route::post('/relation/sort', '\Admin\RelationController@postSort');
    Route::post('/relation/column', '\Admin\RelationController@postColumn');
    Route::post('/relation/do_question', '\Admin\RelationController@postDoQuestion');
    Route::post('/relation/del_question', '\Admin\RelationController@deleteColumn');
    Route::post('/relation/doExam', '\Admin\RelationController@doExam');
    Route::post('/relation/delExam', '\Admin\RelationController@delExam');
    Route::post('/relation/columnExam', '\Admin\RelationController@doColumnExam');
     Route::post('/relation/delColumnExam', '\Admin\RelationController@delColumnExam');
});

// 前台路由
Route::get('/register', 'LoginController@register');
Route::post('/doRegister', 'LoginController@doRegister');
Route::get('/login', 'LoginController@index');
Route::post('/doLogin', 'LoginController@doLogin');
Route::get('/login/ajax', 'LoginController@ajax');
Route::get('/logout', 'LoginController@logout');
Route::get('/', 'IndexController@index');
Route::get('/testmsg', 'MessageController@mobileMsg');
Route::get('/prompt', 'PromptController@index');
Route::get('/prompt/test', 'TestController@test');
Route::get('/forgot', 'LoginController@forgot');

Route::group(array('before' => 'indexLogin'), function(){
    //
    Route::get('/indexColumn', 'IndexController@column');
	// flash录音
	Route::get('/recorder', 'RecorderController@index');
	Route::post('/recorder/upload', 'RecorderController@upload');

    //我的班级
    Route::resource('classes', 'ClassesController');
    //训练集
    Route::resource('training', 'TrainingController');
    //班级同学对应
    Route::resource('classmate', 'ClassmateController');
    Route::post('/classmate/postDelete', 'ClassmateController@postDelete');
    Route::any('/classm/add_class', 'ClassmateController@addClass');
    Route::any('/classm/doAddClass', 'ClassmateController@doaddClass');
    Route::get('/training_result', 'TrainingResultController@index');
    //消息
    Route::resource('message', 'MessageController');
    //老师上传题库
    Route::resource('uploadbank', 'UploadBankController');

    // 答题页面
    Route::get('/topic', 'TopicController@index');
    Route::post('/topic/post', 'TopicController@post');
    Route::get('/topic/result', 'TopicController@result');

    // 收藏页面
    Route::get('/favorite', 'FavoriteController@index');
    Route::get('/favorite/del', 'FavoriteController@doDel');
    Route::get('/favorite/ajax', 'FavoriteController@ajax');
    Route::get('/favorite/choose', 'FavoriteController@choose');

    //初级
    Route::get('/column', 'ColumnController@index');
    Route::get('/column/static', 'ColumnController@tmpShow');

    //产品商店
    Route::get('/products', 'ProductsController@index');
    //课件
    Route::get('/courseware', 'CoursewareController@index');
    Route::get('/courseware/show', 'CoursewareController@show');

    //flash播放
    Route::get('/view_flv', 'ViewController@flv');

    Route::get('/indexSchool', 'IndexController@indexschool');
    Route::get('/about', 'IndexController@about');
    // Route::get('/feedback', 'IndexController@feedback');
    Route::get('/help', 'IndexController@help');
    Route::get('/app', 'IndexController@app');
    Route::get('/interestTest', 'IndexController@interestTest');
    Route::get('/link', 'IndexController@link');
    Route::get('/follow', 'IndexController@follow');

    // 个人中心
    Route::get('/profile', 'ProfileController@index');
    Route::post('/doProfile', 'ProfileController@doProfile');
    Route::get('/profile/passwd', 'ProfileController@showPasswd');
    Route::post('/profile/doPasswd', 'ProfileController@doPasswd');

    // 错题记录
    Route::get('/failTopic', 'FailTopicController@index');
    Route::get('/failTopic/del', 'FailTopicController@doDel');

    // 问题反馈
    Route::get('/feedback', 'FeedbackController@index');
    Route::post('/feedback/dopost', 'FeedbackController@doPost');
});



