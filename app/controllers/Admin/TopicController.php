<?php namespace Admin;
use View;
use Session;
use Validator;
use Input;
use Paginator;
use Redirect;
use Topic;
use Attachments;
use SortQuestionRelation;
use Sort;
use Column;
use ExamPaper;
use Config;

/* 原始题库功能 */
class TopicController extends \BaseController {

	public $statusEnum = array('' => '所有状态', '0' => '未审核', '1' => '审核通过', '-1' => '审核未通过');
	#public $typeEnum = array('1' => '单选择题', '2' => '多选择题',  '3' => '判断题', '4' => '填空题', '5' => '写作题', '6' => '模唱', '7' => '视唱', '8' => '视频', '9' => '教材', '10' => '游戏');
	public $flag = array(0 => 'A', 1 => 'B', 2 => 'C', 3 => 'D', 4 => 'E', 5 => 'F');

	public function __construct()
	{
		$this->att = new Attachments();
		$this->typeEnum = Config::get('app.topic_type'); // 读取配置文件
	}



	/* 显示列表 */
	public function index()
	{
		$pageSize = 30;  // 每页显示条数

        $query = Input::only('id', 'txt', 'source', 'type', 'status', 'page', 'sort1', 'sort2', 'sort3', 'sort4', 'sort5');
        $query['pageSize'] = $pageSize;
        //$query = array_filter($query); // 删除空值
        
        // 当前页数
        if( !is_numeric($query['page']) || $query['page'] < 1 )
            $query['page'] = 1;

        // 处理分类
		$query['sort'] = 0;
		if( !empty($query['sort5']) )
			$query['sort'] = $query['sort5'];
		elseif( !empty($query['sort4']) )
			$query['sort'] = $query['sort4'];
		elseif( !empty($query['sort3']) )
			$query['sort'] = $query['sort3'];
		elseif( !empty($query['sort2']) )
			$query['sort'] = $query['sort2'];
		elseif( !empty($query['sort1']) )
			$query['sort'] = $query['sort1'];

        $topic = new Topic();
        $info = $topic->getList($query);

        // 分页
        $paginator = Paginator::make($info['data'], $info['total'], $pageSize);
        unset($query['pageSize']); // 减少分页url无用参数
        unset($query['sort']); // 处理分页显示
        $paginator->appends($query);  // 设置分页url参数

        $this->typeEnum = array('' =>'所有题型') + $this->typeEnum ;

		$p = array(
            'list'       => $info['data'],
            'typeEnum'   => $this->typeEnum,
            'statusEnum' => $this->statusEnum,
            'query'      => $query,
            'paginator'  => $paginator
            );

		return $this->adminView('topic.index', $p);
	}


	// 显示科目添加题目页面
	public function showColumn()
	{
		$pageSize = 30;  // 每页显示条数

        $query = Input::only('txt', 'source', 'type', 'status', 'page', 'sort1', 'sort2', 'sort3', 'sort4', 'sort5', 'id');
        $query['pageSize'] = $pageSize;
        $query['status'] = 1;  // 只显示已通过的
        $query['column'] = $query['id'];

        // 当前页数
        if( !is_numeric($query['page']) || $query['page'] < 1 )
            $query['page'] = 1;

        // 处理分类
		$query['sort'] = 0;
		if( !empty($query['sort5']) )
			$query['sort'] = $query['sort5'];
		elseif( !empty($query['sort4']) )
			$query['sort'] = $query['sort4'];
		elseif( !empty($query['sort3']) )
			$query['sort'] = $query['sort3'];
		elseif( !empty($query['sort2']) )
			$query['sort'] = $query['sort2'];
		elseif( !empty($query['sort1']) )
			$query['sort'] = $query['sort1'];

        $topic = new Topic();
        $info = $topic->getList($query);

        // 分页
        $paginator = Paginator::make($info['data'], $info['total'], $pageSize);
        unset($query['pageSize']); // 减少分页url无用参数
        $paginator->appends($query);  // 设置分页url参数

        $this->typeEnum = array('' =>'所有题型') + $this->typeEnum ;

        $id = $query['id'];

        $query['parent_id'] = $id;
        if ($id > 0) {
            $parent = Column::find($id);
            $paths = array_reverse($parent->getPath($parent->id));
        }

		$p = array(
            'list'       => $info['data'],
            'typeEnum'   => $this->typeEnum,
            'statusEnum' => $this->statusEnum,
            'query'      => $query,
            'paginator'  => $paginator,
            'parent'	=> $parent,
            'paths'	=> $paths,
            );

		return $this->adminView('topic.column', $p);
	}

