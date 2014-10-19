<?php

class TopicController extends BaseController {

	public $flag = array(0 => 'A', 1 => 'B', 2 => 'C', 3 => 'D');

	public function index()
	{
		$id = Input::get('id');
		$column = Input::get('column');

		$qlist = array();
		/*
		if( !is_numeric($column) )
		{
			exit('没有这道题目');
		}

		$cqr = new ColumnQuestionRelation();
		$list = $cqr->getList($column);

		$qlist = array();
		foreach ($list as $key => $value)
		{
			$qlist[] = $value['question_id'];
		}

		if( !$qlist )
			exit('没有这道题目');

		// 题目id不对则设为第一题
		if( !is_numeric($id) || !in_array($id, $qlist) )
			$id = $qlist[0];
		*/

		$topic = new Topic();
		
		$data = array();
		$info = $topic->get($id);
		if(!$info || $info['q']['status'] != 1)
		{
			//exit('没有这道题目!!!');
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

	/* 记入答题情况 */
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
