<?php

class TestController extends BaseController {

	public function index()
	{
		return $this->indexView('index');
	}

	public function test()
	{
		return $this->indexPrompt("操作失败", '题干必须填写', $url = "/", false);
	}


	/* 访问方法不存在时调用 */
	public function missingMethod($parameters = array())
	{
		exit('没有这个访问方法');
	}
}
