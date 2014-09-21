<?php

class Topic  {

	/* 获取题目信息 */
	public function get($id)
	{
		$info = array();

		$questions = DB::table('questions')->where('id', $id)->get();
		if( !$questions )
			return 0;

		$att = new Attachments();

		$info['q'] = (array)$questions[0];
		$qid = $info['q']['id'];

		if($info['q']['img'])
		{
			$item = $att->get($info['q']['img']);
			$route = $att->getTopicRoute($qid, $item['file_name']);
			$info['q']['img_url'] =  $route['url'];
			$info['q']['img_att_id'] = $item['id'];
		}

		if($info['q']['hint'])
		{
			$item = $att->get($info['q']['hint']);
			$route = $att->getTopicRoute($qid, $item['file_name']);
			$info['q']['hint_url'] =  $route['url'];
			$info['q']['hint_att_id'] = $item['id'];
		}

		if($info['q']['sound'])
		{
			$item = $att->get($info['q']['sound']);
			$route = $att->getTopicRoute($qid, $item['file_name']);
			$info['q']['sound_url'] =  $route['url'];
			$info['q']['sound_att_id'] = $item['id'];
		}

		$answers = DB::table('answers')->where('qid', $id)->get();
		foreach ($answers as $data) 
		{
			$data = (array)$data;
			if($data['img'])
			{
				$item = $att->get($data['img']);
				$route = $att->getTopicRoute($qid, $item['file_name']);
				$data['img_url'] =  $route['url'];
				$data['img_att_id'] = $item['id'];
			}

			if($data['sound'])
			{
				$item = $att->get($data['sound']);
				$route = $att->getTopicRoute($qid, $item['file_name']);
				$data['sound_url'] =  $route['url'];
				$data['sound_att_id'] = $item['id'];
			}

			$info['a'][] = $data;
		}

		return $info;
	}

	/* 添加题目 */
	public function add($data)
	{
		$info = array();
		
		if(isset($data['txt']) && !empty($data['txt']))
			$info['txt'] = $data['txt'];

		if(isset($data['hint']) && is_numeric($data['hint']))
			$info['hint'] = $data['hint'];

		if(isset($data['sound']) && is_numeric($data['sound']))
			$info['sound'] = $data['sound'];

		if(isset($data['img']) && is_numeric($data['img']))
			$info['img'] = $data['img'];

		if(isset($data['video']) && is_numeric($data['video']))
			$info['video'] = $data['video'];

		if(isset($data['disabuse']) && !empty($data['disabuse']))
			$info['disabuse'] = $data['disabuse'];

		if(isset($data['type']) && is_numeric($data['type']))
				$info['type'] = $data['type'];
	
		$info['created_at'] = date('Y-m-d H:i:s');
		$id = DB::table("questions")->insertGetId($info);

    	return $id;
	}

	/* 编辑题目 */
	public function edit($qid, $data)
	{
		$info = array();
		
		if(isset($data['txt']) && !empty($data['txt']))
			$info['txt'] = $data['txt'];

		if(isset($data['hint']) && is_numeric($data['hint']))
			$info['hint'] = $data['hint'];

		if(isset($data['sound']) && is_numeric($data['sound']))
			$info['sound'] = $data['sound'];

		if(isset($data['img']) && is_numeric($data['img']))
			$info['img'] = $data['img'];

		if(isset($data['video']) && is_numeric($data['video']))
			$info['video'] = $data['video'];

		if(isset($data['disabuse']) && !empty($data['disabuse']))
			$info['disabuse'] = $data['disabuse'];

		if(isset($data['type']) && is_numeric($data['type']))
				$info['type'] = $data['type'];

		if($info)
			DB::table("questions")->where('id', $qid)->update($info);
	}


	/* 添加答案 */
	public function addAnswers($qid, $data)
	{
		$info = array();
		
		if(isset($data['txt']) && !empty($data['txt']))
			$info['txt'] = $data['txt'];

		if(isset($data['sound']) && is_numeric($data['sound']))
			$info['sound'] = $data['sound'];

		if(isset($data['img']) && is_numeric($data['img']))
			$info['img'] = $data['img'];

		if(isset($data['video']) && is_numeric($data['video']))
			$info['video'] = $data['video'];

		
		$id = 0;
		if($info)
		{
			if(isset($data['is_right']) && is_numeric($data['is_right']))
				$info['is_right'] = $data['is_right'];

			$info['qid'] = $qid;
			
			$id = DB::table("answers")->insertGetId($info);
		}

		return $id;
	}

}
