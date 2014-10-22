<?php

class BaseController extends Controller
{

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}


	protected function adminView($layout, $data = array())
	{
		return View::make('Admin.' . $layout, $data);
	}

	protected function indexView($layout, $data = array())
	{
		return View::make('Index.' . $layout, $data);
	}

	/* 页面提示跳转
		title 标题
		info 详细内容
		url 跳转地址
		auto url不为空，并且该值为true则自动跳转
	*/
	public function adminPrompt($title, $info, $url = "", $auto = true)
	{
		return Redirect::to('admin/prompt')->with('prompt', array('title' => $title, 'info' => $info, 'url' => $url, 'auto' => $auto));
	}


	/* 页面提示跳转
		title 标题
		info 详细内容
		url 跳转地址
		auto url不为空，并且该值为true则自动跳转
	*/
	public function indexPrompt($title, $info, $url = "", $auto = true)
	{
		return Redirect::to('prompt')->with('prompt', array('title' => $title, 'info' => $info, 'url' => $url, 'auto' => $auto));
	}
}
