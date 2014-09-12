<?php namespace Admin;
use View;
use Session;

/* 显示消息提示跳转页面 */
class PromptController extends \BaseController {

	public function index()
	{
		$data = array('title' => '错误访问', 'info' => '', 'url' => '/admin', 'auto' => true);

		if(Session::get('prompt'))
			$data = Session::get('prompt');

		return $this->adminView('prompt', $data);
	}

	public function test()
	{
		return $this->adminPrompt("表题it题题他", "表题it题题他表题it题题他表题it题题他", $url = "xxxxx", $auto = true);
	}
}