	// 显示试卷添加题目页面
	public function showExam()
	{
		$pageSize = 30;  // 每页显示条数

        $query = Input::only('txt', 'source', 'type', 'status', 'page', 'sort1', 'sort2', 'sort3', 'sort4', 'sort5', 'id');
        $query['pageSize'] = $pageSize;
        $query['status'] = 1;  // 只显示已通过的
        $query['exam'] = $query['id'];

        // 当前页数
        if( !is_numeric($query['page']) || $query['page'] < 1 )
            $query['page'] = 1;

        // 处理分类
		$query['sort'] = 0;
		if( !empty($query['sort5']) )
			$query['sort'] = $query['sort5'];
		elseif( !empty($query['sort4']) )
			$query['sort'] = $query['sort4'];
		elseif( !empty($query['sort3']) )
			$query['sort'] = $query['sort3'];
		elseif( !empty($query['sort2']) )
			$query['sort'] = $query['sort2'];
		elseif( !empty($query['sort1']) )
			$query['sort'] = $query['sort1'];

        $topic = new Topic();
        $info = $topic->getList($query);

        // 分页
        $paginator = Paginator::make($info['data'], $info['total'], $pageSize);
        unset($query['pageSize']); // 减少分页url无用参数
        $paginator->appends($query);  // 设置分页url参数

        $this->typeEnum = array('' =>'所有题型') + $this->typeEnum ;

        $ep = ExamPaper::find($query['id']);
        $epParent = ExamPaper::find($ep->parent_id);

		$p = array(
            'list'       => $info['data'],
            'typeEnum'   => $this->typeEnum,
            'statusEnum' => $this->statusEnum,
            'query'      => $query,
            'paginator'  => $paginator,
            'epParent'	=> $epParent,
            'ep'	=> $ep,
            );

		return $this->adminView('topic.exam', $p);
	}

	public function showType()
	{
		$info = array();
		$info['typeEnum'] = $this->typeEnum;
		return $this->adminView('topic.topic_type', $info);
	}

	public function showAdd()
	{
		$type = Input::get('type');
		$sortId = Input::get('sort');

		if( !array_key_exists($type, $this->typeEnum) )
			$type = 1;

		$info = array();
		$info['typeEnum'] = $this->typeEnum;
		$info['type'] = $type;
		$info['flag'] = $this->flag;

		$info['sort1'] = 0;
		$info['sort2'] = 0;
		$info['sort3'] = 0;
		$info['sort4'] = 0;
		$info['sort5'] = 0;

		// 如果有传递分类id
		if($sortId)
		{
			$sort = new Sort();
			$sortInfo = $sort->getPath($sortId);

			$sortNum = count($sortInfo);
			for ($i = $sortNum; $i > 0; $i--) 
			{
				$v = $sortNum - $i +1;
				$info['sort' . $v] = $sortInfo[$i -1]['id'];

				Session::put('sort'.$v, $info['sort' . $v]);
			}
		}
		else
		{
			$info['sort1'] = Session::get('sort1') ? Session::get('sort1') : 0;
			$info['sort2'] = Session::get('sort2') ? Session::get('sort2') : 0;
			$info['sort3'] = Session::get('sort3') ? Session::get('sort3') : 0;
			$info['sort4'] = Session::get('sort4') ? Session::get('sort4') : 0;
			$info['sort5'] = Session::get('sort5') ? Session::get('sort5') : 0;
		}


		if($type == 1 || $type == 2)
			return $this->adminView('topic.topic_1', $info);
		else if($type == 3)
			return $this->adminView('topic.topic_3', $info);
		else if($type == 4 || $type == 5)
			return $this->adminView('topic.topic_4', $info);
		else if($type == 6)
			return $this->adminView('topic.topic_6', $info);
		else if($type == 7)
			return $this->adminView('topic.topic_7', $info);
		else if($type == 8)
			return $this->adminView('topic.topic_8', $info);
		else if($type == 9 || $type == 10)
			return $this->adminView('topic.topic_9', $info);
	}

