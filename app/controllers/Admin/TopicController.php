<?php namespace Admin;
use View;
use Session;
use Validator;
use Input;
use Paginator;
use Topic;
use Attachments;

/* 原始题库功能 */
class TopicController extends \BaseController {

	
	public function showAdd()
	{
		return $this->adminView('topic', array('user' => ''));
	}

	public function doAdd()
	{
		$inputs = Input::all();

		$topic = new Topic();
		$qid = $topic->add($inputs);

		#$this->adminPrompt("操作失败", '添加题目失败，请返回重试。', $url = "topicList");
		
		$att = new Attachments();
		/* 处理题干附件 */
		// 题干图片
		$questionAtt = array();
		if(Input::hasFile('file_img'))
		{
		    $attid = $att->addTopicImg(Input::file('file_img')->getRealPath(), $qid);
		    if($attid)
		    	$questionAtt['img'] = $attid;
		}


		// 处理答案
		foreach($inputs['answers_txt'] as $k => $v)
		{
			
		}
		
	}
}
