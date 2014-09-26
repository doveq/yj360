<?php namespace Admin;
use View;
use Session;
use Validator;
use Input;
use Paginator;
use Redirect;
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
		return $this->adminView('topic');
	}

	public function doAdd()
	{
		$inputs = Input::all();

		$topic = new Topic();
		$qid = $topic->add($inputs);


		/* 处理题干附件 */
		// 题干图片
		$questionAtt = array();
		if($_FILES['file_img']['error'] == UPLOAD_ERR_OK &&  
			$attid = $this->setImg( $qid, $_FILES['file_img']['tmp_name']) )
		{
			$questionAtt['img'] = $attid;
		}

		// 提示音
		if($_FILES['file_hint']['error'] == UPLOAD_ERR_OK)
		{
			$type = $this->att->getExt($_FILES['file_hint']['name']);
			if($type == 'mp3' || $type == 'wav')
			{
				if( $attid = $this->setAudio( $qid, $_FILES['file_hint']['tmp_name'], $type) )
					$questionAtt['hint'] = $attid;
			}
			
		}

		// 提干音
		if($_FILES['file_sound']['error'] == UPLOAD_ERR_OK)
		{
			$type = $this->att->getExt($_FILES['file_sound']['name']);
			if($type == 'mp3' || $type == 'wav')
			{
				if( $attid = $this->setAudio( $qid, $_FILES['file_sound']['tmp_name'], $type) )
					$questionAtt['sound'] = $attid;
			}
			
		}

		// 跟新题目数据
		$topic->edit($qid, $questionAtt);


		/* 处理答案 */
		foreach($inputs['answers_txt'] as $k => $atxt)
		{
			$answers = array();
			if($atxt)
				$answers['txt'] = $atxt;

			if( isset($inputs['answers_right'][$k]) )
				$answers['is_right'] = 1;

			if($_FILES['answers_img']['error'][$k] == UPLOAD_ERR_OK &&  
				$attid = $this->setImg( $qid, $_FILES['answers_img']['tmp_name'][$k]) )
			{
				$answers['img'] = $attid;
			}


			if($_FILES['answers_sound']['error'][$k] == UPLOAD_ERR_OK)
			{
				$type = $this->att->getExt($_FILES['answers_sound']['name'][$k]);
				if($type == 'mp3' || $type == 'wav')
				{
					if( $attid = $this->setAudio( $qid, $_FILES['answers_sound']['tmp_name'][$k], $type) )
						$answers['sound'] = $attid;
				}
			}

			// 插入数据
			if($answers)
			{
				$topic->addAnswers($qid, $answers);
			}
		}

		return Redirect::to('admin/topic/edit?id='.$qid);
	}


	public function showEdit()
	{
		$id = Input::get('id');
		if( !is_numeric($id) )
			return $this->adminPrompt("操作失败", '错误的ID，请返回重试。', $url = "topic/list");

		$topic = new Topic();
		$info = $topic->get($id);
		$info['is_edit'] = 1;

		return $this->adminView('topic', $info);
	}

	public function doEdit()
	{
		$inputs = Input::all();
		$qid = $inputs['qid'];
		if( !is_numeric($qid) )
			return $this->adminPrompt("操作失败", '错误的ID，请返回重试。', $url = "topic/list");

		$topic = new Topic();
		$info = $topic->get($qid);


		/* 处理题干附件 */
		// 题干图片
		if($_FILES['file_img']['error'] == UPLOAD_ERR_OK )
		{
			if(is_numeric($inputs['file_img_id']))
				$this->att->del($inputs['file_img_id']);
			

			$inputs['img'] = $this->setImg( $qid, $_FILES['file_img']['tmp_name']);
		}

		// 提示音
		if($_FILES['file_hint']['error'] == UPLOAD_ERR_OK)
		{
			$type = $this->att->getExt($_FILES['file_hint']['name']);

			if($type == 'mp3' || $type == 'wav')
			{
				if(is_numeric($inputs['file_hint_id']))
					$this->att->del($inputs['file_hint_id']);
				

				$inputs['hint'] = $this->setAudio( $qid, $_FILES['file_hint']['tmp_name'], $type);
			}
			
		}

		// 提干音
		if($_FILES['file_sound']['error'] == UPLOAD_ERR_OK)
		{
			$type = $this->att->getExt($_FILES['file_sound']['name']);

			if($type == 'mp3' || $type == 'wav')
			{
				if(is_numeric($inputs['file_sound_id']))
					$this->att->del($inputs['file_sound_id']);
				

				$inputs['sound'] = $this->setAudio( $qid, $_FILES['file_sound']['tmp_name'], $type);
			}
		}

		$topic->edit($qid, $inputs);


		/* 处理答案 */
		foreach($inputs['answers_txt'] as $k => $atxt)
		{
			$answers = array();
			if($atxt)
				$answers['txt'] = $atxt;

			if( isset($inputs['answers_right'][$k]) )
				$answers['is_right'] = 1;

			if($_FILES['answers_img']['error'][$k] == UPLOAD_ERR_OK )
			{
				if(is_numeric($inputs['answers_img_id'][$k]))
					$topic->editAnswers($inputs['answers_img_id'][$k]), $answers);

				$attid = $this->setImg( $qid, $_FILES['answers_img']['tmp_name'][$k]);
				$answers['img'] = $attid;
			}


			if($_FILES['answers_sound']['error'][$k] == UPLOAD_ERR_OK)
			{
				$type = $this->att->getExt($_FILES['answers_sound']['name'][$k]);
				if($type == 'mp3' || $type == 'wav')
				{
					if( $attid = $this->setAudio( $qid, $_FILES['answers_sound']['tmp_name'][$k], $type) )
						$answers['sound'] = $attid;
				}
			}

			// 插入数据
			if($answers)
			{
				$topic->editAnswers($inputs['answers_id'][$k]), $answers);
			}
		}


		echo "ok";
	}

	public function setImg($qid, $file)
	{
	    $attid = $this->att->addTopicImg($qid, $file);
	    return $attid;
	}

	public function setAudio($qid, $file, $type)
	{
	    $attid = $this->att->addTopicAudio($qid, $file, $type);
	    return $attid;
	}

}