	public function doAdd()
	{
		$inputs = Input::all();

		if( empty($inputs['txt']))
			return $this->adminPrompt("操作失败", '题干必须填写', $url = "topic/add?type=" . $inputs['type']);


		// 处理分类
		$sort = 0;
		if( !empty($inputs['sort5']) )
		{
			$sort = $inputs['sort5'];
			Session::put('sort5', $sort);
		}
		elseif( !empty($inputs['sort4']) )
		{
			$sort = $inputs['sort4'];
			Session::put('sort4', $sort);
		}
		elseif( !empty($inputs['sort3']) )
		{
			$sort = $inputs['sort3'];
			Session::put('sort3', $sort);
		}
		elseif( !empty($inputs['sort2']) )
		{
			$sort = $inputs['sort2'];
			Session::put('sort2', $sort);
		}
		elseif( !empty($inputs['sort1']) )
		{
			$sort = $inputs['sort1'];
			Session::put('sort1', $sort);
		}

		

		if( $sort == 0)
			return $this->adminPrompt("操作失败", '必须选择分类', $url = "topic/add?type=" . $inputs['type']);

		$topic = new Topic();
		$qid = $topic->add($inputs);

		// 添加分类信息
		$sar = new SortQuestionRelation();
		$sar->addMap(array('sort' => $sort, 'qid' => $qid));


		/* 处理题干附件 */
		// 题干图片
		$questionAtt = array();
		if(isset($_FILES['file_img']['error']) && $_FILES['file_img']['error'] == UPLOAD_ERR_OK &&
			$attid = $this->setImg( $qid, $_FILES['file_img']['tmp_name']) )
		{
			$questionAtt['img'] = $attid;
		}

		// 提示音
		if(isset($_FILES['file_hint']['error']) && $_FILES['file_hint']['error'] == UPLOAD_ERR_OK)
		{
			$type = $this->att->getExt($_FILES['file_hint']['name']);
			if($type == 'mp3' || $type == 'wav')
			{
				if( $attid = $this->setAudio( $qid, $_FILES['file_hint']['tmp_name'], $type) )
					$questionAtt['hint'] = $attid;
			}

		}

		// 提干音
		if(isset($_FILES['file_sound']['error']) && $_FILES['file_sound']['error'] == UPLOAD_ERR_OK)
		{
			$type = $this->att->getExt($_FILES['file_sound']['name']);
			if($type == 'mp3' || $type == 'wav')
			{
				if( $attid = $this->setAudio( $qid, $_FILES['file_sound']['tmp_name'], $type) )
					$questionAtt['sound'] = $attid;
			}

		}

		// flash
		if(isset($_FILES['file_flash']['error']) && $_FILES['file_flash']['error'] == UPLOAD_ERR_OK)
		{
			$type = $this->att->getExt($_FILES['file_flash']['name']);
			if($type == 'swf' || $type == 'flv')
			{
				if( $attid = $this->setFlash( $qid, $_FILES['file_flash']['tmp_name'], $type) )
					$questionAtt['flash'] = $attid;
			}

		}

		// 跟新题目数据
		$topic->edit($qid, $questionAtt);


		/* 处理答案 */
		if(isset($inputs['answers_txt']))
		{
			foreach($inputs['answers_txt'] as $k => $atxt)
			{
				$answers = array();
				if($atxt)
					$answers['txt'] = $atxt;

				if( !empty($inputs['answers_explain'][$k]) )
					$answers['explain'] = $inputs['answers_explain'][$k];

				if( !empty($inputs['answers_right']) && in_array($k, $inputs['answers_right']) )
					$answers['is_right'] = 1;

				if(isset($_FILES['answers_img']['error'][$k]) && $_FILES['answers_img']['error'][$k] == UPLOAD_ERR_OK &&
					$attid = $this->setImg( $qid, $_FILES['answers_img']['tmp_name'][$k]) )
				{
					$answers['img'] = $attid;
				}


				if(isset($_FILES['answers_sound']['error'][$k]) && $_FILES['answers_sound']['error'][$k] == UPLOAD_ERR_OK)
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
		}

		//return $this->adminPrompt("操作成功", '题目添加成功。', $url = "topic/add?type=" . $inputs['type']);

		return Redirect::to("/admin/topic/add?type=" . $inputs['type']);
	}


	public function showEdit()
	{
		$id = Input::get('id');
		if( !is_numeric($id) )
			return $this->adminPrompt("操作失败", '错误的ID，请返回重试。', $url = "topic");

		$topic = new Topic();
		$info = $topic->get($id);
		
		if( empty($info) )
			return $this->adminPrompt("操作失败", '错误的ID，请返回重试。', $url = "topic");

		$type = $info['q']['type'];
		$info['is_edit'] = 1;
		$info['typeEnum'] = $this->typeEnum;
		$info['flag'] = $this->flag;
		$info['type'] = $type;

		$sqr = new SortQuestionRelation();
		$sqrInfo = $sqr->getMap($id);

		$info['sort1'] = 0;
		$info['sort2'] = 0;
		$info['sort3'] = 0;
		$info['sort4'] = 0;
		$info['sort5'] = 0;

		$sort = new Sort();
		$sortInfo = $sort->getPath($sqrInfo['sort_id']);
		$sortNum = count($sortInfo);
		for ($i = $sortNum; $i > 0; $i--) 
		{
			$v = $sortNum - $i +1;
			$info['sort' . $v] = $sortInfo[$i -1]['id'];

			Session::put('sort'.$v, $info['sort' . $v]);
		}

		// 页面使用
		$_GET['type'] = $type;

		if($type == 1 || $type == 2)
			return $this->adminView('topic.topic_1', $info);
		else if($type == 3)
			return $this->adminView('topic.topic_3', $info);
		else if($type == 4 || $type == 5)
			return $this->adminView('topic.topic_4', $info);
		else if($type == 6)
			return $this->adminView('topic.topic_6', $info);
		else if($type == 7)
			return $this->adminView('topic.topic_7', $info);
		else if($type == 8)
			return $this->adminView('topic.topic_8', $info);
		else if($type == 9 || $type == 10)
			return $this->adminView('topic.topic_9', $info);
	}

	public function doEdit()
	{
		$inputs = Input::all();
		$qid = $inputs['qid'];
		if( !is_numeric($qid) )
			return $this->adminPrompt("操作失败", '错误的ID，请返回重试。', $url = "topic");


		// 处理分类
		if( !empty($inputs['sort5']) )
			$sort = $inputs['sort5'];
		elseif( !empty($inputs['sort4']) )
			$sort = $inputs['sort4'];
		elseif( !empty($inputs['sort3']) )
			$sort = $inputs['sort3'];
		elseif( !empty($inputs['sort2']) )
			$sort = $inputs['sort2'];
		elseif( !empty($inputs['sort1']) )
			$sort = $inputs['sort1'];


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


		// flash
		if(isset($_FILES['file_flash']['error']) && $_FILES['file_flash']['error'] == UPLOAD_ERR_OK)
		{
			$type = $this->att->getExt($_FILES['file_flash']['name']);
			if($type == 'swf' || $type == 'flv')
			{
				if( $attid = $this->setFlash( $qid, $_FILES['file_flash']['tmp_name'], $type) )
					$inputs['flash'] = $attid;
			}

		}

		if(isset($inputs['del_flash']) && is_numeric($inputs['del_flash']))
		{
			$this->att->del($inputs['del_flash']);
			$inputs['flash'] = 0;
		}

		$topic->edit($qid, $inputs);


		// 跟新分类信息
		if(isset($sort))
		{
			$sar = new SortQuestionRelation();
			$sar->updateMap(array('sort' => $sort, 'qid' => $qid));
		}

		/* 处理答案 */
		if(isset($inputs['answers_txt']))
		{
			foreach($inputs['answers_txt'] as $k => $atxt)
			{
				$aid = empty($inputs['aid'][$k]) ? 0 : $inputs['aid'][$k];
				$aimgid = empty($inputs['answers_img_id'][$k]) ? 0 : $inputs['answers_img_id'][$k];
				$asoundid = empty($inputs['answers_sound_id'][$k]) ? 0 : $inputs['answers_sound_id'][$k];

				$answers = array();
				
				$answers['txt'] = $atxt;

				if( isset($inputs['answers_explain'][$k]) )
					$answers['explain'] = $inputs['answers_explain'][$k];
				
				if( isset($inputs['answers_right']) && in_array($aid, $inputs['answers_right']) )
					$answers['is_right'] = 1;
				else
					$answers['is_right'] = 0;

				if(isset($_FILES['answers_img']) && $_FILES['answers_img']['error'][$k] == UPLOAD_ERR_OK )
				{
					if($aimgid)
						$this->att->del($aimgid);

					$attid = $this->setImg( $qid, $_FILES['answers_img']['tmp_name'][$k]);
					$answers['img'] = $attid;
				}


				if(isset($_FILES['answers_sound']) && $_FILES['answers_sound']['error'][$k] == UPLOAD_ERR_OK)
				{
					$type = $this->att->getExt($_FILES['answers_sound']['name'][$k]);
					if($type == 'mp3' || $type == 'wav')
					{
						if($asoundid)
							$this->att->del($asoundid);

						$answers['sound'] = $this->setAudio( $qid, $_FILES['answers_sound']['tmp_name'][$k], $type);
					}
				}


				if(isset($inputs['del_answers_img']) && in_array($aimgid, $inputs['del_answers_img']) )
				{
					$this->att->del($aimgid);
					$answers['img'] = 0;
				}

				if(isset($inputs['del_answers_sound']) && in_array($asoundid, $inputs['del_answers_sound']) )
				{
					$this->att->del($asoundid);
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

		// 删除可能存在的空答案
		$topic->delNullAnswer($qid);

		//return $this->adminPrompt("操作成功", '题目编辑成功。', $url = "topic/edit?id=" . $qid);
		return $this->adminPrompt("操作成功", '题目编辑成功。', $url = "topic");
	}

	/* 删除题目 */
	public function doDel()
	{
		$inputs = Input::all();
		$qid = $inputs['qid'];

		if(!is_numeric($qid))
		{
			if(isset($inputs['ajax']))
				exit("0");
			else
				return $this->adminPrompt("操作失败", '错误的ID，请返回重试。', $url = "topic");
		}


		$topic = new Topic();
		$topic->del($qid);

		if(isset($inputs['ajax']))
			exit("1");	
		else
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

	public function setFlash($qid, $file, $type)
	{
	    $attid = $this->att->addTopicAudio($qid, $file, $type);
	    return $attid;
	}

}
