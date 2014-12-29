<?php

/**
 * 班级公告
 */
class ClassesNoticeController extends BaseController {
	public $pageSize = 20;
	
	public function __construct() {
		$query = Input::only('column_id');
		if ((!isset($query['column_id']) || !is_numeric($query['column_id'])) && Request::path() != 'column/static') {
			echo ("<script>window.location.href='/column/static';</script>");
		}
	}
	
	/**
	 * 跳转到班级消息群发页面
	 */
	public function batchmsg() {
	    $query = Input::only('column_id', 'class_id');
	    $validator = Validator::make($query , array(
	        'class_id' => array('numeric', 'required')
	    ));
	    if(!$validator->passes()) {
	        return $this->indexPrompt("操作失败", "错误的访问参数", $url = "/", $auto = true);
	    }
	    // 分类页面显示
	    $columns = Column::find($query['column_id'])->child()->whereStatus(1)->orderBy('ordern', 'ASC')->get();
	    // 获取父类名页面显示
	    $col = new Column();
	    $arr = $col->getPath($query['column_id']);
	    $columnHead = $arr[0];
	    
	    // 查询班级信息
	    $c = new Classes();
	    $classes = $c->whereId($query['class_id'])->first();
	    
	    // 班级内学生
	    $students = $classes->students()->get();
	    
	    return $this->indexView('classes.batchmsg',
	            compact('query', 'columns', 'columnHead', 'classes', 'students'));
	}
	
	/**
	 * 执行班级消息群发
	 */
	public function dobatchmsg() {
	    $query = Input::only('column_id', 'class_id', 'content', 'stu');
	    $validator = Validator::make($query , array(
	        'class_id' => array('numeric', 'required')
	    ));
	    if(!$validator->passes()) {
	        return $this->indexPrompt("操作失败", "错误的访问参数", $url = "/", $auto = true);
	    }
	    if(!isset($query['content']) || $query['content'] == '') {
	        return $this->indexPrompt("操作成功", "消息内容不能为空", 
	            $url = "/classes_notice/batchmsg?column_id={$query['column_id']}&class_id={$query['class_id']}", $auto = true);
	    }
	    // 分类页面显示
	    $columns = Column::find($query['column_id'])->child()->whereStatus(1)->orderBy('ordern', 'ASC')->get();
	    // 获取父类名页面显示
	    $col = new Column();
	    $arr = $col->getPath($query['column_id']);
	    $columnHead = $arr[0];
	    
	    // 查询班级学生列表
	    $classes = Classes::whereId($query['class_id'])->first();
	    $uid = Session::get('uid');
	    if(empty($classes) || $classes->teacherid != $uid) {
	        return $this->indexPrompt("操作失败", "错误的访问参数", $url = "/", $auto = true);
	    }
	    
	    $stuids = array();
	    if(!isset($query['stu']) || empty($query['stu'])) {
    	    $stus = $classes->students()->where('classmate.status', 1)->get();
    	    if(empty($stus) || $stus->count() == 0) {
    	        return $this->indexPrompt("操作失败", "班级内无学生，无法群发消息", $url = "/classes/{$query['class_id']}?column_id={$query['column_id']}", $auto = true);
    	    }
	        // 给所有学生发消息
	        foreach($stus as $stu) {
	            if(empty($stu)) {
	                continue;
	            }
	            $stuids[] = $stu->id;
	        }
	    } else {
	        $stuids = $query['stu']; // 只给部分学生发消息
	    }
	    $this->_dobatchmsg($stuids, $query['content']);
	    
	    return $this->indexPrompt("操作成功", "消息群发成功", $url = "/classes/{$query['class_id']}?column_id={$query['column_id']}", $auto = true);
	}
	
	public function _dobatchmsg($stuids, $content) {
	    if(empty($stuids)) {
	        return;
	    }
	    $content = htmlspecialchars(trim($content));
	    $uid = Session::get('uid');
	    // 循环给班级中每个学生发送一条消息
	    $msgs = array();
	    $time = date("Y-m-d H:i:s");
	    foreach($stuids as $stuid) {
	        $msg = array();
	        $msg['sender_id'] = $uid;
	        $msg['receiver_id'] = $stuid;
	        $msg['content'] = $content;
	        $msg['created_at'] = $time;
	        $msg['type'] = 1;
	        $msg['dialog'] = 1;
	        $msgs[] = $msg;
	    }
	    $msg_model = new Message();
	    $msg_model->insert($msgs); 
	}
	
