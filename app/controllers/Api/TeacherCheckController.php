<?php namespace Api;
set_time_limit(0);
header('Content-Type:text/html; charset=utf-8');

use DB;
use User;
use Teacher;

/*  
    注册满31天的用户判断其班级数和学生数，不合格的转为学生账户
*/
class TeacherCheckController extends \BaseController {

    public function __construct()
    {
        
    }

    public function index()
    {
        // 时间点
        $t = date('Y-m-d', strtotime("-31 day"));
        // 查找老师
        $list = User::where('type', '=', 1)->where('created_at', '<', $t)->get();

        $teacher = new Teacher();
        foreach ($list as $val) 
        {
            $info = $teacher->checkTeacher($val->id);
            // 如果没有通过
            if($info['isCheck'] == 0)
            {
                User::where('id', $val->id)->update( array('type' => 0) );
                Teacher::where('tel', $val->tel)->update( array('status' => -1) );
            }
        }

        echo "完成！";
    }

}
