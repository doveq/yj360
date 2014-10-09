<?php

class TopicController extends BaseController {

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


		return $this->indexView('topic', $info);
	}
}