	/**
	 * 班级消息列表
	 */
    public function showList() {
    	$query = Input::only('column_id', 'class_id');
    	$validator = Validator::make($query , array(
            'column_id' => 'numeric',
            'class_id' => array('numeric', 'required')
    	));
    	if(!$validator->passes()) {
    		return $this->indexPrompt("操作失败", "错误的访问参数", $url = "/", $auto = true);
    	}
    	
    	// 分类页面显示
    	$columns = Column::find($query['column_id'])->child()->whereStatus(1)->orderBy('ordern', 'ASC')->get();
    	// 获取父类名页面显示
    	$col = new Column();
    	$arr = $col->getPath($query['column_id']);
    	$columnHead = $arr[0];
    	
    	// 查询班级信息
    	$c = new Classes();
    	$classes = $c->whereId($query['class_id'])->first();
    	
    	// 获取班级消息列表
    	$cn = new ClassesNotice();
    	$info['uid'] = Session::get('uid');
    	$info['class_id'] = $query['class_id'];
    	$cnList = $cn->getListPage($info, $this->pageSize);
    	
    	return $this->indexView('classes.notice', 
    			compact('query', 'columns', 'columnHead', 'classes', 'cnList', 'use_ordern'));
    }
    
    /**
     * 查看某条班级消息页面
     */
    public function show() {
    	$query = Input::only('column_id', 'id', 'class_id');
    	$validator = Validator::make($query , array(
    			'column_id' => 'numeric',
    			'id' => 'numeric|required'
    	));
    	if(!$validator->passes()) {
    		return $this->indexPrompt("操作失败", "错误的访问参数", $url = "/", $auto = true);
    	}
    	 
    	// 分类页面显示
    	$columns = Column::find($query['column_id'])->child()->whereStatus(1)->orderBy('ordern', 'ASC')->get();
    	// 获取父类名页面显示
    	$col = new Column();
    	$arr = $col->getPath($query['column_id']);
    	$columnHead = $arr[0];
    	 
    	// 计算公告浏览量和当前用户是否已读该公告
    	$cn = new ClassesNotice();
    	$ip = Request::getClientIp();
    	$cn->computeVisits($query['id'], $ip);
    	$cn->computeReads($query['id'], Session::get('uid'));
    	
    	// 查询消息内容
    	$info = $cn->getInfo($query['id']);
    	
    	// 消息对应评论
    	$cnc = new ClassesNoticeComments();
    	$comments = $cnc->getListPage($query['id'], $this->pageSize);
    	
    	// 获取评论楼层
    	$floornums = $cnc->getFloornums($query['id']); // key:commentid,val:floornum
    	 
    	return $this->indexView('classes.notice_show',
    			compact('query', 'columns', 'columnHead', 'info', 'comments', 'floornums'));
    }
    
    /**
     * 跳转到班级消息添加页面
     */
    public function create() {
    	$query = Input::only('column_id', 'class_id');
    	$validator = Validator::make($query , array(
			'column_id' => 'numeric',
			'class_id' => array('numeric', 'required')
    	));
    	if(!$validator->passes()) {
    		return $this->indexPrompt("操作失败", "错误的访问参数", $url = "/", $auto = true);
    	}
    	
    	// 分类页面显示
    	$columns = Column::find($query['column_id'])->child()->whereStatus(1)->orderBy('ordern', 'ASC')->get();
    	// 获取父类名页面显示
    	$col = new Column();
    	$arr = $col->getPath($query['column_id']);
    	$columnHead = $arr[0];
    	
    	// 查询班级信息
    	$c = new Classes();
    	$classes = $c->whereId($query['class_id'])->first();
    	
    	$mode = '发布公告';
    	
    	return $this->indexView('classes.notice_edit',
    			compact('query', 'columns', 'columnHead', 'classes', 'mode'));
    }
    
    /**
     * 跳转到班级消息编辑页面
     */
    public function edit() {
    	$query = Input::only('id', 'column_id', 'class_id');
    	$validator = Validator::make($query , array(
            'id' => array('numeric', 'required'),
            'column_id' => 'numeric',
            'class_id' => array('numeric', 'required')
    	));
    	if(!$validator->passes()) {
    		return $this->indexPrompt("操作失败", "错误的访问参数", $url = "/", $auto = true);
    	}
    	 
    	// 分类页面显示
    	$columns = Column::find($query['column_id'])->child()->whereStatus(1)->orderBy('ordern', 'ASC')->get();
    	// 获取父类名页面显示
    	$col = new Column();
    	$arr = $col->getPath($query['column_id']);
    	$columnHead = $arr[0];
    	
    	// 查询班级信息
    	$c = new Classes();
    	$classes = $c->whereId($query['class_id'])->first();
    	
    	// 查询消息内容
    	$cn = new ClassesNotice();
    	$notice = $cn->getInfo($query['id']);

    	$mode = '编辑公告';
    	
    	return $this->indexView('classes.notice_edit',
    			compact('query', 'columns', 'columnHead', 'notice', 'classes', 'mode'));
    }
    
