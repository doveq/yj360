<?php

class Topic  {


	/* 添加题目 */
	public function add($data)
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
			
			$id = DB::table("questions")->insertGetId($info);
		}

		return $id;
	}

}
