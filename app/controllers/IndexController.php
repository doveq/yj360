<?php

class IndexController extends BaseController {

	public function index()
	{
		return $this->indexView('index');
	}


	/* 访问方法不存在时调用 */
	public function missingMethod($parameters = array())
	{
		exit('没有这个访问方法');
	}
}
