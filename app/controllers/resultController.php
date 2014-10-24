<?php

// 题目收藏夹

class ResultController extends BaseController 
{

	public function __construct()
    {
    	
    }

	public function index()
	{
		$info = array();
		$f = new Result();
		$list = $f->getList( array('uid' => Session::get('uid'), 'limit' => 15 ) );

		return $this->indexView('profile.result', array('list' => $list) );
	}

	public function doDel()
	{
		$id = Input::get('id');
		if(!is_numeric($id))
			return $this->indexPrompt("", "错误的ID号", $url = "/result");

		$f = new Result();
		$f->del( array('uid' => Session::get('uid'), 'id' => $id ) );

		return $this->indexPrompt("", "删除错题记录成功", $url = "/result");
	}

}
