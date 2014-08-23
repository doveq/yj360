<?php
namespace Admin;
use View;

class IndexController extends \BaseController {

	public function getIndex()
	{

		return View::make('Admin.index');
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
