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
        $query = Input::only('column_id', 'd1', 'type');
        $columns = Column::find($query['column_id'])->child()->whereStatus(1)->orderBy('ordern', 'ASC')->get();
        // dd($columns);
        // dd(public_path() . '/data/flash_exe/info.php');
        (!isset($query['type'])) ? $query['type']=1 : $query['type']=$query['type'];
        //科教
        if ($query['type'] == 1) {
            $config_path = "/data/flash_exe/";
        } else {
            $config_path = "/data/multimedia/";
        }
        include_once public_path() . $config_path . "info.php";

        $lists = array();
        if (!isset($query['d1'])) {
            $lists = $dir_info;
        } else {
            $lists = $dir_info[$query['d1']];
        }
        return $this->indexView('courseware.index', compact('columns', 'query', 'lists', 'config_path'));
	}

}
