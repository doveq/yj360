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

	public $statusEnum = array('' => '所有状态', '0' => '无效', '1' => '审核通过', '-1' => '审核拒绝');
	public $typeEnum = array('' => '所有类型', '-1' => '管理员', '0' => '学生', '1' => '老师');

	public function __construct()
	{
		$this->att = new Attachments();
	}
	

	/* 显示列表 */
	public function index()
	{
		$pageSize = 30;  // 每页显示条数

        $query = Input::only('txt', 'source', 'type', 'status', 'page');
        $query['pageSize'] = $pageSize;
        //$query = array_filter($query); // 删除空值

        // 当前页数
        if( !is_numeric($query['page']) || $query['page'] < 1 )
            $query['page'] = 1;


        $topic = new Topic();
        $info = $topic->getList($query);

        // 分页
        $paginator = Paginator::make($info['data'], $info['total'], $pageSize);
        unset($query['pageSize']); // 减少分页url无用参数
        $paginator->appends($query);  // 设置分页url参数
        
		$p = array(
            'list'       => $info['data'],
            'typeEnum'   => $this->typeEnum,
            'statusEnum' => $this->statusEnum,
            'query'      => $query,
            'paginator'  => $paginator
            );
		
		return $this->adminView('topic.index', $p);
	}

	public function showAdd()
	{
		return $this->adminView('topic.topic');
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

		return $this->adminPrompt("操作成功", '题目添加成功。', $url = "topic/edit?id=".$qid);
	}


	public function showEdit()
	{
		$id = Input::get('id');
		if( !is_numeric($id) )
			return $this->adminPrompt("操作失败", '错误的ID，请返回重试。', $url = "topic/list");

		$topic = new Topic();
		$info = $topic->get($id);
		$info['is_edit'] = 1;

		return $this->adminView('topic.topic', $info);
	}

	public function doEdit()
	{
		$inputs = Input::all();
		$qid = $inputs['qid'];
		if( !is_numeric($qid) )
			return $this->adminPrompt("操作失败", '错误的ID，请返回重试。', $url = "topic");

		$topic = new Topic();
		$info = $topic->get($qid);


		/* 处理题干附件 */
		// 题干图片
		if(isset($_FILES['file_img']) && $_FILES['file_img']['error'] == UPLOAD_ERR_OK )
		{
			if(isset($inputs['file_img_id']) && is_numeric($inputs['file_img_id']))
				$this->att->del($inputs['file_img_id']);
			

			$inputs['img'] = $this->setImg( $qid, $_FILES['file_img']['tmp_name']);
		}

		if(isset($inputs['del_img']) && is_numeric($inputs['del_img']))
		{
			$this->att->del($inputs['del_img']);
			$inputs['img'] = 0; 
		}

		// 提示音
		if(isset($_FILES['file_hint']) && $_FILES['file_hint']['error'] == UPLOAD_ERR_OK)
		{
			$type = $this->att->getExt($_FILES['file_hint']['name']);

			if($type == 'mp3' || $type == 'wav')
			{
				if(isset($inputs['file_hint_id']) && is_numeric($inputs['file_hint_id']))
					$this->att->del($inputs['file_hint_id']);
				

				$inputs['hint'] = $this->setAudio( $qid, $_FILES['file_hint']['tmp_name'], $type);
			}
			
		}

		if(isset($inputs['del_hint']) && is_numeric($inputs['del_hint']))
		{
			$this->att->del($inputs['del_hint']);
			$inputs['hint'] = 0; 
		}

		// 提干音
		if(isset($_FILES['file_sound']) && $_FILES['file_sound']['error'] == UPLOAD_ERR_OK)
		{
			$type = $this->att->getExt($_FILES['file_sound']['name']);

			if($type == 'mp3' || $type == 'wav')
			{
				if(isset($inputs['file_sound_id']) && is_numeric($inputs['file_sound_id']))
					$this->att->del($inputs['file_sound_id']);
				

				$inputs['sound'] = $this->setAudio( $qid, $_FILES['file_sound']['tmp_name'], $type);
			}
		}

		if(isset($inputs['del_sound']) && is_numeric($inputs['del_sound']))
		{
			$this->att->del($inputs['del_sound']);
			$inputs['sound'] = 0; 
		}

		$topic->edit($qid, $inputs);


		/* 处理答案 */
		if(isset($inputs['answers_txt']))
		{
			foreach($inputs['answers_txt'] as $k => $atxt)
			{
				$answers = array();
				if($atxt)
					$answers['txt'] = $atxt;

				if( isset($inputs['answers_right'][$k]) )
					$answers['is_right'] = 1;

				if(isset($_FILES['answers_img']) && $_FILES['answers_img']['error'][$k] == UPLOAD_ERR_OK )
				{
					if(isset($inputs['answers_img_id'][$k]) && is_numeric($inputs['answers_img_id'][$k]))
						$this->att->del($inputs['answers_img_id'][$k]);

					$attid = $this->setImg( $qid, $_FILES['answers_img']['tmp_name'][$k]);
					$answers['img'] = $attid;
				}


				if(isset($_FILES['answers_sound']) && $_FILES['answers_sound']['error'][$k] == UPLOAD_ERR_OK)
				{
					$type = $this->att->getExt($_FILES['answers_sound']['name'][$k]);
					if($type == 'mp3' || $type == 'wav')
					{
						if(isset($inputs['answers_sound_id'][$k]) && is_numeric($inputs['answers_sound_id'][$k]))
							$this->att->del($inputs['answers_sound_id'][$k]);

						$answers['sound'] = $this->setAudio( $qid, $_FILES['answers_sound']['tmp_name'][$k], $type);
					}
				}


				if(isset($inputs['del_answers_img'][$k]) && is_numeric($inputs['del_answers_img'][$k]))
				{
					$this->att->del($inputs['del_answers_img'][$k]);
					$answers['img'] = 0;
				}

				if(isset($inputs['del_answers_sound'][$k]) && is_numeric($inputs['del_answers_sound'][$k]))
				{
					$this->att->del($inputs['del_answers_sound'][$k]);
					$answers['sound'] = 0; 
				}

				// 插入数据
				if($answers)
				{
					if(isset($inputs['aid'][$k]) && is_numeric($inputs['aid'][$k]))
						$topic->editAnswers($inputs['aid'][$k], $answers);
					else
						$topic->addAnswers($qid, $answers);
				}
			}
		}

		return $this->adminPrompt("操作成功", '题目编辑成功。', $url = "topic/edit?id=" . $qid);
	}

	/* 删除题目 */
	public function doDel()
	{
		$inputs = Input::all();
		$qid = $inputs['qid'];
		if(!is_numeric($qid))
			return $this->adminPrompt("操作失败", '错误的ID，请返回重试。', $url = "topic");


		$topic = new Topic();
		$topic->del($qid);

		return $this->adminPrompt("操作成功", '题目删除成功。', $url = "topic");
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
