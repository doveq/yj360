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

			// 获取正确答案信息
			$right = array();
			foreach($info['a'] as $value) 
			{
				if($value['is_right'])
					$right[] = $value['id']; 
			}

			$info['right'] = $right;
		}

		

		return $this->indexView('topic', $info);
	}
}
