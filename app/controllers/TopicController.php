<?php

class TopicController extends BaseController {

	public $flag = array(0 => 'A', 1 => 'B', 2 => 'C', 3 => 'D');

	public function index()
	{
		$id = Input::get('id');
		if( !is_numeric($id) || $id < 1 )
		{
			exit('没有这道题目');
		}

		$topic = new Topic();
		
		$data = array();
		$info = $topic->get($id);
		if(!$info || $info['q']['status'] != 1)
		{
			exit('没有这道题目');
		}

		$info['flag'] = $this->flag;

		if(!empty($info['a']))
		{
			// 随机答案顺序
			shuffle($info['a']);
		}

		$info['session_id'] = Session::getId();

		return $this->indexView('topic', $info);
	}

	/* 记入答题情况 */
	public function correcting()
	{
		
	}
}
