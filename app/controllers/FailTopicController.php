<?php

// 错误记录

class FailTopicController extends BaseController
{

	public function __construct()
    {

    }

	public function index()
	{
		$query = Input::only('id', 'column_id');

		$info = array();
		$f = new FailTopic();
		$list = $f->getList( array('uid' => Session::get('uid'),  'limit' => 15 ) );

		if(empty($query['column_id']))
			return $this->indexView('profile.failTopic', array('list' => $list) );
		else
		{
			// 分类页面显示

			$columns = Column::find($query['column_id'])->child()->whereStatus(1)->orderBy('ordern', 'ASC')->get();

			// 获取父类名页面显示
	        $cn = new Column();
	        $arr = $cn->getPath($query['column_id']);
	        $columnHead = $arr[0];

	        $typeEnum = Config::get('app.topic_type'); // 读取配置文件

			return $this->indexView('column.failTopic', compact('list', 'columns', 'columnHead', 'query', 'typeEnum') );
		}
	}

	public function doDel()
	{
		$id = Input::get('id');
		$column_id = Input::get('column_id');

		if(!is_numeric($id))
			return $this->indexPrompt("", "错误的ID号", $url = "/failTopic");

		$f = new FailTopic();
		$f->del( array('uid' => Session::get('uid'), 'id' => $id ) );

		if(empty($column_id))
		{
			//return $this->indexPrompt("", "删除错题记录成功", $url = "/failTopic");
			return Redirect::to("/failTopic");
		}
		else
		{
			//return $this->indexPrompt("", "删除错题记录成功", $url = "/failTopic?column_id=". $column_id);
			return Redirect::to("/failTopic?column_id=". $column_id);
		}
	}

}
