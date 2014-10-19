<?php

// 题目收藏夹

class FavoriteController extends BaseController 
{

	public function __construct()
    {
    	
    }

	/* 显示测试页面 */
	public function index()
	{
		//return $this->indexView('recorder');
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
