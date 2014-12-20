<?php namespace Admin;
use View;
use Session;
use User;
use Validator;
use Input;
use Paginator;
use Redirect;
use Student;


class StudentController extends \BaseController {

    public $pageSize = 30;
    public $typeEnum = array('1' => '小学', '2' => '中学', '3' => '音基', '4' => '小学教研', '5' => '中学教研', '6' => '少年宫');
    public $statusEnum = array('1' => '有效', '-1' => '无效', '0' => '未审核');

    public function index()
    {
        Input::merge(array_map('trim', Input::all() ));
        $query = Input::only('name', 'tel', 'type', 'page', 'status', 'retel', 'teacher');

        $student = new Student();
        $lists = $student->getList($query)->paginate($this->pageSize);

        $typeEnum = array('0' => '全部') + $this->typeEnum;
        $statusEnum = array('' => '全部') + $this->statusEnum;

        return $this->adminView('student.index', compact('lists', 'query', 'typeEnum', 'statusEnum'));
    }


    public function add()
    {
        $typeEnum = $this->typeEnum;
        $statusEnum = $this->statusEnum;
        return $this->adminView('student.add', compact('typeEnum', 'statusEnum'));
    }

    public function doAdd()
    {
        $info = Input::only('name', 'tel', 'class', 'address', 'school', 'status', 'teacher', 'retel');

        $validator = Validator::make($info, array(
            'tel' => 'required|digits:11|unique:student_info',
            'retel' => 'digits:11')
        );

        if($validator->passes())
        {
            $student = new Student();
            $student->addInfo($info);
        }
        else
        {
            return $this->adminPrompt("操作失败", '手机号已经注册', $url = "student/add");
        }

        return $this->adminPrompt("操作成功", '信息添加成功！', $url = "student");
    }

    public function edit()
    {
        $id = Input::only('id');

        $student = new Student();
        $info = $student->getInfo($id)->first()->toArray();

        $typeEnum = $this->typeEnum;
        $statusEnum = $this->statusEnum;
        return $this->adminView('student.edit', compact('typeEnum', 'statusEnum', 'info'));
    }

    public function doEdit()
    {
        $info = Input::only('id', 'name', 'tel', 'class', 'address', 'school', 'status', 'teacher', 'retel');

        $student = new Student();
        $id = $info['id'];
        unset($info['id']);
        $student->editInfo($id, $info);

        return $this->adminPrompt("操作成功", '信息编辑成功！', $url = "student");
    }

    public function doDel()
    {
        $id = Input::only('id');

        $student = new Student();
        $info = $student->delInfo($id);
        
        return $this->adminPrompt("操作成功", '信息删除成功！', $url = "student");
    }

    public function import()
    {
        return $this->adminView('student.import');
    }


    public function doImport()
    {
        $count = 0;
        $exists = array();  // 已经存在的
        $errors = array();  // 数据错误的

        if(isset($_FILES['csv']['error']) && $_FILES['csv']['error'] == UPLOAD_ERR_OK)
        {
            $student = new Student();

            if (($handle = fopen($_FILES['csv']['tmp_name'], "r")) !== FALSE) 
            {
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
                {

                    $dinfo = array();
                    $dinfo['name'] = trim( mb_convert_encoding($data[0], 'UTF-8', 'GBK') );
                    $dinfo['tel'] = trim( mb_convert_encoding($data[1], 'UTF-8', 'GBK') );
                    $dinfo['address'] = trim( mb_convert_encoding($data[2], 'UTF-8', 'GBK') );
                    $dinfo['school'] = trim( mb_convert_encoding($data[3], 'UTF-8', 'GBK') );
                    $dinfo['class'] = trim( mb_convert_encoding($data[4], 'UTF-8', 'GBK') );
                    $dinfo['teacher'] = trim( mb_convert_encoding($data[5], 'UTF-8', 'GBK') );
                    $dinfo['retel'] = trim( mb_convert_encoding($data[6], 'UTF-8', 'GBK') );
                    $dinfo['status'] = 1;

                    if(empty($dinfo['name']) && empty($dinfo['tel']) && empty($dinfo['address']) 
                        && empty($dinfo['school']) && empty($dinfo['class']) && empty($dinfo['teacher']) )
                    {
                        continue;
                    }

                    if(empty($dinfo['name']) || empty($dinfo['tel']) || empty($dinfo['address']) 
                        || empty($dinfo['school']) || empty($dinfo['class']) || empty($dinfo['teacher']) )
                    {
                        $errors[] = $dinfo;
                        continue;
                    }


                    if(!is_numeric($dinfo['tel']) || strlen($dinfo['tel']) != 11 )
                    {
                        $errors[] = $dinfo;
                        continue;
                    }
                    
                    $re = $student->addInfo($dinfo);
                    

                    if($re == 1)
                    {
                        $count += 1;
                    }
                    else
                    {
                        $exists[] = $dinfo;
                    }

                }
                fclose($handle);
            }
        }

        return $this->adminView('student.doImport', compact('count', 'exists', 'errors'));
    }

}
