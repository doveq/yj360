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

		return $this->indexView('topic', $info);
	}

	/* 记入答题情况 */
	public function post()
	{
		$inputs = Input::all();
		$uid = Session:get('uid');
		$qid = $inputs['id'];

		// 保存wav录音文件
		if( !empty($inputs['wavBase64']) )
		{
			$file = str_replace('data:audio/wav;base64,', '',  $inputs['wavBase64']); 
			$tmpname = tempnam("/tmp", 'wav');
			file_put_contents($tmpname, base64_decode($file));

			$saved = $att->addRecorder($tmpname, $uid, $qid);
		}

		// 保存答题数据
		
		
	}
}
