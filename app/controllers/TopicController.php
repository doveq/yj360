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
				return $this->indexPrompt("操作失败", "没有这个科目信息", $url = "/");

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
				return $this->indexPrompt("操作失败", "科目下没有题目信息", $url = "/");

			// 题目数据保存
			Session::put('column', $column);
			Session::put('uniqid', uniqid());
			Session::put('qlist', $qlist);
		}
		else
		{
			$qlist = Session::get('qlist');
		}
		
		// 题目id不对则设为第一题
		if( !is_numeric($id) || !array_key_exists($id, $qlist) )
		{
			reset($qlist);
			$id = key($qlist);
		}


		$topic = new Topic();
		
		$data = array();
		$info = $topic->get($id);

		if(!$info)
		{
			var_dump($id);
			exit;
			return $this->indexPrompt("操作失败", "没有这道题目信息", $url = "/");
		}

		if($info['q']['status'] != 1)
		{
			return $this->indexPrompt("操作失败", "题目没有通过审核", $url = "/");
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
		$uid = Session::get('uid');
		$qid = $inputs['id'];

		// 保存wav录音文件
		if( !empty($inputs['wavBase64']) )
		{
			$fileBase6 = str_replace('data:audio/wav;base64,', '',  $inputs['wavBase64']); 
			$tmpname = tempnam("/tmp", 'wav');
			file_put_contents($tmpname, base64_decode($fileBase6));

			$att = new Attachments();
			$saved = $att->addRecorder($tmpname, $uid, $qid);
		}

		// 保存答题信息
		$topic = new Topic();

		$info = array();
		$info['uid'] = $uid;
		$info['qid'] = $qid;
		$info['is_true'] = $inputs['isTrue'];
		$info['column_id'] = Session::get('column');
		$info['uniqid'] = Session::get('uniqid');
		$topic->addResultLog($info);


		// 上一题
		if($inputs['act'] == 'prve')
		{
			
		}
		// 下一题
		else
		{
			
		}
		
	}
}
