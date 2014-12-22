<?php namespace Admin;
use View;
use Session;
use Validator;
use Input;
use Paginator;
use Redirect;
use DB;
use Notice;
use NoticeComments;
use IpPage;

class NoticeController extends \BaseController {

    public $typeEnum = array('1' => '帮助', '2' => '公告', '3' => '活动');
    public $statusEnum = array('1' => '通过', '0' => '未通过');
    public $allowEnum = array('0' => '全部', '1' => '学生', '2' => '老师');
    public $pageSize = 30;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $query = Input::only('page', 'type', 'title');
        $query['pageSize'] = $this->pageSize;

        // 当前页数
        if( !is_numeric($query['page']) || $query['page'] < 1 )
            $query['page'] = 1;

        $notice = new Notice();
        $list = $notice->getList($query);

        $typeEnum = array('' => '全部') + $this->typeEnum;
        $statusEnum = $this->statusEnum;
        $allowEnum = $this->allowEnum;
        return $this->adminView('notice.index', compact('query', 'list', 'typeEnum', 'statusEnum', 'allowEnum'));
    }

    public function add()
    {
        $typeEnum = $this->typeEnum;
        $statusEnum = $this->statusEnum;
        $allowEnum = $this->allowEnum;
        return $this->adminView('notice.add', compact('typeEnum', 'statusEnum', 'allowEnum'));
    }

    public function doAdd()
    {
        $query = Input::only('title', 'content', 'type', 'status', 'allow', 'ordern'); // 增加排序序号
        if(isset($query['ordern']) && !is_numeric($query['ordern'])) {
        	$query['ordern'] = '0';
        }
        
        $query['uid'] = Session::get('uid');
        $notice = new Notice();
        $insertedId = $notice->addInfo($query);
        
        if ($query['ordern'] == '0') {
        	// 未设置排序序号时使用当前id
        	$query['ordern'] = $insertedId;
        	$notice->editInfo($insertedId, $query);
        }

        return $this->adminPrompt("操作成功", '数据添加成功', $url = "/admin/notice");
    }

    public function edit()
    {
        $id = Input::get('id');
        $notice = new Notice();
        $info = $notice->getInfo($id);

        $typeEnum = $this->typeEnum;
        $statusEnum = $this->statusEnum;
        $allowEnum = $this->allowEnum;
        return $this->adminView('notice.edit', compact('typeEnum', 'statusEnum', 'allowEnum', 'info'));
    }

    public function doEdit()
    {
        $query = Input::only('title', 'content', 'type', 'status', 'allow', 'ordern'); // 增加排序序号
        $id = Input::get('id');
        if(isset($query['ordern']) && !is_numeric($query['ordern'])) {
        	$query['ordern'] = $id;
        }

        $notice = new Notice();
        $notice->editInfo($id, $query);

        return $this->adminPrompt("操作成功", '数据编辑成功', $url = "/admin/notice");
    }

    public function doDel()
    {
        $id = Input::get('id');

        $notice = new Notice();
        $notice->delInfo($id);
        
        // 同时删除消息评论
        $nc = new NoticeComments();
        $nc->delByNotice($id);
        
        // 同时删除ip_page表中相关记录
        $ipmodel = new IpPage();
        $ipmodel->delByPageType($id, 0);

        return $this->adminPrompt("操作成功", '数据删除成功', $url = "/admin/notice");
    }
    
    /**
     * 评论列表
     */
    public function comment() {
        $query = Input::only('page', 'type', 'title', 'id');
        $query['pageSize'] = $this->pageSize;

        // 当前页数
        if( !is_numeric($query['page']) || $query['page'] < 1 ) {
            $query['page'] = 1;
        }

        $notice = new Notice();
        $noticeinfo = $notice->getInfo($query['id']);

        $typeEnum = array('' => '全部') + $this->typeEnum;
        $statusEnum = $this->statusEnum;
        $allowEnum = $this->allowEnum;
        
        // 获取评论详情
        $nc = new NoticeComments();
        $comments = $nc->getListPage($query['id'], $this->pageSize);
        
        // 获取评论楼层
        $floornums = $nc->getFloornums($query['id']); // key:commentid,val:floornum
        
    	return $this->adminView('notice.comment', 
    			compact('query', 'typeEnum', 'statusEnum', 'allowEnum', 
    					'noticeinfo', 'comments', 'floornums'));
    }
    
    /**
     * 删除评论
     */
    public function doCommentDel() {
    	$id = Input::get('id'); // comment_id
    	$noticeid = Input::get('noticeid'); // notice_id
    	$nc = new NoticeComments();
    	$nc->delInfo($id);
    	return $this->adminPrompt("操作成功", '数据删除成功', $url = "/admin/notice/comment?id=".$noticeid, true);
    }
    
    /**
     * 转到回复页
     */
    public function reply() {
    	$commentid = Input::get('commentid'); // comment_id
    	$noticeid = Input::get('noticeid'); // notice_id
    	$nc = new NoticeComments();
    	$comment = $nc->getInfo($commentid); // 评论内容
    	return $this->adminView('notice.reply', compact('commentid', 'noticeid', 'comment'));
    }
    
    /**
     * 发表回复
     */
    public function doReply() {
    	$query = Input::only('commentid', 'noticeid', 'content');
    	$data = array();
    	$data['uid'] = Session::get('uid');
    	$data['notice_id'] = $query['noticeid'];
    	$data['content'] = $query['content'];
    	$data['parent_id'] = $query['commentid'] ? $query['commentid'] : 0;
    	$nc = new NoticeComments();
    	$nc->addInfo( $data );
    	return $this->adminPrompt("操作成功", '回复成功', $url = "/admin/notice/comment?id=".$query['noticeid'], true);
    }
}
