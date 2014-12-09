<?php namespace Api;
set_time_limit(0);
header('Content-Type:text/html; charset=utf-8');
use Input;
use DB;
use Response;
use ZipArchive;

/*  
    注册满31天的用户判断其班级数和学生数，不合格的转为学生账户
*/
class CoursewareController extends \BaseController {

    public function __construct()
    {
        
    }

    public function index()
    {
        
    }

    public function getColumn()
    {
        $info = array();
        $info['state'] = 1;
        $info[] = array('column_id' => 3, 'name' => '音基考级');
        $info[] = array('column_id' => 4, 'name' => '小学音乐测评');
        $info[] = array('column_id' => 5, 'name' => '中学音乐测评');
        return Response::json($info);
    }

    public function getList()
    {
        $query = Input::only('column_id');

        if($query['column_id'] == 3)
            $config_path = "/data/music_basic/";
        elseif ($query['column_id'] == 4)
            $config_path = "/data/primary_school/";
        elseif ($query['column_id'] == 5)
            $config_path = "/data/middle_school/";
        else
            return Response::json(array('error' => '错误的科目ID', 'state' => '-1'));

        if (!file_exists(public_path() . $config_path . "info.php"))
            $dir_info = array();
        else
            include_once public_path() . $config_path . "info.php";     //返回 $dir_info
        
        $dir_info['column_id'] = $query['column_id'];
        $dir_info['state'] = 1;
        return Response::json($dir_info);
    }

    public function getZip()
    {
        $query = Input::only('column_id', 'path');

        if($query['column_id'] == 3)
            $config_path = "/data/music_basic/";
        elseif ($query['column_id'] == 4)
            $config_path = "/data/primary_school/";
        elseif ($query['column_id'] == 5)
            $config_path = "/data/middle_school/";
        else
            return Response::json(array('error' => '错误的科目ID', 'state' => '-1'));

        $info = array();
        
        $dir = public_path() . $config_path . $query['path'];
        if( !is_dir($dir) )
        {
            $info['state'] = -2;
            $info['error'] = '错误的目录名';
            return Response::json($info);
        }

        $zip = new ZipArchive;
        $path = public_path() . '/temp/' . str_replace('/', '_', $query['path']) . '.zip';
        if ($zip->open($path) === TRUE && $zip->addEmptyDir($dir) )
        {
            $zip->close();

            $info['state'] = 1;
            $info['path'] = $path;

            return Response::json($info);
        }
        else
        {
            $info['state'] = -3;
            $info['error'] = '生成zip文件失败';

            return Response::json($info);
        }
        
    }


}
