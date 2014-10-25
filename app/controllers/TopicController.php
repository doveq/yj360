<?php

class TopicController extends BaseController {

	public $flag = array(0 => 'A', 1 => 'B', 2 => 'C', 3 => 'D');

	public function index()
	{
		$id = Input::get('id');
		$column = Input::get('column');

		$qlist = array();

		// 有科目信息的情况
		if( is_numeric($column) && Session::get('column') != $column )
		{
			$columnInfo = Column::find($column)->toArray();
			if(!$columnInfo)
				return $this->indexPrompt("操作失败", "没有这个科目信息", $url = "/", false);

			$cqr = new ColumnQuestionRelation();

			if($columnInfo['type'] == 1)
				$list = $cqr->getRandList($column, 40);
			else
				$list = $cqr->getList($column);


			$qlist = array();
			foreach ($list as $key => $value)
			{
				$qlist[$value['question_id']] = 0;  // 默认0为没有作答，1为答对，-1为答错
			}

			if( !$qlist )
				return $this->indexPrompt("操作失败", "科目下没有题目信息", $url = "/", false);

			// 题目数据保存
			Session::put('qlist', $qlist);
			Session::put('column', $column);
			Session::put('uniqid', uniqid());
			Session::save();
		}
		else
		{
			$qlist = Session::get('qlist') ? Session::get('qlist') : array();
		}
		
		// 题目id不对则设为第一题
		if( !empty($qlist) && (!is_numeric($id) || !array_key_exists($id, $qlist)) )
		{
			reset($qlist);
			$id = key($qlist);
		}


		$topic = new Topic();
		
		$data = array();
		$info = $topic->get($id);

		if(!$info)
		{
			return $this->indexPrompt("操作失败", "没有这道题目信息", $url = "/", false);
		}

		if($info['q']['status'] != 1 && Session::get('utype') != -1)
		{
			echo '---->' . Session::get('utype');
			exit;
			return $this->indexPrompt("操作失败", "题目没有通过审核", $url = "/", false);
		}

		$info['flag'] = $this->flag;

		if(!empty($info['a']))
		{
			// 随机答案顺序
			shuffle($info['a']);
		}

		$info['qlist'] = $qlist;
		$info['column'] = $column;


		return $this->indexView('topic', $info);
	}

	/* 记录答题情况 */
	public function post()
	{
		$inputs = Input::all();
		$qid = $inputs['id'];
		$uid = Session::get('uid');
		$qlist = Session::get('qlist');

		// 保存wav录音文件
		if( !empty($inputs['wavBase64']) )
		{
			$fileBase6 = str_replace('data:audio/wav;base64,', '',  $inputs['wavBase64']); 
			$tmpname = tempnam("/tmp", 'wav');
			file_put_contents($tmpname, base64_decode($fileBase6));

			$att = new Attachments();
			$saved = $att->addRecorder($tmpname, $uid, $qid);
		}


		if($qlist)
		{
			$qlist[$qid] = $inputs['isTrue'];
			$column = Session::get('column');
			Session::set('qlist', $qlist);
			Session::save();

		    $qk = array_keys($qlist);
		    $tol = count($qk);
		    for($i = 0; $i < $tol; $i++)
		    {
		    	// 上一题
				if($inputs['act'] == 'prev')
				{
					// 如果已经是第一题
	        		if($qid == $qk[0])
	        		{
	        			header("Location: /topic?column={$column}&id={$qid}");
		           		exit;
	        		}
	        		elseif($qid == $qk[$i])
	        		{
	        			$qid = $qk[$i -1];

	        			header("Location: /topic?column={$column}&id={$qid}");
		           		exit;
	        		}
	        	}
	        	else
	        	{
	        		// 如果已经是最后一题
	        		if($qid == $qk[$tol -1])
	        		{
	        			$uniqid = Session::get('uniqid');
						// 保存答题信息
						$topic = new Topic();
						$info = array();
						$info['uid'] = $uid;
						$info['column'] = Session::get('column');
						$info['uniqid'] = $uniqid ? $uniqid : uniqid();
						$info['qlist'] = $qlist;


						$topic->addResultLog($info);

						Session::forget('column');
						Session::forget('uniqid');
						Session::forget('qlist');
						Session::save();

	        			//return $this->indexPrompt("操作成功", "答题完成", $url = "/");
	        			header("Location: /topic/result?uniqid={$uniqid}&column={$column}");
		           		exit;
	        		}
	        		elseif($qid == $qk[$i])
	        		{
	        			$qid = $qk[$i +1];
	        			header("Location: /topic?column={$column}&id={$qid}");
		           		exit;
	        		}
	        	}
		    }
		}
		else
		{
			return $this->indexPrompt("操作成功", "答题完成", $url = "/");
		}

		
	}


	/* 答题完成 */
	public function result()
	{
		$uniqid = Input::get('uniqid');
		
		$data = array();
		$topic = new Topic();
		$list = $topic->getResult($uniqid);

		$data['rightNum'] = 0;
		$data['errorNum'] = 0;
		foreach ($list as $key => $value) 
		{
			 if($value['is_true'] == 1)
			 	$data['rightNum']++;
			 else
			 	$data['errorNum']++;
		}
		
		$data['list'] = $list;
		$data['scores'] =  (100 / count($list)) * $data['rightNum'];

		return $this->indexView('topic_result',  $data);
	}



}