    /**
     * 班级消息添加/修改
     */
    public function doEdit() {
    	$query = Input::only('id', 'column_id', 'class_id', 'title', 'content', 'ordern');
    	$validator = Validator::make($query , array(
			'title' => 'required',
			'content' => 'required'
    	));
    	if(!$validator->passes()) {
    		return $this->indexPrompt("操作失败", "错误的访问参数", $url = "/", $auto = true);
    	}
    	
    	if(!isset($query['id']) || empty($query['id'])) {
    		// 添加
    		$cn = new ClassesNotice();
    		$info['uid'] = Session::get('uid');
    		$info['class_id'] = $query['class_id'];
    		$info['title'] = $query['title'];
    		$info['content'] = $query['content'];
    		if(!isset($query['ordern']) || empty($query['ordern'])) {
    		    $ordern = '0';
    		} else {
    		    $ordern = $query['ordern'];
    		}
    		$info['ordern'] = $ordern;
    		$id = $cn->addInfo($info);
    		
    		if(!isset($query['ordern']) || empty($query['ordern'])) {
    		    // 未设置排序序号时使用id作为排序序号
    		    $info['ordern'] = $id;
    		    $cn->editInfo($id, $info);
    		}
    	} else {
    		// 修改
    		$cn = new ClassesNotice();
    		$info['uid'] = Session::get('uid');
    		$info['class_id'] = $query['class_id'];
    		$info['title'] = $query['title'];
    		$info['content'] = $query['content'];
    		$info['ordern'] = $query['ordern'];
    		$cn->editInfo($query['id'], $info);
    	}
    	
    	return Redirect::to("/classes_notice/showList?class_id=". $query['class_id']."&column_id=".$query['column_id']);
    }
    
    /**
     * 删除班级消息
     */
    public function doDel() {
    	$query = Input::only('column_id', 'id', 'class_id');
    	$validator = Validator::make($query , array(
    		'id' => 'required',
    		'class_id' => 'required'
    	));
    	if(!$validator->passes()) {
    		return $this->indexPrompt("操作失败", "消息标题或内容不能为空", $url = "/", $auto = true);
    	}
    	 
    	// 获取班级消息列表
    	$cn = new ClassesNotice();
    	$cn->delInfo($query['id']);
    	
    	// 同时删除消息评论
    	$cnc = new ClassesNoticeComments();
    	$cnc->delByNotice($query['id']);
    	
    	// 同时删除ip_page表中相关记录
    	$ipmodel = new IpPage();
    	$ipmodel->delByPageType($query['id'], 1);
    	
    	// 同时删除class_notice_user表中相关记录
    	$cnu = new ClassesNoticeUser();
    	$cnu->delByNotice($query['id']);
    	 
    	return Redirect::to("/classes_notice/showList?class_id=". $query['class_id']."&column_id=".$query['column_id']);
    }
    
    /**
     * 发表评论
     */
    public function doComment() {
        $query = Input::only('notice_id', 'class_id', 'content', 'column_id', 'parent_id');
    
        $validator = Validator::make($query , array(
            'column_id' => 'numeric',
            'class_id' => array('required', 'numeric'),
            'notice_id' => array('required', 'numeric'),
            'parent_id' => 'numeric',
            'content' => 'required')
        );
        $notice_id = $query['notice_id'];
        $class_id = $query['class_id'];
        $column_id = $query['column_id'];
    
        $query['content'] = htmlspecialchars( trim( $query['content'] ) );
    
        if(!$validator->passes() || $query['content'] == '' ) {
            return Redirect::to("/classes_notice/show?id=$notice_id&class_id=$class_id&column_id=$column_id");
        }
    
        $data = array();
        $data['uid'] = Session::get('uid');
        $data['notice_id'] = $query['notice_id'];
        $data['class_id'] = $query['class_id'];
        $data['content'] = $query['content'];
        $data['parent_id'] = $query['parent_id'] ? $query['parent_id'] : 0;
    
        $cnc = new ClassesNoticeComments();
        $cnc->addInfo($data);
        
        return Redirect::to("/classes_notice/show?id=$notice_id&class_id=$class_id&column_id=$column_id");
    }
    
    /**
     * 删除评论
     */
    public function doCommentDel() {
        $query = Input::only('comment_id', 'notice_id', 'class_id', 'column_id');
        
        $validator = Validator::make($query , array(
            'comment_id' => array('required', 'numeric'),
            'notice_id' => array('required', 'numeric'),
            'class_id' => array('required', 'numeric'),
            'notice_id' => array('required', 'numeric')
        ));
        $comment_id = $query['comment_id'];
        $notice_id = $query['notice_id'];
        $class_id = $query['class_id'];
        $column_id = $query['column_id'];
        if(!$validator->passes()) {
            return Redirect::to("/classes_notice/show?id=$notice_id&class_id=$class_id&column_id=$column_id");
        }
        
        $cnc = new ClassesNoticeComments();
        $cnc->delInfo($comment_id);
        
        return Redirect::to("/classes_notice/show?id=$notice_id&class_id=$class_id&column_id=$column_id");
    }
}
