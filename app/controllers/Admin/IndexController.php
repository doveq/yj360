<?php namespace Admin;
use View;
use Session;
use Auth;

class IndexController extends \BaseController {

	public function index()
	{
		// print_r( Auth::user() );
		return $this->adminView('index');
	}

	public function test()
	{
		echo "后台测试~";
	}


	/* 访问方法不存在时调用 */
	public function missingMethod($parameters = array())
	{
		exit('没有这个访问方法');
	}
}
