<?php

class NoticeController extends BaseController {

    public $typeEnum = array('1' => '帮助手册', '2' => '系统公告', '3' => '音基360活动');
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
        $list = $notice->getList(array('type' => $query['type'], 'pageSize' => $this->pageSize));

        $typeEnum = $this->typeEnum;
        return $this->indexView('notice.faq', compact('list', 'columns', 'columnHead', 'query', 'typeEnum'));
    }

    public function show()
    {
        $query = Input::only('column_id', 'id');

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

        // 获取
        $notice = new Notice();
        $info = $notice->getInfo($query['id']);
        
        $typeEnum = $this->typeEnum;
        return $this->indexView('notice.show', compact('info', 'columns', 'columnHead', 'query', 'typeEnum'));
    }

}
