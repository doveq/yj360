<?php namespace Admin;
use View;
use Session;
use User;
use Validator;
use Input;
use Paginator;
use Redirect;
use Teacher;
use Attachments;

class TeacherController extends \BaseController {

    public $pageSize = 30;
    public $typeEnum = array('1' => '小学', '2' => '中学', '3' => '音基', '4' => '小学教研', '5' => '中学教研', '6' => '少年宫');
    public $statusEnum = array('1' => '有效', '-1' => '无效', '0' => '未审核');

    public function index()
    {
        Input::merge(array_map('trim', Input::all() ));
        $query = Input::only('name', 'tel', 'type', 'page', 'status');

        $teacher = new Teacher();
        $lists = $teacher->getList($query)->paginate($this->pageSize);

        // 判断显示教师证
        $user = new User();
        $atts = new Attachments();

        foreach ($lists as &$v) 
        {
            if(!empty($v->tel))
            {
                $uinfo = $user->getInfoByTel($v->tel);
                if( !empty($uinfo) )
                {

                    $route = $atts->getTeacherRoute($uinfo->id);
                    if( is_file($route['path']) )
                    {
                        $v->certificate = $route['url'];
                    }
                }
            }
        }

        $typeEnum = array('0' => '全部') + $this->typeEnum;
        $statusEnum = array('' => '全部') + $this->statusEnum;

        return $this->adminView('teacher.index', compact('lists', 'query', 'typeEnum', 'statusEnum'));
    }


    public function add()
    {
        $typeEnum = $this->typeEnum;
        $statusEnum = $this->statusEnum;
        return $this->adminView('teacher.add', compact('typeEnum', 'statusEnum'));
    }

    public function doAdd()
    {
        $info = Input::only('type', 'name', 'tel', 'qq', 'professional', 'address', 'school', 'status', 'province', 'city', 'district');

        $validator = Validator::make($info, array(
            'tel' => 'required|digits:11|unique:teacher_info')
        );

        if($validator->passes())
        {
            $teacher = new Teacher();
            $teacher->addInfo($info);
        }
        else
        {
            return $this->adminPrompt("操作失败", '手机号已经注册', $url = "teacher/add");
        }

        return $this->adminPrompt("操作成功", '信息添加成功！', $url = "teacher");
    }

    public function edit()
    {
        $id = Input::only('id');

        $teacher = new Teacher();
        $info = $teacher->getInfo($id)->first()->toArray();
        $typeEnum = $this->typeEnum;
        $statusEnum = $this->statusEnum;
        return $this->adminView('teacher.edit', compact('typeEnum', 'statusEnum', 'info'));
    }

    public function doEdit()
    {
        $info = Input::only('id', 'type', 'name', 'tel', 'qq', 'professional', 'address', 'school', 'status', 'province', 'city', 'district');

        $teacher = new Teacher();
        $id = $info['id'];
        unset($info['id']);
        $teacher->editInfo($id, $info);

        return $this->adminPrompt("操作成功", '信息编辑成功！', $url = "teacher");
    }

    public function doDel()
    {
        $id = Input::only('id');

        $teacher = new Teacher();
        $info = $teacher->delInfo($id);
        
        return $this->adminPrompt("操作成功", '信息删除成功！', $url = "teacher");
    }


    /* 根据老师表的信息修改用户表用户类型 */
    public function sync()
    {
        $teacher = new Teacher();
        $list = $teacher->getList()->get();
        foreach ($list as $val) 
        {
            $teacher->sycnUserInfo($val->tel, $val->status);
            echo $val->tel . '#' . $val->status . '<br>';
        }

        echo '完成~';
    }
}
