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
		if( $attid = $this->setImg('file_img') )
			$questionAtt['img'] = $attid;
		
		// 提示音
		if( $attid = $this->setAudio('file_hint') )
			$questionAtt['hint'] = $attid;

		// 提干音
		if( $attid = $this->setAudio('file_sound') )
			$questionAtt['sound'] = $attid;

		// 处理答案
		foreach($inputs['answers_txt'] as $k => $v)
		{

		}

	}


	public function setImg($name)
	{
		if(Input::hasFile($name))
		{
		    $attid = $att->addTopicImg($qid, Input::file($name)->getRealPath());
		    return $attid;
		}

		return 0;
	}

	public function setAudio($name)
	{
		if(Input::hasFile($name))
		{
			$type = 0
			$mime = Input::file($name)->getMimeType();
			if($mime == 'audio/mp3')
				$type = 'mp3';
			else if($mime == 'audio/wav')
				$type = 'wav';

			if($type)
			{
			    $attid = $att->addTopicAudio($qid, Input::file($name)->getRealPath(), $type);
			    return $attid;
			}
		}

		return 0;
	}

}
