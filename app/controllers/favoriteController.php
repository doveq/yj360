<?php

// 题目收藏夹

class FavoriteController extends BaseController 
{

	public function __construct()
    {
    }

	public function index()
	{
		$info = array();
		$f = new Favorite();
		$list = $f->getList( array('uid' => Session::get('uid'), 'limit' => 15 ) );
		return $this->indexView('profile.favorite', array('list' => $list) );
	}

	public function doDel()
	{
		$id = Input::get('qid');
		if(!is_numeric($id))
			return $this->indexPrompt("", "错误的ID号", $url = "/favorite");

		$f = new Favorite();
		$f->del( array('uid' => Session::get('uid'), 'qid' => $id ) );

		return $this->indexPrompt("", "删除收藏成功", $url = "/favorite");
	}

	public function ajax()
	{
		$inputs = Input::all();
		if(!is_numeric($inputs['qid']))
			return Response::json(array('act' => $inputs['act'], 'state' => '0'));

		$info['uid'] = Session::get('uid');
		$info['qid'] = $inputs['qid'];

		if($inputs['act'] == 'add')
		{
			$f = new Favorite();
			$f->add($info);
		}
		else if($inputs['act'] == 'del')
		{
			$f = new Favorite();
			$f->del($info);
		}

		return Response::json(array('act' => $inputs['act'], 'state' => '1'));
	}

}
