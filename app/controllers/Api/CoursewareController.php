<?php namespace Api;
set_time_limit(0);
header('Content-Type:text/html; charset=utf-8');

use DB;

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

}
