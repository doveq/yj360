<?php

class Topic  {


	/* 题目列表 */
	public function getList($data = array())
	{
		$whereArr = array();
		$valueArr = array();


		if( $data['txt'] )
		{
			$whereArr[] = " `txt` like ? ";
			$valueArr[] = '%'. $data['txt'] .'%';
		}

		if( $data['source'] )
		{
			$whereArr[] = " `source` like ? ";
			$valueArr[] = '%'. $data['source'] .'%';
		}

		if( is_numeric($data['type']) )
		{
			$whereArr[] = " `type` = ? ";
			$valueArr[] = $data['type'];
		}

		if( is_numeric($data['status']) )
		{
			$whereArr[] = " `status` = ? ";
			$valueArr[] = $data['status'];
		}

		$limit = "";
		if( is_numeric($data['page']) && is_numeric($data['pageSize']) )
		{
			$num = $data['pageSize'] * ($data['page'] -1);
			$limit = " limit {$num},{$data['pageSize']} ";
		}


		// 如果设置了分类则需要查询分类对应表
		if( !empty($data['sort']) )
		{
			// 如果是添加科目显示，则去掉已经选择过的题目
			if(!empty($data['column']))
			{
				$where = " where a.id not in( select question_id from column_question_relation where column_id = '{$data['column']}' ) and b.sort_id = '{$data['sort']}' and b.question_id = a.id ";
			}
			// 如果是添加试卷显示，则去掉已经选择过的题目
			elseif(!empty($data['exam']))
			{
				$where = " where a.id not in( select question_id from exam_question_relation where exam_id = '{$data['exam']}' ) and b.sort_id = '{$data['sort']}' and b.question_id = a.id ";
			}
			else
				$where = " where b.sort_id = '{$data['sort']}' and b.question_id = a.id ";

			if($whereArr)
				$where = $where . ' and ' . implode(' and ', $whereArr);

			$sql = "select a.* from questions as a, sort_question_relation as b {$where} order by id desc {$limit} ";
			$results = DB::select($sql, $valueArr);

			// 获取总数分页使用
			$sql = "select count(*) as num from questions as a, sort_question_relation as b {$where}";
			$re2 = DB::select($sql, $valueArr);
			$count = $re2[0]->num;
		}
		else
		{
			if(!empty($data['column']))
			{
				$where = " where id not in( select question_id from column_question_relation where column_id = '{$data['column']}' ) ";
			}
			// 如果是添加试卷显示，则去掉已经选择过的题目
			elseif(!empty($data['exam']))
			{
				$where = " where id not in( select question_id from exam_question_relation where exam_id = '{$data['exam']}' ) ";
			}
			else
				$where = ' where 1=1 ';

			if($whereArr)
				$where = $where . ' and ' . implode(' and ', $whereArr);

			$sql = "select * from questions {$where} order by id desc {$limit} ";
			$results = DB::select($sql, $valueArr);
			//print_r(DB::getQueryLog());

			// 获取总数分页使用
			$sql = "select count(*) as num from questions {$where}";
			$re2 = DB::select($sql, $valueArr);
			$count = $re2[0]->num;
		}

		foreach($results as &$item)
		{
			$item = (array)$item;
		}
		
		return array('data' => $results, 'total' => $count);
	}



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
			$info['q']['img_name'] =  $item['file_name'];
		}

		if($info['q']['hint'])
		{
			$item = $att->get($info['q']['hint']);
			$route = $att->getTopicRoute($qid, $item['file_name']);
			$info['q']['hint_url'] =  $route['url'];
			$info['q']['hint_att_id'] = $item['id'];
			$info['q']['hint_name'] =  $item['file_name'];
		}

		if($info['q']['sound'])
		{
			$item = $att->get($info['q']['sound']);
			$route = $att->getTopicRoute($qid, $item['file_name']);
			$info['q']['sound_url'] =  $route['url'];
			$info['q']['sound_att_id'] = $item['id'];
			$info['q']['sound_name'] =  $item['file_name'];
		}

		if($info['q']['flash'])
		{
			$item = $att->get($info['q']['flash']);
			$route = $att->getTopicRoute($qid, $item['file_name']);
			$info['q']['flash_url'] =  $route['url'];
			$info['q']['flash_att_id'] = $item['id'];
			$info['q']['flash_name'] =  $item['file_name'];
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
				$data['img_name'] =  $item['file_name'];
			}

			if($data['sound'])
			{
				$item = $att->get($data['sound']);
				$route = $att->getTopicRoute($qid, $item['file_name']);
				$data['sound_url'] =  $route['url'];
				$data['sound_att_id'] = $item['id'];
				$data['sound_name'] =  $item['file_name'];
			}

			$info['a'][] = $data;
		}

		return $info;
	}

	/* 添加题目 */
	public function add($data)
	{
		$info = array();
		
		if(isset($data['source']) && !empty($data['source']))
			$info['source'] = $data['source'];

		if(isset($data['txt']) && !empty($data['txt']))
			$info['txt'] = htmlspecialchars($data['txt']);

		if(isset($data['hint']) && is_numeric($data['hint']))
			$info['hint'] = $data['hint'];

		if(isset($data['sound']) && is_numeric($data['sound']))
			$info['sound'] = $data['sound'];

		if(isset($data['img']) && is_numeric($data['img']))
			$info['img'] = $data['img'];

		if(isset($data['flash']) && is_numeric($data['flash']))
			$info['flash'] = $data['flash'];

		if(isset($data['disabuse']) && !empty($data['disabuse']))
			$info['disabuse'] = $data['disabuse'];

		if(isset($data['type']) && is_numeric($data['type']))
				$info['type'] = $data['type'];

		if(isset($data['status']) && is_numeric($data['status']))
				$info['status'] = $data['status'];

		if(isset($data['author']) && !empty($data['author']))
			$info['author'] = $data['author'];

		if(isset($data['intro']) && !empty($data['intro']))
			$info['intro'] = $data['intro'];
	
		$info['created_at'] = date('Y-m-d H:i:s');
		$id = DB::table("questions")->insertGetId($info);

    	return $id;
	}

	/* 编辑题目 */
	public function edit($qid, $data)
	{
		$info = array();

		if(isset($data['source']) && !empty($data['source']))
			$info['source'] = $data['source'];

		if(isset($data['txt']) && !empty($data['txt']))
			$info['txt'] = htmlspecialchars($data['txt']);

		if(isset($data['explain']) && !empty($data['explain']))
			$info['explain'] = $data['explain'];

		if(isset($data['hint']) && is_numeric($data['hint']))
			$info['hint'] = $data['hint'];

		if(isset($data['sound']) && is_numeric($data['sound']))
			$info['sound'] = $data['sound'];

		if(isset($data['img']) && is_numeric($data['img']))
			$info['img'] = $data['img'];

		if(isset($data['flash']) && is_numeric($data['flash']))
			$info['flash'] = $data['flash'];

		if(isset($data['disabuse']) && !empty($data['disabuse']))
			$info['disabuse'] = $data['disabuse'];

		if(isset($data['type']) && is_numeric($data['type']))
				$info['type'] = $data['type'];

		if(isset($data['status']) && is_numeric($data['status']))
				$info['status'] = $data['status'];

		if(isset($data['author']) && !empty($data['author']))
			$info['author'] = $data['author'];

		if(isset($data['intro']) && !empty($data['intro']))
			$info['intro'] = $data['intro'];

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

		if(isset($data['flash']) && is_numeric($data['flash']))
			$info['flash'] = $data['flash'];

		
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

	/* 编辑答案 */
	public function editAnswers($aid, $data)
	{
		$info = array();
		
		if(isset($data['txt']) && !empty($data['txt']))
			$info['txt'] = $data['txt'];

		if(isset($data['explain']) && !empty($data['explain']))
			$info['explain'] = $data['explain'];

		if(isset($data['sound']) && is_numeric($data['sound']))
			$info['sound'] = $data['sound'];

		if(isset($data['img']) && is_numeric($data['img']))
			$info['img'] = $data['img'];

		if(isset($data['flash']) && is_numeric($data['flash']))
			$info['flash'] = $data['flash'];

		if(isset($data['is_right']) && is_numeric($data['is_right']))
				$info['is_right'] = $data['is_right'];

		if($info)
			DB::table("answers")->where('id', $aid)->update($info);
	
	}


	/* 删除题目 */
	public function del($id)
	{
		$questions = DB::table('questions')->where('id', $id)->get();
		if( !$questions )
			return 0;

		$att = new Attachments();

		$q = (array)$questions[0];


		// 删除题目
		if($q['hint'] > 0)
			$att->del($q['hint']);

		if($q['sound'] > 0)
			$att->del($q['sound']);

		if($q['img'] > 0)
			$att->del($q['img']);

		if($q['flash'] > 0)
			$att->del($q['flash']);

		DB::table('questions')->where('id', $id)->delete();

		// 删除答案
		$answers = DB::table('answers')->where('qid', $id)->get();
		foreach ($answers as $data) 
		{
			$data = (array)$data;
			if($data['img'] > 0)
				$att->del($data['img']);

			if($data['sound'] > 0)
				$att->del($data['sound']);

			if($data['flash'] > 0)
				$att->del($data['flash']);

			DB::table('answers')->where('id', $data['id'])->delete();
		}

		return 1;
	}


	
	/* 保存答题题目信息 */
	public function addResultLog($info)
	{
		$now = date('Y-m-d H:i:s');
		foreach ($info['list'] as $key => $qid) 
		{
			$data = array();
			$data['created_at'] = $now;
			$data['uniqid'] = $info['uniqid'];
			$data['column_id'] = $info['column_id'];
			$data['uid'] = $info['uid'];
			$data['question_id'] = $qid;

			if(isset($info['trues'][$qid]))
				$data['is_true'] = $info['trues'][$qid];

			if(isset($info['answers'][$qid]))
				$data['answers'] = $info['answers'][$qid];

			DB::table("result_log")->insert($data);
		}
	}

	/* 获取答题统计 */
	public function getResult($uniqid)
	{
		$info = DB::table('result_log')->where('uniqid', $uniqid)->orderBy('id', 'ASC')->get();
		foreach($info as &$item)
		{
			$item = (array)$item;
		}

		return (array)$info;
	}

}
