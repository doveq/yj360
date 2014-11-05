<?php

// 错误记录

class FailTopicController extends BaseController 
{

	public function __construct()
    {
    	
    }

	public function index()
	{
		$info = array();
		$f = new FailTopic();
		$list = $f->getList( array('uid' => Session::get('uid'), 'limit' => 15 ) );

		return $this->indexView('profile.failTopic', array('list' => $list) );
	}

	public function doDel()
	{
		$id = Input::get('id');
		if(!is_numeric($id))
			return $this->indexPrompt("", "错误的ID号", $url = "/failTopic");

		$f = new FailTopic();
		$f->del( array('uid' => Session::get('uid'), 'id' => $id ) );

		return $this->indexPrompt("", "删除错题记录成功", $url = "/failTopic");
	}

}
