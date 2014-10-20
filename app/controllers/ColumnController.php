<?php

class ColumnController extends BaseController
{

	public function __construct()
    {
    	//$this->beforeFilter('csrf', array('on' => 'post'));
    }

	/* 登录处理 */
	public function index()
	{
        $query = Input::only('id', 'column_id');
        $column = Column::find($query['id']);
        $content = $column->child()->whereStatus(1)->get();

        if (!isset($query['column_id'])) {
            $query['column_id'] = 3;
        }
        $columns = Column::find($query['column_id'])->child()->whereStatus(1)->get();

        $questions = $column->questions;

        return $this->indexView('column.' . $column->type, compact('column', 'content', 'columns', 'query', 'questions'));
	}

}
