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
        $query = Input::only('id');
        $question = Question::find($query['id']);

        return $this->indexView('column.' . $column->type, compact('column'));
	}

}
