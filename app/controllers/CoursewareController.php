<?php

class CoursewareController extends BaseController
{

	public function __construct()
    {
    	//$this->beforeFilter('csrf', array('on' => 'post'));
    }

	/* 登录处理 */
	public function index()
	{
        $query = Input::only('column_id', 'd1');
        $columns = Column::find($query['column_id'])->child()->whereStatus(1)->orderBy('ordern', 'ASC')->get();
        // dd($columns);
        // dd(public_path() . '/data/flash_exe/info.php');
        include_once public_path() . '/data/flash_exe/info.php';

        $lists = array();
        if (!isset($query['d1'])) {
            // foreach ($dir_info as $key => $value) {
            //     $lists[$key] = array('name' => $value['name']);
            // }
            $lists = $dir_info;
        } else {
            // foreach ($dir_info[$query['d1']]['files'] as $key => $value) {
            //     $lists[$key] = array('name' => $value['name']);
            // }
            $lists = $dir_info[$query['d1']];
        }
        return $this->indexView('courseware.index', compact('columns', 'query', 'lists'));
	}

}
