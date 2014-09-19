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

	public function __construct()
	{
		$this->att = new Attachments();
	}
	
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
		
		
		/* 处理题干附件 */
		// 题干图片
		$questionAtt = array();
		if($_FILES['file_img']['error'] == UPLOAD_ERR_OK &&  
			$attid = $this->setImg( $qid, $_FILES['file_img']['tmp_name']) )
		{
			$questionAtt['img'] = $attid;
		}

		// 提示音
		if($_FILES['file_hint']['error'] == UPLOAD_ERR_OK && 
			$attid = $this->setAudio( $qid, $_FILES['file_hint']['tmp_name'], $_FILES['file_hint']['type']) )
		{
			$questionAtt['hint'] = $attid;
		}

		// 提干音
		if( $_FILES['file_sound']['error'] == UPLOAD_ERR_OK && 
			$attid = $this->setAudio( $qid, $_FILES['file_sound']['tmp_name'], $_FILES['file_sound']['type']) )
		{
			$questionAtt['sound'] = $attid;
		}

		// 跟新题目数据
		$topic->edit($qid, $questionAtt);


		/* 处理答案 */
		foreach($inputs['answers_txt'] as $k => $atxt)
		{
			$answers = array();
			if($atxt)
				$answers['txt'] = $atxt;

			if($_FILES['answers_img']['error'][$k] == UPLOAD_ERR_OK &&  
				$attid = $this->setImg( $qid, $_FILES['answers_img']['tmp_name'][$k]) )
			{
				$answers['img'] = $attid;
			}

			if($_FILES['answers_sound']['error'][$k] == UPLOAD_ERR_OK && 
				$attid = $this->setAudio( $qid, $_FILES['answers_sound']['tmp_name'][$k], $_FILES['answers_sound']['type'][$k]) )
			{
				$answers['sound'] = $attid;
			}

			// 插入数据
			if($answers)
			{
				$topic->addAnswers($qid, $data);
			}
		}

		echo "完成！";

	}


	public function setImg($qid, $file)
	{
	    $attid = $this->att->addTopicImg($qid, $file);
	    return $attid;
	}

	public function setAudio($qid, $file, $mime)
	{
		
		if($mime == 'audio/mp3')
			$type = 'mp3';
		else if($mime == 'audio/wav')
			$type = 'wav';
		else
			return 0;

	    $attid = $this->att->addTopicAudio($qid, $file, $type);
	    return $attid;

		return 0;
	}

}
