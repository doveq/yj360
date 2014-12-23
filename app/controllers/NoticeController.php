<?php

class NoticeController extends BaseController {

    public $typeEnum = array('1' => '帮助手册', '2' => '系统公告', '3' => '360 活动', '4' => '问题反馈');
    public $pageSize = 30;

    public function index()
    {
        return $this->indexView('profile.feedback');
    }

    public function showList()
    {
        $query = Input::only('column_id', 'type');

        $validator = Validator::make($query , array(
            'column_id' => 'numeric',
            'type' => 'required|numeric')
        );

        if(!$validator->passes())
        {
            return $this->indexPrompt("操作失败", "错误的访问参数", $url = "/", $auto = true);
        }

        $columns = '';
        $columnHead = '';
        if(!empty($query['column_id']))
        {
            $columns = Column::find($query['column_id'])->child()->whereStatus(1)->orderBy('ordern', 'ASC')->get();
            // 获取父类名页面显示
            $cn = new Column();
            $arr = $cn->getPath($query['column_id']);
            $columnHead = $arr[0];
        }

        // 获取
        $notice = new Notice();
        $where = array();
        $where['type'] = $query['type'];
        $where['pageSize'] = $this->pageSize;
        $where['status'] = 1;
        
        $utype = Session::get('utype', -999);
        if($utype == 1)
            $where['allow'] = 2;  // 老师
        elseif($utype == 0)
            $where['allow'] = 1;  // 学生

        $list = $notice->getList($where);

        // 获取评论列表
        $nc = new NoticeComments();
        
        
        $typeEnum = $this->typeEnum;
        return $this->indexView('notice.faq', compact('list', 'columns', 'columnHead', 'query', 'typeEnum'));
    }

    public function show()
    {
        $query = Input::only('column_id', 'id', 'type');

        $validator = Validator::make($query , array(
            'column_id' => 'numeric',
            'id' => 'required|numeric')
        );

        if(!$validator->passes())
        {
            return $this->indexPrompt("操作失败", "错误的访问参数", $url = "/", $auto = true);
        }

        $columns = '';
        $columnHead = '';
        if(!empty($query['column_id']))
        {
            $columns = Column::find($query['column_id'])->child()->whereStatus(1)->orderBy('ordern', 'ASC')->get();
            // 获取父类名页面显示
            $cn = new Column();
            $arr = $cn->getPath($query['column_id']);
            $columnHead = $arr[0];
        }

        // 获取详情
        $notice = new Notice();
        $info = $notice->getInfo($query['id']);
        
        // 获取评论详情
        $nc = new NoticeComments();
        $comments = $nc->getListPage($query['id'], $this->pageSize);
        
        // 获取评论楼层
        $floornums = $nc->getFloornums($query['id']); // key:commentid,val:floornum
        
        $typeEnum = $this->typeEnum;
        return $this->indexView('notice.show', 
        		compact('info', 'columns', 'columnHead', 'query', 
        				'typeEnum', 'comments', 'floornums'));
    }

    /* 评论内容 */
    public function doComment()
    {
        $query = Input::only('notice_id', 'content', 'column_id', 'parent_id');

        $validator = Validator::make($query , array(
            'column_id' => 'numeric',
            'notice_id' => 'required|numeric',
            'parent_id' => 'numeric',
            'content' => 'required')
        );

        $query['content'] = htmlspecialchars( trim( $query['content'] ) );

        if(!$validator->passes() || $query['content'] == '' )
        {
            //return $this->indexPrompt("操作失败", "错误的提交数据", $url = "/notice/show?id={$query['notice_id']}&column_id={$query['column_id']}", $auto = true);
            return Redirect::to("/notice/show?id={$query['notice_id']}&column_id={$query['column_id']}");
        }

        $data = array();
        $data['uid'] = Session::get('uid');
        $data['notice_id'] = $query['notice_id'];
        $data['content'] = $query['content'];
        $data['parent_id'] = $query['parent_id'] ? $query['parent_id'] : 0;

        $nc = new NoticeComments();
        $nc->addInfo( $data );

        return Redirect::to("/notice/show?id={$query['notice_id']}&column_id={$query['column_id']}");
    }

}
