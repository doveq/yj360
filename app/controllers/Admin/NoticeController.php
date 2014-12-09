<?php namespace Admin;
use View;
use Session;
use Validator;
use Input;
use Paginator;
use Redirect;
use DB;
use Notice;

class NoticeController extends \BaseController {

    public $typeEnum = array('1' => '帮助', '2' => '公告', '3' => '活动');
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
        return $this->adminView('notice.index', compact('query', 'list', 'typeEnum'));
    }

    public function add()
    {
        $typeEnum = $this->typeEnum;
        return $this->adminView('notice.add', compact('typeEnum'));
    }

    public function doAdd()
    {
        $query = Input::only('title', 'content', 'type');
        $query['uid'] = Session::get('uid');
        $notice = new Notice();
        $notice->addInfo($query);

        return $this->adminPrompt("操作成功", '数据添加成功', $url = "/admin/notice");
    }

    public function edit()
    {
        $id = Input::get('id');
        $notice = new Notice();
        $info = $notice->getInfo($id);

        $typeEnum = $this->typeEnum;
        return $this->adminView('notice.edit', compact('typeEnum', 'info'));
    }

    public function doEdit()
    {
        $query = Input::only('title', 'content', 'type');
        $id = Input::get('id');

        $notice = new Notice();
        $notice->editInfo($id, $query);

        return $this->adminPrompt("操作成功", '数据编辑成功', $url = "/admin/notice");
    }

    public function doDel()
    {
        $id = Input::get('id');

        $notice = new Notice();
        $notice->delInfo($id);

        return $this->adminPrompt("操作成功", '数据删除成功', $url = "/admin/notice");
    }
}
