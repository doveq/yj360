<?php

// 题目收藏夹

class FavoriteController extends BaseController
{

    public function __construct()
    {
    }

    public function index()
    {
        $query = Input::only('id', 'column_id');

        $info = array();
        $f = new Favorite();
        $list = $f->getList( array('uid' => Session::get('uid'), 'column_id' => $query['column_id'], 'limit' => 15 ) );

        if(empty($query['column_id']))
            return $this->indexView('profile.favorite', array('list' => $list) );
        else
        {
            // 分类页面显示

            $columns = Column::find($query['column_id'])->child()->whereStatus(1)->get();

            // 获取父类名页面显示
            $cn = new Column();
            $arr = $cn->getPath($query['column_id']);
            $columnHead = $arr[0];

            return $this->indexView('column.favorite', compact('list', 'columns', 'columnHead', 'query') );
        }
    }

    public function doDel()
    {
        $id = Input::get('qid');
        $column_id = Input::get('column_id');

        if(!is_numeric($id))
            return $this->indexPrompt("", "错误的ID号", $url = "/favorite");

        $f = new Favorite();
        $f->del( array('uid' => Session::get('uid'), 'qid' => $id ) );

        if(empty($column_id))
            return $this->indexPrompt("", "删除收藏成功", $url = "/favorite");
        else
            return $this->indexPrompt("", "删除收藏成功", $url = "/favorite?column_id=". $column_id);
    }

    public function ajax()
    {
        $inputs = Input::all();
        if(!is_numeric($inputs['qid']) || !is_numeric($inputs['column']))
            return Response::json(array('act' => $inputs['act'], 'state' => '0'));

        $info['uid'] = Session::get('uid');
        $info['qid'] = $inputs['qid'];
        $info['column_id'] = $inputs['column'];

        if($inputs['act'] == 'add')
        {
            $f = new Favorite();
            $f->add($info);
        }
        else if($inputs['act'] == 'del')
        {
            $f = new Favorite();
            $f->del($info);
        }

        return Response::json(array('act' => $inputs['act'], 'state' => '1'));
    }

    public function choose()
    {
        $training_id = Input::only('training_id');

        $info = array();
        $f = new Favorite();
        $lists = $f->getList( array('uid' => Session::get('uid'), 'limit' => 15 ) );

        return $this->indexView('favorite.choose', compact('lists') );
    }
}
