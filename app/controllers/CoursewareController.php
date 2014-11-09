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
        $query = Input::only('column_id', 'd1', 'type', 'id', 'q');
        $columns = Column::find($query['column_id'])->child()->whereStatus(1)->orderBy('ordern', 'ASC')->get();
        // dd($columns);
        // dd(public_path() . '/data/flash_exe/info.php');
        (!isset($query['id'])) ? $query['id']=3 : $query['id']=$query['id'];
        (!isset($query['type'])) ? $query['type']=1 : $query['type']=$query['type'];

        if ($query['type'] == 1) {
            $config_path = "/data/flash_exe/";
            $column_name = '多媒体课件';
            $back_url = "/courseware?id=".$query['id']."&column_id=". $query['column_id'] . "&type=" . $query['type'];
        } else {
            $config_path = "/data/multimedia/";
            $column_name = '多媒体教材';
            $back_url = "/courseware?id=".$query['id']."&column_id=". $query['column_id'] . "&type=" . $query['type'];
        }
        include_once public_path() . $config_path . "info.php";

        $lists = array();
        //检索
        if ($query['q'] != '') {
            foreach ($dir_info as $key => $d) {
                foreach ($d['files'] as $key => $f) {
                    if (stristr($f['name'],$query['q']) !== false) {
                        $lists['files'][] = array('name' => $f['name'], 'path' => $f['path']);
                    }
                }
            }
        } else {
            if (!isset($query['d1'])) {
                $lists = $dir_info;
            } else {
                $lists = $dir_info[$query['d1']];
            }
        }
//     $dir_info = array(
// array(
//     'name' => '第一册',
//     'pic' => '',
//     'files' => array(
//         array(
//             'name' => 'xxxx',
//             'pic' => '',
//             'path' => 'chapter1/1/',
//         ),
//         array(
//             'name' => 'yyyy',
//             'pic' => '',
//             'path' => 'chapter1/2/',
//         ),
//     ),
// ),
// array(
//     'name' => '第二册',
//     'pic' => '',
//     'files' => array(
//         array(
//             'name' => 'xxxx',
//             'pic' => '',
//             'path' => 'chapter2/1/',
//         ),
//         array(
//             'name' => 'yyyy',
//             'pic' => '',
//             'path' => 'chapter2/2/',
//         ),
//     ),
// ),


// );


        return $this->indexView('courseware.index', compact('columns', 'query', 'lists', 'config_path', 'back_url', 'column_name'));
	}

}
